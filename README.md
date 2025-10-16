# Shortener
## Setup
1. cp .env.example .env
2. composer install
3. php artisan key:generate
4. set DB credentials in .env
5. php artisan migrate
6. php artisan storage:link
7. php artisan serve