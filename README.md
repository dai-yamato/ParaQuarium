<div align="center">
  <img src="public/favicon.svg" width="120" alt="ParaQuarium Logo">
  <h1>ParaQuarium</h1>
  <p><strong>水質・メンテナンスをスマートに管理できるアクアリウム専用ツール</strong></p>

  <!-- Badges -->
  <p>
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel">
    <img src="https://img.shields.io/badge/Livewire-3.x-FB70A9?style=flat-square&logo=livewire&logoColor=white" alt="Livewire">
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
    <img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=flat-square&logo=alpine.js&logoColor=white" alt="Alpine.js">
    <img src="https://img.shields.io/badge/PostgreSQL-4169E1?style=flat-square&logo=postgresql&logoColor=white" alt="PostgreSQL">
    <img src="https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white" alt="Docker">
  </p>
</div>

---

## 📖 概要 (Overview)
**ParaQuarium (パラクアリウム)** は、アクアリストのための高度な水質管理・メンテナンス記録アプリケーションです。
面倒なノートへのメモをデジタル化し、pH、水温、アンモニアなどのパラメータをクラウド上で管理・グラフ表示することで、美しい水景の維持とトラブルの未然防止をサポートします。

## ✨ 主な機能 (Features)
- **💧 水質パラメータの記録**: pH、水温、GH、KH、アンモニアなど、様々な項目を日次で記録。
- **📈 トレンドグラフ**: 記録した水質データをなめらかな折れ線グラフで自動描画（ApexCharts を使用）。
- **🛠 メンテナンスログ**: 水換え、フィルター掃除、薬浴などの作業履歴とメモを一元管理。
- **🐟 複数水槽の管理**: 淡水・海水問わず、複数の水槽ごとに独立したデータを追跡。
- **📱 レスポンシブUI**: Tailwind CSS をベースにした、モダンで美しいGlassmorphism(ガラス調)デザイン。

## 🛠 技術スタック (Tech Stack)
### バックエンド (Backend)
- **PHP** (v8.3+)
- **Laravel** (v11.x)
- **PostgreSQL** (v16.x)

### フロントエンド (Frontend)
- **Livewire 3** (動的コンポーネント)
- **Alpine.js** (軽量JavaScript)
- **Tailwind CSS** (スタイリング)
- **ApexCharts** (グラフ描画)
- **Lucide Icons** (アイコン)

### インフラ (Infrastructure)
- **Docker & Docker Compose** (開発環境)
- **Nginx** (Webサーバー)

---

## 🚀 開発環境の構築手順 (Getting Started)

本プロジェクトは Docker Compose を利用して簡単に開発環境を構築できます。

### 1. リポジトリをクローン
```bash
git clone https://github.com/your-org/paraquarium.git
cd paraquarium
```

### 2. 環境変数の設定
`.env.example` をコピーして `.env` を作成します。
```bash
cp .env.example .env
```
※ WSL環境などでUID/GIDを変更する場合は `.env` ファイル内の `WWWGROUP` と `WWWUSER` を適宜調整してください。

### 3. コンテナのビルドと起動
```bash
docker compose up -d --build
```

### 4. 依存関係のインストール＆セットアップ
コンテナが起動したら、Laravel側の初期設定を行います。
```bash
# Composer依存関係のインストール
docker compose exec app composer install

# アプリケーションキーの生成
docker compose exec app php artisan key:generate

# データベースのマイグレーション（テーブル作成）
docker compose exec app php artisan migrate

# NPMパッケージのインストールとビルド
docker compose exec app npm install
docker compose exec app npm run build
```

### 5. アプリケーションにアクセス
ブラウザで以下にアクセスしてください。
- **App URL**: [http://localhost/](http://localhost/)

（※新規に「登録」ボタンからユーザーを作成してダッシュボードをお使いください。）

---

## 🔒 ライセンス (License)

This project is proprietary software. All rights reserved by **(株)GooDy**.

&copy; {{ date('Y') }} (株)GooDy. Built with ❤️ and Laravel.
