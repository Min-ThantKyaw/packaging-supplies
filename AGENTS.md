# Packaging Supplies — project instructions

Single-shop e-commerce for plastic bags and poly mailers. One owner (admin) sells to
customers; customers may check out as guests.

## Layout

- `backend/` — Laravel API (PHP 8.3+, PHPUnit, Pint). See `backend/AGENTS.md`.
- `web/` — React 19 + TypeScript + Vite 8 + Tailwind 4 SPA. See `web/AGENTS.md`.
- `docs/` — operational notes. `docs/docker.md` covers the dev stack,
  `docs/API.md` is the endpoint reference, `docs/FEATURES.md` is the backlog.
- `docker-compose.yml` — `backend` on :8000, `web` on :5173.

## Stack decisions

Do not change these without asking.

- Admin is part of the same SPA at `/admin`, lazy-loaded behind an admin guard.
- Auth uses Sanctum personal access tokens (bearer) because web and API deploy to
  different origins.
- Payments are manual: no gateway. The admin confirms payment via `orders.paid_at`.
- Products have full variants: option axes are defined per product and combinations
  generate variant rows.
- Cost is tracked as a moving average on `product_variants.cost_price`; the unit cost
  is snapshotted into `order_items.unit_cost` at sale time.
- Purchases are recorded as paid in full. There are no payables or supplier balances.
- Guest checkout is allowed with name + phone.

## Invariants

- Money is stored as integer minor units. Format only at the edge
  (`web/src/lib/money.ts`); never do currency math in components or resources.
- The client sends `product_variant_id` + `quantity`. The server resolves price.
  Reject any payload that contains a price or total.
- Stock changes only through `stock_movements`. `product_variants.stock` is a cached
  projection written in the same transaction as its movement.
- Every stock write goes through `App\Services\CheckoutService`,
  `App\Services\PurchaseService`, or `App\Services\StockAdjustmentService`.
  No stock arithmetic in controllers, models, or requests.
- Corrections are new movements. Never edit or delete a past `stock_movements` row.
- Purchase totals are computed server-side:
  `total = Σ(quantity × unit_cost) + shipping_cost − discount`.
- `cost_price` updates by weighted average:
  `(old_qty × old_cost + new_qty × unit_cost) / (old_qty + new_qty)`.
- Order and purchase line items freeze their snapshots (product name, variant label,
  sku, unit price/cost). Later catalogue edits must not change history.
- Order status only moves through the transition map in `App\Enums\OrderStatus`:
  `pending → confirmed → processing → shipped → completed`, plus `cancelled`.
  `paid_at` is set when the admin moves an order to `confirmed`.
- A customer requesting another customer's order receives 404, not 403.
- Guest orders are retrievable with `number + guest_token`, or `number + phone` through
  the rate-limited lookup endpoint.
- Reports are read-only queries over existing tables. Never store aggregate counters.
- Timestamps are stored in UTC. Reports and displays render in `APP_TIMEZONE`
  (Asia/Yangon).
- Every `/api/admin/*` route requires the `admin` role.
- Variants that appear in any order or purchase are deactivated (`is_active = false`),
  never deleted.

## Commands

Run each command from the package directory it belongs to.

```sh
# Backend
cd backend
php artisan test              # PHPUnit feature/unit tests
./vendor/bin/pint             # code style
php artisan migrate           # migrations

# Frontend
cd web
npm run dev                   # Vite dev server
npm run build                 # tsc -b && vite build
npm run lint                  # ESLint
```

Docker stack (needed for anything touching the database):

```sh
docker compose up --build
SKIP_MIGRATIONS=1 docker compose up    # when the database is unreachable
```

## Database

- Supabase Postgres, not containerized. Connection details come from `backend/.env`.
- Use the session pooler on `5432`; `DB_SSLMODE=require` is mandatory. The transaction
  pooler on `6543` breaks PDO prepared statements.
- Never commit `backend/.env`. Update `backend/.env.example` when adding a variable.
- Never hardcode credentials or the Supabase host.

## Guardrails

- Do not edit `backend/vendor/`, `web/node_modules/`, or `web/dist/`.
- Ask before adding a dependency to either package.
- The admin seeder reads `ADMIN_EMAIL` and `ADMIN_PASSWORD` from the environment.
  Never write real credentials into code, seeders, or fixtures.
- Do not change the Sanctum token approach to cookie sessions without discussing
  deployment first.

## Verification

- Backend change: `php artisan test` passes and `./vendor/bin/pint --test` is clean.
- Frontend change: `npm run lint` and `npm run build` both pass.
- API change: every added, changed, or removed endpoint is reflected in
  `docs/API.md` in the same change. Examples must match the `Http\Resources` output.
- Feature completion: tick the matching entry in `docs/FEATURES.md`.
- Report what you ran. If you could not run something, say so explicitly instead of
  implying it passed.
