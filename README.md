# docker-laravel

<<<<<<< HEAD
- Laravel トップページ
=======
- オークションサイト　トップページ（ログインページ）
>>>>>>> fix2/auction-base
http://127.0.0.1:10080

- PhpMyAdmin トップページ
http://127.0.0.1:8080

 ### セットアップ手順

1. このリポジトリの feature/auction-base ブランチをチェックアウトする

2. docker-compose.yml があるディレクトリで下記のコマンドを実行する
```
$ docker-compose up -d --build
```

3. 起動中の app コンテナの bash を実行する
```
$ docker-compose exec app bash
```

4. vendorディレクトリへライブラリ群をインストール
```
[app] $ composer install
```

5. composer install 時は .env 環境変数ファイルは作成されないので、 .env.example を元にコピーして作成する
```
[app] $ cp .env.example .env
```

6. .envにAPP_KEY=の値がないとのエラーが発生するので、下記コマンドでアプリケーションキーを生成する
```
[app] $ php artisan key:generate
```

7. マイグレーション実行
```
[app] $ php artisan migrate
```

<<<<<<< HEAD
=======
8. 画像ファイルの表示のため、シンボリックリンクをはる
```
[app] $ php artisan storage:link
```
>>>>>>> fix2/auction-base
