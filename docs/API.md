# API reference

Base URL (dev): `http://localhost:8000/api`

One section per endpoint, added as endpoints are implemented. The backlog that drives
this file is `docs/FEATURES.md`. Response examples must match the `App\Http\Resources`
output, not the raw model.

## Conventions

### Authentication

- Sanctum personal access tokens, sent as `Authorization: Bearer <token>`.
- Tokens are issued by `POST /api/login` and `POST /api/register`.
- Tokens expire after `SANCTUM_EXPIRATION` minutes (default 7 days / 10080).
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

```json
{ "message": "The given data was invalid.", "errors": { "field": ["reason"] } }
```

- `422` — validation failure, `errors` keyed by field.
- `404` — missing or not visible to the caller.
- `429` — rate limited.

### Timestamps

Serialised as ISO 8601 UTC. Reports accept `from` / `to` dates and resolve them in
`APP_TIMEZONE`.

## Health

### GET /health

Public. Liveness probe used by the Docker healthcheck.

`200`

```json
{ "status": "ok" }
```

## Endpoints

Endpoint sections are added here as each feature is implemented. Planned groups:
auth, catalog, cart, checkout, orders, admin (catalog, inventory, procurement,
expenses), reports.
