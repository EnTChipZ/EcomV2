# JEAP

Philippine multi-vendor marketplace with in-house logistics. Laravel 12, Sanctum, Spatie roles, Blade storefront.

Do not commit `.env`, API keys, or personal seed data. Copy `.env.example` to `.env` locally.

## Run locally

1. PHP 8.2+ (8.3+ recommended), Composer, Node, MySQL 8 / MariaDB.
2. Copy `.env.example` to `.env` and set `DB_*`.
3. Install and migrate:

```
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve --port=8080
```

Open http://127.0.0.1:8080

After `php artisan migrate --seed`, demo staff accounts use `SEED_USER_PASSWORD` from your local `.env` (default in seeder is only for local development). Do not use those passwords on a public domain.

Pending users cannot log in. Couriers are approved by logistics; everyone else by admin.

## Queues

Redis is preferred. This machine uses `QUEUE_CONNECTION=database` because Redis/phpredis is not installed. Switch later with `QUEUE_CONNECTION=redis`.

## Payments

Only `CodGateway` is implemented. Other providers must be extra `PaymentGateway` classes.

## Flutter

Not started. Reuse `/api/v1`.
