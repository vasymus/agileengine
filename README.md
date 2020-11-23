Laravel project
https://laravel.com

```
cp .env.example .env
```

Fill in `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

```
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan l5-swagger:generate
```

Test user will be created with id: 1
