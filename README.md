# Nice Images Uploader

The website anyone can upload images.

## 前提

下記をインストール済みであること

- docker
- docker-compose

## 確認環境準備

設定ファイル準備

bash
```bash
git clone -b v7.1.2 https://github.com/laradock/laradock.git
# nginxの設定
mv laradock/nginx/sites/default.conf laradock/nginx/sites/default.conf.bk
cp misc/nginx/default.conf laradock/nginx/sites/default.conf
# コンテナの設定
cd laradock/
cp env-example .env
vim .env
```

.env
```diff
-APP_CODE_PATH_HOST=../
+APP_CODE_PATH_HOST=../homework

-MYSQL_VERSION=latest
+MYSQL_VERSION=5.7
```

```bash
vim docker-compose.yml
```

```diff
### Workspace Utilities ##################################
    workspace:
      {中略}
      ports:
        - "${WORKSPACE_SSH_PORT}:22"
+       - "3000:3000"
      ~ 省略 ~
```

立ち上げ

```bash
docker-compose up -d nginx mysql #数分かかる可能性
docker-compose exec --user=laradock workspace bash
mkdir -p ../homework/storage/app
```

laravel の初期設定

```bash
cp .env.example .env
composer install
artisan key:generate
artisan jwt:secret
artisan storage:link
artisan migrate:refresh --seed
yarn install
yarn run generate
```

完了後、下記で確認可能
http://localhost/


## 開発時

npm package の操作や、nuxt開発仮想サーバの立ち上げは、
基本的にworkspace内にログインし作業を行う

### nuxt開発仮想サーバの立ち上げ

```bash
docker-compose exec workspace bash

###### 下記からWorkspace内 ######
su laradock
yarn run dev
```

### nuxt genearate

```bash
docker-compose exec workspace bash

###### 下記からWorkspace内 ######
su laradock
npm run generate
```
