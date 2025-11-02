Проект медицинского блога на PHP Laravel

copy .env.example to .env
DB_PASSWORD=12345678

npm install 
php artisan composer install 
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh
php artisan db:seed
