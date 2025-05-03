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

5. Docker Compose の起動

```
docker-compose up -d
```
