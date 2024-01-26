# Installation

1. cp .env.example .env
2. touch database/database.sqlite
3. composer install
4. php artisan key:generate
5. php artisan migrate --seed
6. php artisan make:filament-user
Type admin name, email and password
7. php artisan shield:install
Choose 'Yes'/'Yes', then provide your admin id
Delete newly created policies within App/Policies directory
8. php artisan serve
Go to http://127.0.0.1:8000/admin and log in
