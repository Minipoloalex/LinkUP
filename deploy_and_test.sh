#!/bin/bash

set -e

php artisan route:clear
php artisan cache:clear
php artisan config:clear

npm run build

docker login git.fe.up.pt:5050
./upload_image.sh
# docker run -it -p 8000:80 --name=lbaw2351 -e DB_DATABASE="lbaw2351" -e DB_SCHEMA="lbaw232451" -e DB_USERNAME="lbaw2351" -e DB_PASSWORD="RuUkOYNh" git.fe.up.pt:5050/lbaw/lbaw2324/lbaw2351
