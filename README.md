### Running Using Docker

```sh
docker-compose up -d db
docker-compose build
docker-compose exec -T app php artisan key:generate
docker-compose exec -T app composer install
docker-compose exec -T app php artisan migrate
docker compose up
```
