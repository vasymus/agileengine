Laravel project
https://laravel.com

Installation requirements <a href="https://laravel.com/docs/8.x/installation">here</a>

Public directory should be `/path-to-project/public`

Loaded php extensions (not all required) <a href="https://i.imgur.com/QznJv0O.png">https://i.imgur.com/QznJv0O.png</a>

Download <a href="https://drive.google.com/file/d/1vmootC8Qn0v4lC0anzrYIthry-ZH4UWZ/view?usp=sharing">html file</a> and see phpinfo

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

Test user will be created with id `1` and test user account will be create with id `1`. There will be also 1000 test transaction seeds.

To view swagger follow `http://$your-local-domain/api/documentation`

