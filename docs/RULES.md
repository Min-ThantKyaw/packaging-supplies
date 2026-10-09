# Business Rules & Conventions

## 1. Roles & Permissions (RBAC)

Three fixed roles: `admin`, `sales_staff`, `customer`.

| Capability | Admin | Sales staff | Customer |
|------------|:-----:|:-----------:|:--------:|
| Browse catalog (public) | ✅ | ✅ | ✅ |
| Use bag size finder | ✅ | ✅ | ✅ |
| Add to cart / checkout | ✅ | ✅ | ✅ |
| View own orders & payment status | ✅ | ✅ | ✅ |
| Manage products & variants | ✅ | ❌ | ❌ |
| Manage categories | ✅ | ❌ | ❌ |
| Manage inventory / stock | ✅ | ❌ | ❌ |
| View all orders | ✅ | ✅ | ❌ |
| Update order & payment status | ✅ | ✅ | ❌ |
| Create manual orders | ✅ | ✅ | ❌ |
| Manage customers | ✅ | ✅ | ❌ |
| Manage staff accounts | ✅ | ❌ | ❌ |
| Manage payment methods | ✅ | ❌ | ❌ |
| Manage sale channels | ✅ | ❌ | ❌ |
| Manage bag size finder (shop types + rules) | ✅ | ❌ | ❌ |
| View reports | ✅ | ✅ (scoped) | ❌ |

> **Default:** Admin = full access; Sales staff = operational access (orders, customers, reports) without system settings; Customer = self-service only.

## 2. Business Rules

### 2.1 Products & Pricing
- Currency is **MMK** only.
- Every product variant has **two prices**: `unit_price` and `pack_price`.
- SKU codes are **unique**.
- Product origin is either `local` or `import`.

### 2.2 Stock / Inventory
- Stock is tracked **per variant**.
- Stock cannot go negative; a cart/checkout quantity must not exceed available stock.
- Stock decrements when an order is **confirmed** (not merely placed). *(Confirm trigger — see open questions.)*

### 2.3 Orders
- Every order has an **order status** and a **payment status** (see below).
- Every order records its **sale channel** (origin).
- Manual orders are created by staff on behalf of a customer; the order stores `staff_id`.

### 2.4 Payments
- Payments are **manual** (no gateway integration).
- Available methods are defined by Admin (`payment_methods` table). Defaults: `cod`, `kpay`, `wave`.
- Payment status is updated manually by staff as money is received.
- A payment record stores: order, method, amount, status, optional reference, `paid_at`, and `recorded_by`.

### 2.5 Invoices
- An invoice is generated **per order**.
- Invoice stores a unique `invoice_number`, status, issued timestamp, and total.

### 2.6 Reports
- Reports support **daily / weekly / monthly** periods and are **filterable** (date range, sale channel, payment method, category).

## 3. Status Enumerations

### 3.1 Order Status
| Value | Meaning |
|-------|---------|
| `pending` | Order placed, awaiting confirmation |
| `confirmed` | Confirmed by staff; stock committed |
| `processing` | Being packed/prepared |
| `shipped` | Handed to delivery (manual update) |
| `delivered` | Completed |
| `cancelled` | Cancelled (release stock) |

### 3.2 Payment Status
| Value | Meaning |
|-------|---------|
| `unpaid` | No payment received |
| `partial` | Partial payment received |
| `paid` | Fully paid |

### 3.3 Product Origin
| Value | Meaning |
|-------|---------|
| `local` | Locally produced |
| `import` | Imported |

## 4. Validation Rules

- `email` unique per user (nullable if phone is the primary identifier).
- `phone` required for customers and staff.
- `sku` unique across products/variants.
- `quantity` must be a positive integer.
- `unit_price`, `pack_price`, totals must be non-negative decimals.
- Order `total` = Σ(order item subtotals) + shipping fee − discount.
- Bag size finder rule: a `(shop_type_id, size)` pair is **unique**.

## 5. i18n Rules

- The UI supports **English (`en`)** and **Burmese (`mm`)**.
- **Every** user-facing string must be translatable — no hardcoded strings in components.
- Backend: use Laravel localization (`lang/en/`, `lang/mm/`) for any server-generated messages.
- Frontend: use i18next with `en` and `mm` resource files.
- Dates, numbers, and currency (MMK) must be formatted per locale.

## 6. Coding Conventions

### 6.1 Backend (Laravel)
- Follow Laravel conventions: Eloquent models, Form Requests for validation, Resource classes for API responses.
- Controllers return JSON only (this is an API).
- Use `softDeletes` where historical records must be preserved (e.g. orders, payments).
- Reference/enum values stored as strings with validation via `enum` rules.

### 6.2 Frontend (React + TypeScript)
- Function components + hooks; no class components.
- TypeScript strict mode; avoid `any`.
- Use TanStack Query for server state, and a lightweight store (Zustand/Context) for auth + cart.
- React Router for routing.
- Tailwind or CSS modules for styling (pick one and stay consistent).

### 6.3 API Conventions
- RESTful JSON API under `/api`.
- Responses wrapped as `{ "data": ... }` or `{ "data": ..., "meta": ... }` for paginated lists.
- Errors returned with appropriate HTTP status codes and a message.
- See [DESIGN.md](DESIGN.md) for the endpoint contract.

## 7. Security Rules

- Passwords hashed (Laravel `bcrypt`).
- API routes protected with Sanctum `auth:sanctum` middleware; admin routes additionally gated by role middleware.
- Validate all inputs via Form Requests.
- Never expose `password` or `personal_access_tokens` in API responses.
- CSRF/session protection for any cookie-authenticated routes (Laravel defaults).
