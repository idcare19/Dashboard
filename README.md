<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Deploy on Render (Directly Live)

This project includes a production-ready `render.yaml` for one-click Blueprint deploy.

### What it configures

- PHP web service
- PostgreSQL database
- Auto migrations on start
- Config / route / view cache warmup on start
- HTTPS-aware URL generation
- Rate limiting on auth/contact/access endpoints

### Steps

1. Push this project to GitHub.
2. In Render, choose **New +** → **Blueprint**.
3. Select your repo.
4. Render will read `render.yaml` and create:
	- `mydash-web` (web service)
	- `mydash-db` (PostgreSQL)
5. Set `APP_URL` in Render environment to your Render domain.
6. Deploy.

### Seeding in production (safe-by-default)

- Production seeding is disabled by default.
- To seed intentionally in production, set:
	- `ALLOW_PRODUCTION_SEED=true`
	- `SEED_ADMIN_EMAIL`, `SEED_ADMIN_PASSWORD`
	- `SEED_USER_EMAIL`, `SEED_USER_PASSWORD`
- Then run seed manually from shell / job.

> ✅ No default public admin credentials are shipped anymore.

### Temporary access flow (1 hour)

- Non-admin users can request temporary dashboard access via **Request Access**.
- Admin approves request and generates an access key.
- Key is valid for 1 hour and can be used to open dashboard preview.

## API for Vercel Frontend + Render Backend

You can host your frontend on Vercel and this Laravel app on Render as an API backend.

### Base URL

- Local: `http://127.0.0.1:8000`
- Render: `https://<your-render-service>.onrender.com`

### Endpoints

- `GET /api/portfolio`
	- Returns all public portfolio fields as JSON.
- `POST /api/contact`
	- Accepts JSON body:
		- `name` (string, required)
		- `email` (valid email, required)
		- `message` (string, required)

### CORS

Set this environment variable on Render:

- `CORS_ALLOWED_ORIGINS=https://idacre19.vercel.app`

Also recommended on Render:

- `FORCE_HTTPS=true`
- `SESSION_SECURE_COOKIE=true`
- `DB_SSLMODE=require`

For multiple origins, separate by commas.

### Example frontend fetch

- Portfolio fetch: call `GET /api/portfolio` and use `response.data`.
- Contact submit: call `POST /api/contact` with JSON body and `Content-Type: application/json`.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
