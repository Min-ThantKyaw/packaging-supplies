# Docker development setup

Local development stack with hot reload for the Laravel API and the React web app.

| Service | Image | URL |
| --- | --- | --- |
| `backend` | PHP 8.5 CLI + Composer | http://localhost:8000 |
| `web` | Node 22 + Vite | http://localhost:5173 |

The database is **not** containerized. The backend connects directly to the
Supabase Postgres server configured in `backend/.env`.

## Prerequisites

- Docker Desktop (with the WSL 2 backend on Windows)
- Network access to the Supabase host from the Docker container

## Network / package mirrors

The backend build defaults to a regional mirror because `deb.debian.org` and
`repo.packagist.org` are not reachable from every network:

- apt: `mirrors.aliyun.com`
- Composer: `https://mirrors.aliyun.com/composer/`

Both are build arguments. To build against the official hosts instead:

```sh
docker compose build \
  --build-arg DEBIAN_MIRROR=deb.debian.org \
  --build-arg COMPOSER_PACKAGIST=https://repo.packagist.org
```

Node packages come from the default npm registry, which is reachable here.

## First run

```sh
docker compose up --build
```

What happens on the first start:

1. `backend`: `vendor/` is empty, so Composer dependencies are installed into the
   `backend_vendor` volume.
2. `backend`: `php artisan migrate --force` runs against Supabase.
3. `web`: `node_modules/` is empty, so `npm ci` installs dependencies into the
   `web_node_modules` volume.

The API is ready when `http://localhost:8000/up` returns 200. Open
`http://localhost:5173` for the web app.

## Database configuration

`backend/.env` is bind-mounted into the container and holds the connection
details:

```env
DB_CONNECTION=pgsql
DB_URL="postgresql://postgres.<project-ref>:<password>@<host>:5432/postgres"
DB_SEARCH_PATH=public
DB_SSLMODE=require
```

- `DB_URL` is the single source of truth for host, port, database, user and
  password. Laravel parses it with `parse_url`, which splits the user info on the
  **last** `@`, so an unencoded `@` in the password works. Quote the value.
- `DB_SSLMODE=require` is required by Supabase and is read by the Postgres
  connector.
- `DB_SEARCH_PATH=public` keeps migrations and queries in the `public` schema.
- Use the **session pooler** on port `5432` (or the direct connection). The
  transaction pooler on port `6543` breaks PDO prepared statements.

To skip migrations on a given start (for example while the database is
unreachable), run:

```sh
SKIP_MIGRATIONS=1 docker compose up
```

After the database becomes reachable, run the pending migrations:

```sh
docker compose exec backend php artisan migrate

# or recreate the backend so its entrypoint runs migrations again
docker compose up -d --force-recreate backend
```

## Common commands

```sh
# Logs
docker compose logs -f backend
docker compose logs -f web

# Artisan
docker compose exec backend php artisan migrate
docker compose exec backend php artisan db:seed
docker compose exec backend php artisan tinker
docker compose exec backend php artisan make:model Product -m

# Composer (installs into the backend_vendor volume)
docker compose exec backend composer require laravel/sanctum

# npm (installs into the web_node_modules volume)
docker compose exec web npm install axios

# Rebuild images after changing a Dockerfile or its entrypoint
docker compose up --build

# Stop everything (volumes are kept)
docker compose down

# Remove volumes too (next start reinstalls vendor/ and node_modules/)
docker compose down -v
```

## Seeding

`php artisan db:seed` is not part of the container entrypoint. Run it once after
migrating:

```sh
docker compose exec backend php artisan db:seed
```

- `AdminUserSeeder` creates or updates the owner from `ADMIN_EMAIL` and
  `ADMIN_PASSWORD`; it skips with a warning when either is blank.
- `DemoCustomerSeeder` creates or updates `customer@example.com` with the password
  `password`, overridable via `DEMO_CUSTOMER_EMAIL` and `DEMO_CUSTOMER_PASSWORD`.
  It only runs when `APP_ENV=local`, so production seeding never creates a
  known-password account.
- Both seeders are idempotent but reset the password of the account they own, so
  re-running after a password change in the UI restores the seeded value.

## How the containers work

- `backend/docker/entrypoint.sh` creates `.env` from `.env.example` when missing,
  installs Composer dependencies when `vendor/autoload.php` is absent or
  `composer.lock` is newer than the installed packages, generates `APP_KEY` when it
  is empty, then runs migrations before starting `php artisan serve`.
- `web/docker/entrypoint.sh` runs `npm ci` when `node_modules/` is empty, then
  starts the Vite dev server.
- Source code is bind-mounted, so edits on the host are picked up immediately.
  `vendor/` and `node_modules/` live in named volumes to keep the Windows
  filesystem out of the hot path.

## Calling the API from the web app

Use the published backend port, for example:

```ts
fetch('http://localhost:8000/api/health')
```

In the SPA, requests go through `web/src/api/client.ts` and `VITE_API_URL` rather than
raw `fetch`. CORS only allows the origins in `FRONTEND_URL` (default
`http://localhost:5173`), so keep that value in `backend/.env` in sync with the Vite
origin.

## Troubleshooting

- **HMR does not detect file changes (Windows):** Docker bind-mount events can be
  unreliable. Enable polling in `web/vite.config.ts`:

  ```ts
  server: {
    watch: { usePolling: true, interval: 300 },
  }
  ```

- **`composer.lock` / `package-lock.json` changed but the container uses old
  dependencies:** the named volumes persist. Reinstall them:

  ```sh
  docker compose run --rm backend composer install
  docker compose run --rm web npm ci
  ```

- **Vite says a package cannot be resolved (`Failed to resolve import …`)** right
  after adding it: it was installed on the host into `web/node_modules`, while the
  dev server reads the `web_node_modules` volume. Install it in the container and
  restart the server:

  ```sh
  docker compose exec web npm install
  docker compose restart web
  ```

  Or remove the volumes with `docker compose down -v`.

- **Migrations fail to connect:** check that the Supabase project is active
  (paused projects return `tenant/user ... not found`) and that `DB_URL`,
  `DB_SSLMODE` and the pooler port are correct. The full SQL error is printed in
  `docker compose logs backend`.

- **Port already in use:** change the host side of the mapping in
  `docker-compose.yml` (for example `"8001:8000"`), then point API calls at the
  new port.
