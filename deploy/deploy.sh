#!/usr/bin/env bash
# Deploy para a HostGator via SSH + rsync.
# Uso local:                ./deploy/deploy.sh
# Ensaio (não altera nada): DRY_RUN=1 ./deploy/deploy.sh
# GitHub Actions:           SKIP_BUILD=1 DEPLOY_KEY_FILE=... ./deploy/deploy.sh
#
# Pré-requisitos: SSH habilitado no plano (porta 2222) com chave autorizada;
# build feito (deploy/build.sh roda automaticamente, salvo SKIP_BUILD=1).
#
# Nunca tocados no servidor: .env, storage/ (uploads e logs), public/storage
# (symlink), public/.well-known (AutoSSL) e FICHA_MAE_*.xlsx.
#
# Avisos do deploy LOCAL (o caminho principal é o GitHub Actions):
#  - envia o working tree como está — inclusive alterações não commitadas;
#  - o composer --no-dev do build remove as dependências de dev locais
#    (rode `composer install` depois para recuperá-las);
#  - o rsync do macOS é o openrsync da Apple: na PRIMEIRA vez rode com
#    DRY_RUN=1 e confira que nenhuma deleção cita storage/, .env ou .well-known.

set -euo pipefail
cd "$(dirname "$0")/.."

HOST="${DEPLOY_HOST:-162.241.2.126}"
PORT="${DEPLOY_PORT:-2222}"
USER="${DEPLOY_USER:-mutira90}"
APP_DIR="${DEPLOY_PATH:-/home2/mutira90/apps/mutirao}"
# CLI do PHP 8.5 do cPanel — o "php" puro do shell é a versão antiga do sistema
PHP_BIN="${DEPLOY_PHP:-/opt/cpanel/ea-php85/root/usr/bin/php}"
URL_SAUDE="${DEPLOY_HEALTH_URL:-https://app.mutiraonobem.org.br/up}"

case "${DEPLOY_KEY_FILE:-}" in *' '*) echo "ERRO: DEPLOY_KEY_FILE não pode conter espaços"; exit 1;; esac
SSH_CMD="ssh -p $PORT"
[ -n "${DEPLOY_KEY_FILE:-}" ] && SSH_CMD="$SSH_CMD -i $DEPLOY_KEY_FILE"

run_remote() { $SSH_CMD "$USER@$HOST" "$@"; }
reativar_site() { run_remote "cd $APP_DIR && $PHP_BIN artisan up" || true; }

if [ "${SKIP_BUILD:-0}" != "1" ] && [ "${DRY_RUN:-0}" != "1" ]; then
  ./deploy/build.sh
fi

test -f vendor/autoload.php || { echo "ERRO: vendor/ ausente — rode deploy/build.sh"; exit 1; }
test -f public/build/manifest.json || { echo "ERRO: public/build ausente — rode deploy/build.sh"; exit 1; }

RSYNC_OPTS=(-az --delete)
if [ "${DRY_RUN:-0}" = "1" ]; then
  echo "==> ENSAIO (dry-run): nada será alterado no servidor"
  RSYNC_OPTS=(-azvn --delete)
else
  echo "==> Ativando modo manutenção"
  run_remote "cd $APP_DIR && $PHP_BIN artisan down --retry=30 || true"
  trap 'echo "ALERTA: deploy falhou — reativando o site"; reativar_site' ERR
fi

echo "==> Sincronizando arquivos (rsync)"
# Ordem das regras importa: o include de .env.example vem antes do exclude .env*
rsync "${RSYNC_OPTS[@]}" \
  --include='.env.example' \
  --exclude='.env*' \
  --exclude='.git/' \
  --exclude='.github/' \
  --exclude='node_modules/' \
  --exclude='tests/' \
  --exclude='storage/' \
  --exclude='/public/storage' \
  --exclude='/public/hot' \
  --exclude='.well-known/' \
  --exclude='FICHA_MAE*' \
  --exclude='database/*.sqlite*' \
  --exclude='.DS_Store' \
  -e "$SSH_CMD" \
  ./ "$USER@$HOST:$APP_DIR/"

if [ "${DRY_RUN:-0}" = "1" ]; then
  echo "==> Ensaio concluído (nenhuma alteração foi feita no servidor)"
  exit 0
fi

echo "==> Migrations e caches"
run_remote "cd $APP_DIR \
  && $PHP_BIN artisan migrate --force \
  && $PHP_BIN artisan config:cache \
  && $PHP_BIN artisan route:cache \
  && $PHP_BIN artisan view:cache \
  && $PHP_BIN artisan up"

trap - ERR

echo "==> Verificando saúde do site"
sleep 2
if curl -fsS -o /dev/null --max-time 30 "$URL_SAUDE"; then
  echo "==> Deploy concluído: site no ar"
else
  echo "ALERTA: health check falhou — verifique $URL_SAUDE e storage/logs/laravel.log no servidor"
  exit 1
fi
