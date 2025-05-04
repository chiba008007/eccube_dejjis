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

## トラブルシューティング (Troubleshooting)

- **エラー:** `An exception occurred while executing a query: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'eccube.dtb_base_info' doesn't exist`

  - **考えられる原因:** EC-CUBE のインストールが完了していない、データベースが正しく初期化されていない、`.env` ファイルのデータベース接続情報が間違っている。
  - **解決策・対処法:**
    1.  ブラウザから `http://localhost/install.php` にアクセスして、EC-CUBE のインストールを再実行してください。
    2.  コンテナ内で以下のコマンドを実行して、データベースのマイグレーションと初期データ投入を試してください。
        ```bash
        docker exec -it php8 bash
        cd /var/www/html
        php bin/console doctrine:migrations:migrate --env=dev -n
        php bin/console eccube:fixtures:load --env=dev -n
        exit
        ```
    3.  `.env` ファイルの `DATABASE_URL` が `mysql://eccube:eccube@db:3306/eccube?serverVersion=8.0` のように、正しい MySQL 接続情報になっているか確認してください。
  - **確認ポイント:** インストール画面が表示されるか、コンソールコマンドがエラーなく完了するか、データベース接続情報が正しいか。

- **エラー:** `localhost で接続が拒否されました。`

  - **考えられる原因:** Web サーバー (Apache) が起動していない、ホストマシンのポート 80 が別のアプリケーションで使用されている、ファイアウォールで接続がブロックされている。
  - **解決策・対処法:**
    1.  ターミナルで `docker ps` を実行し、`php8` コンテナの状態が `Up` であることを確認してください。
    2.  ターミナルで `docker logs php8` を実行し、コンテナのログにエラーがないか確認してください。
    3.  ホストマシンのポート 80 を使用しているプロセスを特定し、停止してください（`netstat -ano | findstr :80` (Windows) または `sudo lsof -i :80` (macOS/Linux)）。
    4.  ホストマシンのファイアウォールの設定を確認し、ポート 80 への接続を許可してください。
  - **確認ポイント:** コンテナが `Up` になっているか、ログにエラーがないか、ポート 80 が他のプロセスで使用されていないか、ファイアウォールでブロックされていないか。

- **エラー:** `The process "'bin/console' 'doctrine:schema:drop' '--force'" exceeded the timeout of 60 seconds.`

  - **考えられる原因:** MySQL サーバーの負荷が高い、コンテナのリソース不足。
  - **解決策・対処法:** Docker Desktop の設定で、`php8` コンテナと `mysql8` コンテナに割り当てる CPU とメモリを増やしてみてください。
  - **確認ポイント:** タイムアウトエラーが解消されるか。

- **エラー:** `/usr/bin/env: 'php\r': No such file or directory`
  - **考えられる原因:** スクリプトファイルの改行コードが Windows 形式 (CRLF) になっている。
  - **解決策・対処法:** ホストマシン上の該当ファイル（`entrypoint.sh`、`bin/console` など）をテキストエディタで開き、改行コードを Unix (LF) 形式に変換して保存してください。Git Bash を使用している場合は `dos2unix <ファイル名>` コマンドも有効です。
  - **確認ポイント:** エラーが解消されるか。

**ログファイルの確認方法:**

- **目的:** コンテナ内で実行されているアプリケーションやサービスのログを確認し、エラーや警告などの情報を得るために使用します。
- **手順:**
  1.  ターミナルを開きます。
  2.  以下のコマンドを入力して Enter キーを押します。`<コンテナ名>` の部分には、ログを確認したいコンテナの名前（例: `php8`、`mysql8`）を指定します。
      ```bash
      docker logs <コンテナ名>
      ```
  3.  リアルタイムでログを追跡したい場合は、`-f` オプションを追加します。
      ```bash
      docker logs -f <コンテナ名>
      ```
  4.  ログの特定の行数だけを表示したい場合は、`--tail` オプションを使用します。
      ```bash
      docker logs --tail 50 <コンテナ名>
      ```

**コンテナへの入り方:**

- **目的:** 起動している Docker コンテナ内でコマンドを実行したり、ファイルシステムを操作したりするためにコンテナに入ります。
- **手順:**
  1.  ターミナルを開きます。
  2.  以下のコマンドを入力して Enter キーを押します。`<コンテナ名>` の部分には、操作したいコンテナの名前（通常は `php8` や `mysql8` など、`docker-compose.yml` で定義した `container_name`）を指定します。
      ```bash
      docker exec -it <コンテナ名> bash
      ```
  3.  コマンドプロンプトが `root@<コンテナID>:/...#` のように変化したら、コンテナ内に入れています。
  4.  コンテナから出るには、`exit` コマンドを入力して Enter キーを押します。

**ファイルコピーの方法:**

- **目的:** ホストマシンと Docker コンテナ間でファイルをコピーするために使用します。設定ファイルやログファイルなどをやり取りする際に便利です。
- **手順:**
  - **ホストマシンからコンテナへコピー:**
    ```bash
    docker cp <ホスト側のファイルのパス> <コンテナ名>:<コンテナ内のコピー先のパス>
    ```
  - **コンテナからホストマシンへコピー:**
    ```bash
    docker cp <コンテナ名>:<コンテナ内のファイルのパス> <ホスト側のコピー先のパス>
    ```

**改行コード変換の手順:**

- **目的:** Windows (CRLF) と Unix/Linux (LF) で異なる改行コードを変換し、予期せぬエラーを防ぎます。特にスクリプトファイル (`.sh`) や設定ファイル (`.ini`, `.env` など) で重要になります。
- **手順 (一般的な方法):**
  - **Visual Studio Code (VS Code) を使用する場合:** ファイルを開き、右下の行末表示をクリックして「LF」を選択し、保存します。
  - **Notepad++ を使用する場合:** ファイルを開き、「編集」→「行末の変換」→「Unix (LF)」を選択し、保存します。
  - **Git Bash (Windows/macOS/Linux) を使用する場合:** ターミナルで `dos2unix <ファイル名>` コマンドを実行します。
