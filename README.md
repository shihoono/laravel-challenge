# docker-laravel

- Laravel Welcomeページ
http://127.0.0.1:10080

- PhpMyAdmin トップページ
http://127.0.0.1:8080

 ### clone後のセットアップ手順

1. $ docker-compose up -d --build

2. appコンテナに入る
$ docker-compose exec app bash

3. vendorディレクトリへライブラリ群をインストール
[app] $ composer install

4. composer install 時は .env 環境変数ファイルは作成されないので、 .env.example を元にコピーして作成する
[app] $ cp .env.example .env

5. .envにAPP_KEY=の値がないとのエラーが発生するので、下記コマンドでアプリケーションキーを生成する
[app] $ php artisan key:generate

6. マイグレーション実行
[app] $ php artisan migrate
