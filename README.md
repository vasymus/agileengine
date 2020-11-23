Laravel project
https://laravel.com

```
cp .env.example .env
```

Fill in `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in .env file

```
composer install
```

You can either run step by step

```
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan l5-swagger:generate
```

or run all command using
```
php artisan run-all
```

Test user will be created with id `1` and test user account will be create with id `1`

To view swagger follow `http://$your-local-domain/api/documentation`

