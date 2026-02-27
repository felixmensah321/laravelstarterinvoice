
# Start DDEV
ddev start -y
mkcert -install

# Node

source $HOME/.nvm/nvm.sh
nvm install 18

# ddev
export APP_URL_8080=$(gp url 8080)
export APP_URL_8000=$(gp url 8000)

# App
cp .env.gitpod .env
ddev composer install --no-interaction

# Bookmark done
gp sync-done ddev

# This has to be source not bash 
# https://superuser.com/questions/176783/what-is-the-difference-between-executing-a-bash-script-vs-sourcing-it

echo "
********
Run the following command in your terminal to add port fowarding agent to your context. 
This will allow you to deploy to remote servers. 

source .gitpod/add-ssh-forwarding.sh

" 
