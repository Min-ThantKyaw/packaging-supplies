# Setup & Development Instructions

## 1. Prerequisites

| Tool | Version | Check |
|------|---------|-------|
| PHP | 8.2+ | `php -v` |
| Composer | 2.x | `composer -V` |
| Node.js | 20.x+ | `node -v` |
| npm | 10.x+ | `npm -v` |
| MySQL | 8.x | `mysql --version` |

## 2. Repository Layout

```
packaging-supplies/
├── backend/          # Laravel application (API + admin + seeders)
├── frontend/         # React + TypeScript (Vite) SPA
└── docs/             # this documentation set
```

## 3. Backend Setup (Laravel)

```bash
cd backend

# 1. Install dependencies
composer install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=packaging_supplies
#    DB_USERNAME=root
#    DB_PASSWORD=

# 4. Run migrations + seeders
php artisan migrate --seed

# 5. Start dev server
php artisan serve        # http://localhost:8000
```

### Backend scripts

```bash
php artisan test                # run tests
php artisan route:list          # list API routes
php artisan make:model Foo -m   # create model + migration
php artisan migrate:rollback    # rollback last migration
php artisan db:seed             # re-run seeders
```

## 4. Frontend Setup (React + Vite)

```bash
cd frontend

# 1. Install dependencies
npm install

# 2. Start dev server
npm run dev            # http://localhost:5173

# 3. Production build
npm run build

# 4. Lint
npm run lint
```

### API proxy (required)

The frontend must proxy `/api` requests to the Laravel server. In `frontend/vite.config.ts`, configure:

```ts
server: {
  proxy: {
    '/api': {
      target: 'http://localhost:8000',
      changeOrigin: true,
    },
  },
},
```

## 5. Environment Variables

### Backend (`.env`) — key values

| Variable | Purpose |
|----------|---------|
| `APP_URL` | `http://localhost:8000` |
| `DB_*` | MySQL connection settings |
| `SESSION_DOMAIN` | set for cross-origin auth |
| `SANCTUM_STATEFUL_DOMAINS` | `localhost:5173` (for cookie auth if used) |
| `FRONTEND_URL` | `http://localhost:5173` (for email links) |

### Frontend (`.env`)

| Variable | Purpose |
|----------|---------|
| `VITE_API_URL` | API base URL (default `/api`) |

## 6. Authentication Notes

- The backend exposes a token-based API via **Laravel Sanctum**.
- The SPA stores the bearer token (e.g. in `localStorage`) and sends it in the `Authorization` header.
- See [DESIGN.md](DESIGN.md) for the auth flow and endpoints.

## 7. Development Workflow

1. Create a feature branch from `main`.
2. Backend changes: add **migrations** for schema changes, **seeders** for reference data.
3. Frontend changes: add components under `src/`, pages under `src/pages/`.
4. All user-facing strings must be added to i18n files (`en` and `mm`).
5. Run `php artisan test` and `npm run lint` before pushing.
6. Do not commit `.env`, `vendor/`, or `node_modules/`.

## 8. Seeding / Reference Data

Run `php artisan db:seed` to load default reference data (categories, sale channels, payment methods, shop types, admin user). See [DATA_STRUCTURE.md](DATA_STRUCTURE.md) for the full seed list.
