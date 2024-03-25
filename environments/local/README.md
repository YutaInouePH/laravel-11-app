# 開発環境構築方法

----

## Laravel

```bash
$ cp .env.example .env
$ docker-compose up -d
```
If there are any access error when `docker pull` command is executed, try logging in docker.


### Laravel installation

```bash
# if installed
docker compose exec php-fpm composer install
$ cd ../../src
$ cp .env.example .env
$ cd ../environments/local/
$ docker-compose exec php-fpm php artisan key:generate
```

### Laravel Windows

```
# if installed
docker-compose exec php-fpm composer install

# if there's error 「the input device is not a TTY. If you are using mintty, try prefixing the command with 'winpty'」
# do the following
winpty docker-compose exec php-fpm composer install

# first time only
cd ../../src
cp .env.example .env
cd ../environments/local/
winpty docker-compose exec php-fpm php artisan key:generate
```

### Permission
```bash
# if there's error,
$ chmod -R 777 ./storage/
```

### edit .env
(take note of .env.example)
```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=default
DB_PASSWORD=secret
```

### Migration
```bash
$ cd ../environments/local/
$ docker compose exec php-fpm bash
/var/www# php artisan migrate:fresh --seed
```

### Dummy data
```bash
# development only
$ cd ../environments/local/
$ docker-compose exec php-fpm bash
/var/www# php artisan db:seed --class=DummyDatabaseSeeder
```

## Frontend Development (Nuxt 3)

check nuxt-app/README.md 

----
