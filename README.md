<a href="https://laravel.com">Laravel project</a> and <a href="https://github.com/aschmelyun/docker-compose-laravel">docker-compose-laravel configuration</a>

<h2>In short:</h2>
<h3>First time run commands for deploying: copy and paste to the terminal (if fails use sudo):</h3>
```
docker-compose up -d --build site && \
docker-compose run --rm composer install && \
docker-compose run --rm artisan run-all && \
docker-compose run --rm artisan l5-swagger:generate && \
docker-compose run --rm artisan queue:work
```

All following deploying commands: copy and paste in to the terminal (if fails use sudo):
```
docker-compose up -d --build site && \
docker-compose run --rm artisan run-all && \
docker-compose run --rm artisan l5-swagger:generate && \
docker-compose run --rm artisan queue:work
```

<h2>More detailed description</h2>

Installation requirements <a href="https://laravel.com/docs/8.x/installation">here</a>

Command
```
php artisan run-all
```
could be run separately:
```
docker-compose run --rm artisan key:generate
docker-compose run --rm artisan migrate
docker-compose run --rm artisan db:seed
docker-compose run --rm artisan l5-swagger:generate
```


Test user will be created with id `1` and test user account will be create with id `1`. There will be also 1000 test transaction seeds.

To view swagger follow `http://$your-local-domain/api/documentation`

<h3>Please, note</h3>
There is also an alternate approach in executing of this task. In order to view it run `git fetch && git checkout threading-variation` and (just to be sure everything work properly) run
```
docker-compose down
```
and then again run deploying commands mentioned above.
