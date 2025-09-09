# プロジェクト名（Task Management System Example）

# プロジェクト概要

社内問い合わせ管理を効率化する Laravel プロジェクトです。  
部門ごとの対応可否やログ管理、ユーザーアクセス制御（Gate）を実装しています

- **フロントエンド**: Blade, Tailwind CSS  
- **バックエンド**: Laravel 12.22.1, PHP 8.1.2 
- **データベース**: SQLite  



## 機能
- 部門ごとの問い合わせ振り分け
- IT, ソフトウェア, ハードウェア, ネットワーク部門のログ管理
- 対応可・対応不可の記録と履歴管理
- Gate によるユーザーアクセス制御
- 添付ファイル管理（ストレージに保存）

# 目的

ポートフォリオとしての公開

Laravel・PHP を用いた Web アプリ開発スキルの証明

認証・認可（Gate）の実装経験のアピール

# 使用技術

Backend: Laravel 12.22.1 (PHP 8.2.29 )

Frontend: Blade / TailwindCSS

Database: SQLite

認可: Laravel Gate

その他: Composer, Git, GitHub Actions

# 主な機能

ユーザー登録 / ログイン（認証機能）

Gate を用いた ロールベースのアクセス制御

管理者: ユーザー管理、全データへのアクセス権限

一般ユーザー: 自分のデータのみ閲覧・編集可能

CRUD 機能（データの作成・編集・削除）



# セットアップ方法

開発環境で動かす手順は以下の通りです。

### 前提条件
- Docker / Docker Compose がインストールされていること

# 1. リソースリポジトリをクローン
git clone https://github.com/Masaki173/dxflow_it_gate_resource.git
cd laravel_docker_sample
# 2. リソースフォルダ内にLaravelプロジェクトをクローン
git clone https://github.com/Masaki173/dxflow_it_gate.git
# 3. Docker コンテナ起動
   docker-compose up -d
# 4. コンテナに入りLaraveフォルダでLaravel セットアップ
   docker exec -it app bash
   cd laravel-project
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate

# Node 依存関係インストール＆ビルド
   npm install
   npm run dev


http://localhost:8000
 にアクセスして利用できます。(ポートの設定をご確認ください)

・挑戦したこと

Laravel Gate を用いた認可処理の設計・実装

MVC アーキテクチャの応用

データベースマイグレーション・シーディングによる効率的な開発

GitHub を用いたブランチ作業（main / develop）

## License

This project is a personal portfolio project for demonstrating Laravel, PHP, and Gate usage.  
It is not intended for public use or redistribution.
