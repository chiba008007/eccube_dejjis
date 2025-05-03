# eccube_dejjis

### トップページ

`http://localhost/`

### 管理画面

`http://localhost/admin/login`

- ID : admin
- PW : password

### Docker Desktop、MySQL 8.0、PHP 8.0、EC-CUBE 4.2 での開発環境構築手順

### フォルダ・ファイル構成

eccube<br>
┣ html ← eccube のファイルを設置<br>
┣ docker-compose.yml<br>
┣ Dockerfile<br>
┣ entrypoint.sh<br>
┣ init.sql<br>
┗ php.ini<br>

### 手順

1. まず、Docker Desktop がインストールされている必要があります。まだインストールされていない場合は、以下の公式サイトからダウンロードしてインストールしてください。

   [Docker Desktop for Mac and Windows](https://www.docker.com/products/docker-desktop/)

2. Docker Compose の設定ファイル作成 (docker-compose.yml)
   プロジェクトのルートディレクトリに docker-compose.yml というファイルを作成し、以下の内容を記述します。

- 取得されるファイルに含まれます

3. PHP の設定ファイル作成 (php.ini)
   必要に応じて、PHP の設定をカスタマイズするために php.ini ファイルをプロジェクトのルートディレクトリに作成します。例えば、メモリ制限やタイムゾーンなどを設定できます。

   ※ 今回は git から取得したファイルを確認

4. EC-CUBE 4.2 のダウンロードと配置
   EC-CUBE 4.2 の本体を公式サイトからダウンロードし、解凍したファイルを html ディレクトリに配置します。

   ※ 今回は git から取得したファイルを確認

5. Docker Compose の起動(PS で実行)

```
docker-compose up -d
```

6. Docker の状態確認

- 下記コマンド
  `docker ps`

下記のような形で表示されます。

```
CONTAINER ID   IMAGE               COMMAND                   CREATED          STATUS                             PORTS                               NAMES
5e57003dd4f3   eccube_dejjis-web   "apache2-foreground"      12 seconds ago   Up 11 seconds (healthy)            0.0.0.0:80->80/tcp                  php8
cebb1a322dd7   mysql:8.0           "docker-entrypoint.s…"   12 seconds ago   Up 11 seconds (health: starting)   0.0.0.0:3306->3306/tcp, 33060/tcp   mysql8
```

## エラーが出たときの確認

- ブラウザにアクセスしたときに Composer is not installed.が表示される

  - EC-CUBE 4.2 のインストールに必要な PHP の依存管理ツールである Composer が、PHP コンテナ内にインストールされていない

  1. PHP コンテナへの接続 - 起動している php8 コンテナに接続します。以下のコマンドを PowerShell で実行します。
     `docker exec -it php8 bash`

  2. Composer のダウンロードとインストール - コンテナ内の bash シェルで、以下のコマンドを順番に実行して Composer をダウンロードし、インストールします。
     `composer -V`を実行し、バージョン情報が表示されなかった場合は下記コマンドで composer をインストールする。`composer install`を実行する

  ```
  apt-get update
  apt-get install -y wget php-cli php-zip unzip
  wget https://getcomposer.org/installer -O composer-setup.php
  php composer-setup.php --install-dir=/usr/local/bin --filename=composer
  rm composer-setup.php
  ```

- システムエラーが発生しました。大変お手数ですが、サイト管理者までご連絡ください。が表示される

  - 以下の手順で、データベースの状態を確認し、必要であれば手動で初期化を試みてください。

    1. MySQL コンテナに入ってデータベースを確認:
       まず、MySQL コンテナに入り、データベースの状態を確認します。

    ```
    docker exec -it mysql8 bash
    mysql -u root -p${MYSQL_ROOT_PASSWORD}
    ```

    2. スキーマの作成を行う

    ```
    php bin/console doctrine:schema:create --env=prod -n
    ```

    下記のような結果が取得される

    ```
     !
     ! [CAUTION] This operation should not be executed in a production environment!
     !

     Creating database schema...

     [OK] Database schema created successfully!

    ```

    3. 初期データの投入:

    - スキーマ作成後、初期データを投入するコマンドを実行します。

    ```
    php bin/console eccube:fixtures:load --env=prod -n
    ```

    下記のような結果が表示されます

    ```
    > Finished Successful!
    ```

    4. キャッシュのクリア

    ```
    php bin/console cache:clear --no-warmup --env=prod
    php bin/console cache:warmup --env=prod
    ```

    下記のような結果が表示されます

    ```
     [OK] Cache for the "prod" environment (debug=false) was successfully warmed.
    ```

    5. マイグレーションの再実行

    ```
    php bin/console doctrine:migrations:migrate --env=prod -n
    ```

    - 必要なテーブルが作成され、マイグレーションが正常に実行されるはずです。

- このサイトにアクセスできません localhost  で接続が拒否されました。 が表示される

  - コマンドプロンプト を管理者として開きます。
  - 以下のコマンドを実行して、ポート 3306 をリッスンしているプロセスを確認します(PS で実行)
    `netstat -ano | findstr :3306`
  - タスクマネージャー を開き、「詳細」タブでメモした PID のプロセスを探し、「タスクの終了」をクリックしてそのプロセスを停止します。

- 権限の設定 (必要な場合)
  - Composer のインストール後に、EC-CUBE が正常に動作するために特定のディレクトリに書き込み権限が必要になる場合があります。もしインストール後にエラーが発生するようでしたら、以下のコマンドで権限を設定してみてください。

```

    chmod -R 777 var/ cache/ log/

```

## エラー修正変更後、Docker Compose を再起動します。(PS で実行)

```

docker-compose down
docker-compose up -d

```

## Dockerfile・docker-compose.yml 等の設定ファイルを修正した際

```

docker-compose build --no-cache
docker-compose up -d

```
