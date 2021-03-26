# ミニオークションサイト

<img width="1430" alt="Auction-top" src="https://user-images.githubusercontent.com/64389296/112598912-939e0000-8e52-11eb-856e-6c40768d3e1a.png">
<img width="1435" alt="Auction-login" src="https://user-images.githubusercontent.com/64389296/112598939-9a2c7780-8e52-11eb-8a21-833040d906e6.png">

### URL

- ログインページ
https://auction.shiholab.com/login
(管理者用メールアドレス:user@example.com / パスワード:00000000 でログインできます。会員制のオークションサイトで、管理者のみユーザーの追加が可能な仕組みになっています。）

### 使用技術
- Laravel6.0
- PHP7.4
- HTML5
- CSS3
- Bootstrap
- MySQL8.0
- Docker
- AWS
  - EC2(Amazon Linux2)
  - Route53
  - ACM
  - ELB

 ### セットアップ手順

1. mainブランチをチェックアウトする

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

8. 画像ファイルの表示のため、シンボリックリンクをはる
```
[app] $ php artisan storage:link
```

9. Usersテーブルのシーダー（最初の管理者ユーザーデータ）を実行する
```
[app] $ php artisan db:seed
```

### アプリをブラウザで表示する

- トップページ（ログインページ）
http://127.0.0.1:10080

- PhpMyAdmin トップページ
http://127.0.0.1:8080
