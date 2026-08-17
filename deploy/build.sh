#!/usr/bin/env bash
# Build de produção: dependências PHP + assets do Vite.
# Requisitos locais: PHP 8.4+, Composer e Node 22 (via mise).
set -euo pipefail
cd "$(dirname "$0")/.."

command -v composer >/dev/null || { echo "ERRO: composer não encontrado (brew install composer)"; exit 1; }
command -v npm >/dev/null || { echo "ERRO: npm não encontrado (mise use node@22)"; exit 1; }

echo "==> composer install (produção)"
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> build dos assets (vite)"
npm ci
npm run build
# Remove resíduo do modo dev do Vite: se este arquivo for parar em produção,
# o site passa a buscar assets em localhost:5173 e quebra para os visitantes.
rm -f public/hot

# Registra a versão exibida na tela de login (o CI sobrescreve com a versão
# exata do release; localmente usa o git describe, ex.: 1.0.0-3-gabc123)
git describe --tags --always 2>/dev/null | sed 's/^v//' > VERSION || echo 'dev' > VERSION
echo "==> versão: $(cat VERSION)"

test -f vendor/autoload.php || { echo "ERRO: vendor/ não foi gerado"; exit 1; }
test -f public/build/manifest.json || { echo "ERRO: public/build não foi gerado"; exit 1; }
echo "==> build OK"
