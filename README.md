# ローカル環境構築

## DB作成
・以下sqlを実行して接続先のDBを作成
```sql
CREATE DATABASE `sl_shop_db_test`
	DEFAULT CHARSET utf8mb4
	DEFAULT COLLATE utf8mb4_bin
;

USE `sl_shop_db_test`;
```

## 開発環境構築手順
1. リポジトリを`c:/xampp/htdocs`直下にclone

2. 以下コマンドでライブラリをインストール
```bash
composer install
```

3. 以下コマンドで`.env`を作成
```bash
cp .env.example .env
```

4. 以下コマンドでアプリケーションキー生成
```bash
php artisan key:generate
```

5. 以下コマンドでテーブルとデータを作成
```bash
php artisan migrate
php artisan db:seed
```

## DBデータリセット方法
・以下コマンドでDBデータをリセット
```bash
php artisan migrate:refresh --seed
```