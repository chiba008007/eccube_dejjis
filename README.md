# eccube_dejjis

### トップページ

`http://localhost/`

### 管理画面

`http://localhost/admin/login`

- ID : admin
- PW : password

### Docker Desktop、MySQL 8.0、PHP 8.0、EC-CUBE 4.2 での開発環境構築手順

### フォルダ・ファイル構成
- wslに作成(windowsに作ると重いので)

eccube<br>
┣ html ← eccube のファイルを設置<br>
┣ docker-compose.yml<br>
┣ Dockerfile <br>
┣ entrypoint.sh ← ECCubeの非対話式インストールを行う(失敗したらコマンドを実行下記参照)<br>
┣ init.sql ← 権限設定<br>
┣ .dockerignore<br>
┣ xdebug.ini ← 空にしている<br>
┗ php.ini ← phpの設定+xdebugの設定<br>

※ php.iniにxdebugの設定を記載している件について
- xdebug.iniに記載して実行すると失敗してしまった。
- おそらくxdebug.iniとphp.iniで分割するとよいかと思います。
(そのためxdebugはコメントにしている)

※ maker.yamlを以下に配置することでコントローラー・entity作成コマンドでcustomizeフォルダ以下に生成されるように修正。生成コマンドは以下参照(synfornyコントローラーの作成)
```
html/app/config/eccube/packages/dev/maker.yaml
```

### xdebugのインストールについて
- docker-compose.ymlに追記済み
- php.ini ← xdebugの設定について記載
- .vscode/launch.json ← xdebugのlaunch


### 手順
- EC-CUBE 4.2 開発環境構築手順 (Docker Desktop).docx [参照](https://github.com/t-chiba008007/eccube-document/raw/refs/heads/main/EC-CUBE%204.2%20%E9%96%8B%E7%99%BA%E7%92%B0%E5%A2%83%E6%A7%8B%E7%AF%89%E6%89%8B%E9%A0%86%20(Docker%20Desktop).docx)

- Docker + PHP + Xdebug + VS Code デバッグ環境構築手順書.docx [参照](https://github.com/t-chiba008007/eccube-document/raw/refs/heads/main/Docker%20+%20PHP%20+%20Xdebug%20+%20VS%20Code%20%E3%83%87%E3%83%90%E3%83%83%E3%82%B0%E7%92%B0%E5%A2%83%E6%A7%8B%E7%AF%89%E6%89%8B%E9%A0%86%E6%9B%B8.docx)

```



**ログファイルの確認方法:**

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

**xdebugログファイルの確認方法:**

`/tmp/xdebug.loh`を参照



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

### .envファイルについて

```
# この状態を確認
APP_ENV=prod
APP_DEBUG=0


# mysqlを使うように id:root pw:rootにしてある
DATABASE_URL=mysql://root:root@mysql8:3306/eccube?serverVersion=8.0

```


## プロジェクトに PHP CS Fixer を追加する
```
composer require --dev friendsofphp/php-cs-fixer
touch .php-cs-fixer.php
・VSCode に拡張機能を入れる
```
- VSCode の設定をする
  - VSCode の Ctrl + Shift + P を押す
  - 「Preferences: Open Settings (JSON)」を選ぶ
  - settings.jsonの修正
```
{
  "php-cs-fixer.executablePath": "${workspaceFolder}/vendor/bin/php-cs-fixer",
  "php-cs-fixer.onsave": true,
  "php-cs-fixer.rules": "@PSR12",
  "php-cs-fixer.autoFixBySave": true
}
```

## synfonyのルーティングの確認 ##
- コンテナから実施

`bin/console debug:router`


## synfornyコントローラーとテンプレート作成
- コンテナからコマンド実施
`bin/console make:controller`
- 対話式 → コントローラ名を入力

```
 Choose a name for your controller class (e.g. DeliciousChefController):<br>
 > HelloController<br>
<br>
 created: app/Customize/Controller/HelloController.php<br>
 created: templates/hello/index.html.twig<br>

 ```

## synfornyのEntityとRepositoryの作成
- コンテナからコマンド実施
`bin/console make:entity`
- 対話式 → コントローラ名を入力

## migrateファイルの生成と実施
php bin/console make:migration
php bin/console doctrine:migrations:migrate


## 資料
`https://github.com/t-chiba008007/eccube-document`
 - Update Docker + PHP + Xdebug + VS Code デバッグ環境構築手順書.docx
 - EC-CUBE 4.2 開発環境構築手順 (Docker Desktop).docx