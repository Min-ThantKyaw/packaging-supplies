# API reference

Base URL (dev): `http://localhost:8000/api`

One section per endpoint, added as endpoints are implemented. The backlog that drives
this file is `docs/FEATURES.md`. Response examples must match the `App\Http\Resources`
output, not the raw model.

## Conventions

### Authentication

- Sanctum personal access tokens, sent as `Authorization: Bearer <token>`.
- Tokens are issued by `POST /api/login` and `POST /api/register`; the plain-text token
  is returned once as `id|secret`.
- Tokens expire after `SANCTUM_EXPIRATION` minutes (default 7 days / 10080).
- Registration always creates a `customer`; `role` is never accepted from request input.
- Emails are normalised to lowercase before validation and storage.
- Invalid login credentials return `422` with `errors.email`, not `401`.
- Roles: `customer` (default) and `admin`. Routes under `/api/admin/*` use the
  `auth:sanctum` + `admin` middleware: guests get `401`, customers get `403`.
- Browser origins are limited to `FRONTEND_URL` (comma-separated, defaults to
  `http://localhost:5173`). Credentialed CORS is disabled because tokens travel in
  the `Authorization` header.
- `401` — missing, invalid, or expired token.
- `403` — authenticated but not allowed (for example a non-admin on `/api/admin/*`).
- `404` — used instead of `403` when a customer requests another customer's resource.

### Money

All amounts are integers in minor units (MMK). Clients format them; the API never sends
formatted strings.

### Pagination

Paginated collections use Laravel's resource shape:

```json
{
  "data": [ ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 20, "total": 0 }
}
```

`per_page` defaults to 20 and is capped at 100.

### Errors

Every `/api/*` response is JSON, including errors returned to clients that do not
send `Accept: application/json` (the API forces the header).

Validation failures (`422`) include a field map:

```json
{ "message": "The given data was invalid.", "errors": { "field": ["reason"] } }
```

Other errors use a message only:

```json
{ "message": "Unauthenticated." }
```

- `401` — missing, invalid, or expired token.
- `403` — authenticated but not allowed.
- `404` — missing or not visible to the caller.
- `422` — validation failure, `errors` keyed by field.
- `429` — rate limited; the response carries `Retry-After`.

### Timestamps

Serialised as ISO 8601 UTC. Reports accept `from` / `to` dates and resolve them in
`APP_TIMEZONE`.

## Health

### GET /api/health

Public API liveness probe. The Docker healthcheck probes the framework's `/up`
endpoint.

`200`

```json
{ "status": "ok" }
```

## Auth

### POST /api/register

Public. Creates a customer account and returns a bearer token.

```json
{
  "name": "Aung Aung",
  "email": "aung@example.com",
  "password": "secret-password",
  "password_confirmation": "secret-password"
}
```

- `name` — required, max 255.
- `email` — required, valid, unique; stored lowercase.
- `password` — required, min 8, must match `password_confirmation`.

`201`

```json
{
  "data": {
    "token": "1|plaintext-token",
    "token_type": "Bearer",
    "user": {
      "id": 1,
      "name": "Aung Aung",
      "email": "aung@example.com",
      "role": "customer",
      "created_at": "2026-11-23T08:00:00.000000Z",
      "updated_at": "2026-11-23T08:00:00.000000Z"
    }
  }
}
```

- `422` — validation failure (`email` taken, password too short or unconfirmed).
- `429` — more than 5 registrations per minute from one IP (`Retry-After` set).

### POST /api/login

Public. Exchanges credentials for a new bearer token. Earlier tokens stay valid.

```json
{ "email": "aung@example.com", "password": "secret-password" }
```

`200` — same `data` shape as register.

- `422` — invalid credentials (`errors.email`) or missing fields.
- `429` — more than 5 attempts per minute for the same email from one IP
  (`Retry-After` set). Other emails from the same IP are unaffected.

### GET /api/me

Requires `Authorization: Bearer <token>`.

`200`

```json
{
  "data": {
    "id": 1,
    "name": "Aung Aung",
    "email": "aung@example.com",
    "role": "customer",
    "created_at": "2026-11-23T08:00:00.000000Z",
    "updated_at": "2026-11-23T08:00:00.000000Z"
  }
}
```

- `401` — missing, invalid, expired, or revoked token.

### POST /api/logout

Requires `Authorization: Bearer <token>`. Revokes only the token used for the request;
other sessions keep working.

`204` — no body.

- `401` — missing, invalid, expired, or revoked token.

## Categories

The shop's taxonomy. `group` is one of `mailers-envelopes`, `boxes-cartons`,
`bags-pouches`, `protective-tapes`; every response carries the display name as
`group_label` so the SPA never hardcodes it.

A category object:

```json
{
  "id": 1,
  "name": "Poly Mailers",
  "slug": "poly-mailers",
  "group": "mailers-envelopes",
  "group_label": "Mailers & Envelopes",
  "description": null,
  "image_url": null,
  "is_active": true,
  "is_featured": true,
  "sort_order": 10,
  "created_at": "2026-11-28T09:00:00.000000Z",
  "updated_at": "2026-11-28T09:00:00.000000Z"
}
```

- Every collection is paginated (`per_page` default 20, max 100) and ordered by
  `sort_order` then `name`, so it is deterministic.
- `slug` is generated from `name` on create and suffixed (`-2`, `-3`, …) on collision.
  Renaming does **not** change the slug; only an explicit `slug` in the body does.
- `description` is returned as stored; the model casts booleans, so `is_active` and
  `is_featured` are real JSON booleans.
- `image_url` is `null` until category images exist (F16); the storefront falls back to
  the group's Lucide icon.

### GET /api/categories

Public. Active categories only.

Query params: `group`, `featured` (`1`), `per_page`, `page`.

`200`

```json
{
  "data": [ { "...": "category object" } ],
  "links": { "first": "...", "last": "...", "prev": null, "next": null },
  "meta": { "current_page": 1, "per_page": 20, "total": 20 }
}
```

`422` — invalid `group` or `per_page`.

### GET /api/admin/categories

Admin. Every category, including inactive ones.

Query params: `search` (matches name or slug), `group`, `is_active` (`0` / `1`),
`per_page`, `page`.

`200` — same envelope as above.

`401` / `403` — guests and customers.

### POST /api/admin/categories

Admin. `201`

```json
{
  "name": "Poly Mailers",
  "group": "mailers-envelopes",
  "description": null,
  "is_featured": true,
  "is_active": true,
  "sort_order": 10,
  "slug": "poly-mailers"
}
```

Only `name` and `group` are required. `slug` is optional and must be unique; omit it to
have one generated. `sort_order` defaults to `0`, `is_active` to `true`,
`is_featured` to `false`.

`422` — `name` missing, `group` not one of the four, or `slug` already taken.

### GET /api/admin/categories/{category}

Admin. `200` with the category object. `404` when the id does not exist.

### PATCH /api/admin/categories/{category}

Admin. Any subset of `name`, `group`, `slug`, `description`, `is_active`,
`is_featured`, `sort_order`. `200` with the updated category.

`422` — invalid field, or `slug` taken by a different category.

### DELETE /api/admin/categories/{category}

Admin. `204`, no body. `404` when the id does not exist.

Until products exist there is no guard for categories in use; a category that still has
products will be refused once the product schema lands.

### PATCH /api/admin/categories/reorder

Admin. Rewrites `sort_order` to 10, 20, 30 … in the order the ids arrive.

```json
{ "ids": [12, 3, 7], "group": "mailers-envelopes" }
```

`200` with the reordered categories as a collection. `group` is optional; when present,
every id must belong to that group.

`422` — unknown id, duplicate id, or an id from another group.

## Planned contracts (not implemented)

Agreed shapes for features that have no endpoint yet. When the feature lands, its
section moves into the implemented reference above and this block shrinks.

### Cart shipping summary — F20

`GET /api/cart` includes a shipping block alongside the lines:

```json
{
  "shipping": {
    "fee": 3000,
    "free_threshold": 100000,
    "remaining_for_free": 42000
  }
}
```

Amounts are minor units. Values come from `backend/config/shop.php` (env-backed; the
values above are demo figures until the owner confirms real delivery terms). The
client formats them; the server recalculates at checkout.

Future endpoint groups: products and variants, cart, checkout, orders, admin, reports.
