# 開発環境構築方法

----

## How to configure HTTPS
As there are differences in behavior between HTTP and HTTPS, HTTPS should be used as much as possible. 
In production, a load balancer is used, so it's important to develop with a configuration similar to that.

### ngrok
If configuration is troublesome, ngrok is recommended.
However, the free version changes the URL each time, so it's best to use the paid version.
It cannot be used offline. As connections are made to ngrok via HTTP, it's important not to handle personal or confidential information. Never use it in places such as Starbucks.

### haproxy
This can be used even in offline environments, but it's only prepared for Mac environments.

```shell
cd haproxy
./mac.sh local.mcf-dos.jp
```

これで、フロント側が https://local.mcf-dos.jp でアクセスできるようになります。
バックエンド側は、https://api.local.mdf-dos.jp でアクセスできるようになります。

Comment out the haproxy section in the docker-compose.yml.

## Database
The database setup includes the creation of a read replica.
Two containers, db_write and db_read, are created.
When developing, it's important to consider the read replica.


## Laravel

```bash
$ cd ../environments/local/
$ cp example/.env .env
$ cp example/docker-compose.yml docker-compose.yml
$ cp example/my-php.ini my-php.ini
$ docker-compose up -d
```
docker pullで制限に引っかかって失敗するときはdockerにログインしてやって下さい。


### プロジェクトが作られていない場合、最初の開発者のみ実行してください
```bash
# Only the first developer should run it. 
$ docker-compose exec php-fpm composer create-project --prefer-dist laravel/laravel . "10.*"
```

### Laravelのインストール

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
# if there's error, なら実行する
$ chmod -R 777 ./storage/
```

### .envをedit
(.env.example を参考にしてください)
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

## フロントエンド環境構築
/nuxt-app/README.md を参照してください。

----

### mailpit メールの受信
[http://localhost:8025](http://localhost:8025)

### minio
- minioの設定 [http://localhost:9001](http://localhost:9001)
- minioの説明 [./wiki/minio](https://github.com/commude/hoshi-iryou/wiki/minio)

### admin 管理画面
.envの以下の値をプレフィックスとして使う
```dotenv
ADMIN_PREFIX=cmd
```
[http://localhost/cmd/login](http://localhost/cmd/login)


#### admin ログイン
```
ログインID : (admins テーブルのメールアドレス)
パスワード : password
```

#### user ログイン
```
ログインID : (users テーブルの code)
パスワード : password
```

----

### フロントの構築(build)

```bash
cd src
npm ci # or npm install (if you don't have package-lock.json)
npm run build
```
