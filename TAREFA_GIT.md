SUA TAREFA: SUBIR E PREPARAR A ESTRUTURA PARA SUBIR NO GIT

Usuario Git: Reifz
Email Git: guilhermereif10@gmail.com

Status:
- .gitignore revisado para subir apenas o necessario.
- Dependencias locais, caches, logs, .env, banco SQLite local, uploads e arquivos de credenciais ficam fora do Git.
- O arquivo .env.example continua versionavel para servir de modelo de configuracao.

Arquivos/pastas ignorados importantes:
- .env e .env.*
- vendor/
- node_modules/
- public/build/
- public/storage/
- storage/logs/
- storage/framework/
- storage/app/public/
- database/*.sqlite
- credenciais*.md
- arquivos *_bkp*.php, *.bak, *.backup e *.tmp

Comandos para preparar o repositorio local:

```bash
git init
git config user.name "Reifz"
git config user.email "guilhermereif10@gmail.com"
git status --ignored
git add .
git commit -m "Initial commit"
```

Comandos manuais depois de criar o repositorio vazio no GitHub:

```bash
git branch -M main
git remote add origin https://github.com/Reifz/NOME_DO_REPOSITORIO.git
git push -u origin main
```

Depois de clonar em outro ambiente:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
```


//OBS DESENVOLVER//

echo "# SistemaOngMutiraoNoBem" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/Reifz/SistemaOngMutiraoNoBem.git
git push -u origin main

or push an existing repository from the command line

git remote add origin https://github.com/Reifz/SistemaOngMutiraoNoBem.git
git branch -M main
git push -u origin main