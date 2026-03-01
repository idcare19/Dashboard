# InfinityFree Deployment Guide (No Card)

This project includes ready-made InfinityFree files in:

- `infinityfree/public_html/index.php`
- `infinityfree/public_html/.htaccess`
- `infinityfree/public_html/.user.ini`

## 1) Prepare folder layout on InfinityFree

In your hosting account, create this structure (same level folders):

- `mydash_app/`  ← Laravel app core (everything except public_html files)
- `htdocs/` or `public_html/`  ← public web root

> On InfinityFree, the web root is usually `htdocs`.

## 2) Upload Laravel app core

Upload these folders/files to `mydash_app/`:

- `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, `storage/`, `vendor/`
- `artisan`, `.env`, `composer.json`, etc.

Do **not** expose these directly in `public_html`.

## 3) Upload public files

Upload contents of `infinityfree/public_html/` to your InfinityFree web root:

- `index.php`
- `.htaccess`
- `.user.ini`

Also copy assets from your Laravel `public/` folder into web root:

- `favicon.ico`
- `robots.txt`
- any built CSS/JS assets if present

## 4) Configure `.env`

Set your InfinityFree DB credentials in `.env` inside `mydash_app`:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://<your-domain>`
- `DB_CONNECTION=mysql`
- `DB_HOST=<InfinityFree MySQL host>`
- `DB_PORT=3306`
- `DB_DATABASE=<db_name>`
- `DB_USERNAME=<db_user>`
- `DB_PASSWORD=<db_password>`
- `SESSION_DRIVER=file`
- `CACHE_STORE=file`
- `QUEUE_CONNECTION=sync`

## 5) Ensure app key exists

If APP_KEY is empty, generate one locally and paste it into `.env`:

- `php artisan key:generate --show`

## 6) Database setup

If CLI/migrations are unavailable on InfinityFree:

1. Run migrations locally against a temporary MySQL database.
2. Export schema/data SQL using phpMyAdmin.
3. Import SQL into InfinityFree phpMyAdmin.

## 7) Permissions

Ensure these directories are writable:

- `storage/`
- `bootstrap/cache/`

## 8) Test routes

Open:

- `/` (portfolio page)
- `/up` (health endpoint)
- `/api/portfolio`

If you get "Laravel app path was not found", verify your core folder is:

- `../mydash_app` or `../mydash` relative to web root.
