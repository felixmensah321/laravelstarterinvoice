# Backend
ddev start -y

ddev exec php artisan key:generate

# bash .gitpod/import-db.sh
# bash .gitpod/import-files.sh

# Seed DB
ddev exec php artisan migrate

source $HOME/.nvm/nvm.sh
nvm install 18
nvm use 18
npm install
npx vite
# ddev exec npm run dev
