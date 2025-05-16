## Installation

```
$ docker compose up -d --build

$ sudo docker compose exec gsm-pay-app bash

$ cp .env.example .env

$ `cp .env.test.example .env.test`

$ composer install or composer install --ignore-platform-req=ext-exif

$ php artisan key:generate

$ php artisan jwt:secret

```

## Database

```

$ php artisan migrate:fresh --seed

```
## Swagger

```
$ chown -R $USER:www-data storage bootstrap/cache

$ chmod -R 775 storage bootstrap/cache

$ php artisan l5-swagger:generate

$ http://localhost:8088/api/documentation

```

## Test

```

$ php artisan test or composer test

```
