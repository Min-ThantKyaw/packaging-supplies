# Design Document

## 1. Architecture

```
┌─────────────────────────────┐         ┌──────────────────────────────┐
│  React + TypeScript (Vite)  │  HTTP   │  Laravel (PHP) API           │
│  - storefront                │  JSON   │  - REST routes (/api)        │
│  - customer account          │ ──────► │  - Eloquent + MySQL          │
│  - admin dashboard           │  token  │  - Sanctum auth              │
└─────────────────────────────┘         └──────────────────────────────┘
```

- **Single-page app (SPA)** frontend talks to a **JSON REST API** backend.
- Auth is **token-based** (Laravel Sanctum); the SPA sends `Authorization: Bearer <token>`.
- The frontend and backend are developed separately and connected via a Vite dev proxy (`/api` → `localhost:8000`).

## 2. Authentication Flow

1. Customer/staff logs in with email/phone + password → `POST /api/auth/login` returns a token.
2. SPA stores the token and attaches it to subsequent requests.
3. Role is enforced on the backend; the SPA also uses the returned role to show/hide UI.
4. `GET /api/auth/me` returns the current user (used to restore session on reload).

## 3. API Design

### 3.1 Conventions
- Base URL: `/api`
- JSON responses: `{ "data": ... }`; paginated lists: `{ "data": [...], "meta": { "current_page", "last_page", "total" } }`
- Auth via `Authorization: Bearer <token>`
- Role gating via middleware (`admin`, `staff`, `customer`)

### 3.2 Public Endpoints (no auth)

| Method | Path | Description |
|--------|------|-------------|
| POST | `/api/auth/register` | Customer self-registration |
| POST | `/api/auth/login` | Login (any role) |
| GET | `/api/categories` | List categories |
| GET | `/api/products` | List products (search/filter/paginate) |
| GET | `/api/products/{id}` | Product detail + variants |
| GET | `/api/bag-size-finder/shop-types` | List active shop types |
| GET | `/api/bag-size-finder/recommend` | `?shop_type=&size=` → recommended bag variant |
| GET | `/api/payment-methods` | List active payment methods |
| POST | `/api/orders` | Create order (checkout; customer or guest) |

### 3.3 Customer Endpoints (auth)

| Method | Path | Description |
|--------|------|-------------|
| GET | `/api/auth/me` | Current user |
| POST | `/api/auth/logout` | Logout |
| GET | `/api/orders` | My orders |
| GET | `/api/orders/{id}` | My order (items, payments, invoice) |
| GET | `/api/orders/{id}/payments` | My order's payment records |

### 3.4 Staff / Admin Endpoints (auth + role)

| Method | Path | Description |
|--------|------|-------------|
| GET | `/api/admin/orders` | List all orders (filterable) |
| GET | `/api/admin/orders/{id}` | Order detail |
| POST | `/api/admin/orders` | Create manual order |
| PATCH | `/api/admin/orders/{id}/status` | Update order status |
| PATCH | `/api/admin/orders/{id}/payment-status` | Update payment status |
| POST | `/api/admin/orders/{id}/payments` | Record a payment |
| GET/POST | `/api/admin/invoices` | List / generate invoices |
| GET | `/api/admin/products` | List products |
| POST/PUT/DELETE | `/api/admin/products` ... | Product CRUD |
| POST/PUT/DELETE | `/api/admin/variants` ... | Variant CRUD |
| GET/POST/PUT | `/api/admin/categories` ... | Category CRUD |
| GET/PATCH | `/api/admin/stocks` | View / adjust stock |
| GET/POST/PUT/DELETE | `/api/admin/users` ... | Customer & staff management |
| GET/POST/PUT/DELETE | `/api/admin/payment-methods` ... | Payment method management |
| GET/POST/PUT/DELETE | `/api/admin/sale-channels` ... | Sale channel management |
| GET/POST/PUT/DELETE | `/api/admin/shop-types` ... | Bag size finder: shop types |
| GET/POST/PUT/DELETE | `/api/admin/bag-size-rules` ... | Bag size finder: rules |
| GET | `/api/admin/reports/sales` | Sales report (`?period=daily|weekly|monthly&from=&to=&sale_channel=&payment_method=&category=`) |

> Full endpoint specs with request/response shapes are implemented per feature (see [FEATURE_SPECS.md](FEATURE_SPECS.md)).

## 4. Frontend Design

### 4.1 Tech Decisions
| Concern | Choice |
|---------|--------|
| Routing | React Router |
| Server state | TanStack Query |
| Client state (auth, cart) | Zustand (or Context) |
| i18n | i18next (`en`, `mm`) |
| Styling | Tailwind CSS |
| HTTP client | axios (with token interceptor) |

### 4.2 Directory Structure (`frontend/src`)
```
src/
├── api/            # axios client + API functions
├── components/     # shared UI components
├── pages/
│   ├── storefront/     # public storefront pages
│   ├── account/        # customer account pages
│   └── admin/          # admin dashboard pages
├── layouts/        # layout wrappers (storefront, account, admin)
├── hooks/          # custom hooks
├── store/          # Zustand stores (auth, cart)
├── i18n/           # i18next config + en/mm resources
├── types/          # TypeScript types (mirror API)
├── router.tsx      # route definitions
└── main.tsx        # entry
```

### 4.3 Pages

**Storefront (public)**
- Home
- Product catalog (search + filter)
- Product detail (variants)
- Bag size finder
- Cart
- Checkout
- Order confirmation
- Login / Register

**Customer account (auth)**
- Order history
- Order detail (status, payment status, items)
- Profile

**Admin dashboard (auth + role)**
- Dashboard (report overview)
- Products (list, create/edit, variants)
- Categories
- Inventory / stock
- Orders (list, detail, manual order, status updates)
- Payments
- Customers
- Staff
- Sale channels
- Bag size finder (shop types + rules)
- Reports (daily/weekly/monthly)

### 4.4 State & Data Flow
- **Cart:** client-side (localStorage) until checkout; validated against server stock at checkout.
- **Auth:** token + user in a Zustand store; persisted to localStorage.
- **Bag size finder:** `GET /api/bag-size-finder/recommend?shop_type=&size=` returns a recommended variant; the UI links it to the product detail/add-to-cart.

## 5. i18n Design

- Frontend: i18next with `en` and `mm` resource JSON files; a language switcher in the header.
- Backend: Laravel `lang/en` and `lang/mm` for server-generated messages.
- Store user's language preference (in the SPA, e.g. `localStorage` or a user profile field).

## 6. Bag Size Finder Design

1. Admin manages `shop_types` (clothing, shoe, …) and `bag_size_rules` (`(shop_type, size) → variant`).
2. Customer selects **shop type** and **size**.
3. Backend looks up the rule and returns the recommended `product_variant`.
4. Frontend shows the recommendation with an "Add to cart" link.
