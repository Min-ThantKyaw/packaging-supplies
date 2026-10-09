# Packaging Supplies — Project Document

> **Status:** Draft for implementation
> **Tech stack:** Laravel (PHP) backend · React + TypeScript (Vite) frontend · MySQL
> **Purpose of this document:** Single source of truth for building the system. Written to be consumed by humans and AI agents.
>
> This is the **overview** doc. The full documentation set is indexed in [README.md](README.md).

---

## 1. Overview

A **B2B ordering portal** for a packaging supplies business selling delivery bags, delivery stickers, and bubble wrap. The system serves two audiences simultaneously:

- **Online sellers & shops (customers)** — a public-facing storefront where they browse and order.
- **Internal staff (admin / sales staff)** — a back office to manage products, inventory, orders, customers, payments, and reports.

In short: **both a public-facing store and an internal tool**, unified in one application.

### 1.1 Goals
- Let customers browse products, use a **bag size finder**, and place orders online.
- Let sales staff create **manual orders** (walk-in, phone, or chat orders).
- Track **inventory/stock** accurately across product variants.
- Record **payments** using manually configured payment methods (COD, KPay, Wave, …).
- Produce **daily / weekly / monthly reports** with filters.
- Support **English and Burmese (Myanmar)** in the UI.

### 1.2 Non-goals (out of scope for now)
- Online payment gateway integration (Stripe, KBZ Pay API, etc.) — payments are **manual**.
- Shipping/courier API integration — delivery status is **manual**.
- Wholesale-specific pricing/tiers — deferred (see §10).
- Hosting/deployment decisions — not considered at this stage.

---

## 2. Business Model

- **Primary:** B2B — serving online sellers and shops (bulk/business buyers).
- **Also supported:** Retail (individual purchases).
- **Later:** Wholesale pricing/tiers (deferred).

---

## 3. Users & Roles

Users must **log in** to track orders, view order history, and check payment status. Anonymous browsing of the catalog is allowed.

| Role | Description | Key capabilities |
|------|-------------|------------------|
| **Admin** | Full control | Manage products, inventory, all orders, payments, payment methods, customers, staff, sale channels, reports, bag size finder rules, settings. |
| **Sales staff** | Back-office operator | Create/edit manual orders, manage assigned customers, update order/payment status, view reports (scoped as configured). |
| **Customer** | Online seller / shop | Browse catalog, use bag size finder, add to cart, checkout, view own orders, order history, and payment status. |

> **Note:** Exact permission granularity (e.g. whether sales staff see all reports) is configurable. Default: Admin = full access, Sales staff = operational access without system settings, Customer = self-service only.

### 3.1 Authentication
- Login required for: order tracking, order history, payment status, checkout.
- Customer accounts: created via self-registration on the storefront, or by admin/staff during manual order creation.
- Staff accounts: created by Admin only.

---

## 4. Scope Summary

### MVP (must-have)
1. Bag size finder
2. Product catalog
3. Search & filter
4. Cart
5. Checkout & orders
6. Inventory / stock tracking
7. Invoices
8. Reports (daily / weekly / monthly, with filters)
9. Customer management
10. Staff management
11. Sale channels (Facebook, TikTok)
12. Manual order creation

### Later / Deferred
- Wholesale pricing tiers
- Online payment gateway integration
- Courier / shipping API integration

---

## 5. Features (Detailed)

### 5.1 Bag Size Finder
A recommendation tool that tells the customer which **Delivery Bag size** to use for their item. It is an **admin-managed lookup**, not a dimension calculation.

- **Inputs:**
  - **Shop type** (ဆိုင်အမျိုးအစား) — selectable, e.g. clothing shop (အထည်ဆိုင်), shoe shop (ဖိနပ်ဆိုင်), etc.
  - **Size** — selectable; the size of the item/package (e.g. `17×30`, `25×35`, width × length in cm).
- **Output:** the **recommended Delivery Bag size** (matching product/variant), with a link to add to cart.
- **Behavior:** the system **recommends** the bag size via a mapping of `(shop type + size)` → recommended bag size.
- **Admin control:** Admin can manage the shop type list and the `(shop type + size) → bag size` mapping from the back office (add/edit/remove shop types and rules).
- **Note:** complete list of shop types and size options to be confirmed; see §12.

### 5.2 Product Catalog
- Products belong to **categories**.
- Each product can have **variants** (size, color, thickness).
- Product-level attributes include **local/import** origin and **SKU code**.
- Sold **per-unit** or **per-pack** (sale unit type is defined per variant/product).

### 5.3 Search & Filter
- Keyword search (name, SKU, description).
- Filters: category, size, color, thickness, local/import, price range, availability (in-stock).

### 5.4 Cart
- Anonymous or logged-in cart.
- Items reference a specific **product variant** and quantity.
- Quantity validated against available stock.

### 5.5 Checkout & Orders
- Customer selects **payment method** at checkout (COD, KPay, Wave, or any admin-created method).
- Order lifecycle statuses (see §7.2).
- Order captures: customer, items, quantities, prices, payment method, delivery info, and **sale channel**.

### 5.6 Inventory / Stock Tracking
- Stock tracked at the **variant** level.
- Decrements when an order is placed/confirmed.
- Low-stock visibility and (optionally) alerts for staff.

### 5.7 Invoices
- Generate invoice per order.
- Contains: order number, customer, items, quantities, prices, totals, payment method/status.
- Printable/exportable (PDF).

### 5.8 Reports
- Time-based aggregation: **daily, weekly, monthly**.
- Filters (e.g. date range, sale channel, payment method, product category).
- Typical metrics: total sales, order count, units sold, payment status breakdown, inventory movement.
- *(Assumption: specific report types/metrics to be confirmed; see §12.)*

### 5.9 Customer Management
- Admin/staff manage customer records (create, edit, view order history, view payment status).
- Customer self-service view of own orders and payment status.

### 5.10 Staff Management
- Admin manages staff accounts (create, deactivate, assign role/permissions).

### 5.11 Sale Channels (Facebook, TikTok)
- Orders are tagged with the **sale channel** they originated from (e.g. Facebook, TikTok, Website, Walk-in, Phone).
- Reports can be filtered by sale channel.
- *(Assumption: channels are used for tracking/attribution of manual and online orders; see §12.)*

### 5.12 Manual Order Creation
- Sales staff/admin create orders on behalf of customers (walk-in, phone, Facebook/TikTok chat).
- Staff select customer (or create new), add products/variants, set quantities, choose payment method, assign sale channel.

---

## 6. Product Model

### 6.1 Product Types
| Type | Description |
|------|-------------|
| **Delivery Bags** | Bags in multiple sizes, colors, thickness. |
| **Delivery Stickers** | Stickers for delivery/packaging. |
| **Bubble Wrap** | Protective wrap; sold per-unit or per-pack. |

### 6.2 Attributes
- **Category** (e.g. Delivery Bags, Delivery Stickers, Bubble Wrap).
- **Variants:** size, color, thickness.
  - **Size** for delivery bags is **dimension-based** (width × length in cm), e.g. `17×30`, `25×35`.
- **Origin:** local / import.
- **SKU code** (unique identifier).
- **Sale unit:** per-unit or per-pack.
- **Pricing:** currency is **MMK**. Each product/variant has **two prices**: a per-unit price and a per-pack price.

### 6.3 Key Entities (conceptual)

| Entity | Purpose | Key fields |
|--------|---------|------------|
| `users` | All accounts | name, email, phone, role (admin/sales_staff/customer), password |
| `categories` | Product grouping | name, slug, parent_id |
| `products` | Sellable item | name, description, category_id, origin (local/import), sku, status |
| `product_variants` | Size/color/thickness combo | product_id, size, color, thickness, unit_price, pack_price, sku |
| `stocks` | Inventory per variant | product_variant_id, quantity, (movement log) |
| `orders` | Order header | customer_id, staff_id, sale_channel_id, payment_method_id, status, totals, delivery info |
| `order_items` | Order line items | order_id, product_variant_id, quantity, unit_price, subtotal |
| `payments` | Payment records | order_id, payment_method_id, amount, status, paid_at |
| `payment_methods` | Admin-created methods | name, code, active (COD, KPay, Wave, …) |
| `invoices` | Invoice document | order_id, number, status, issued_at |
| `sale_channels` | Order source | name, code (facebook, tiktok, website, walk_in, phone) |
| `shop_types` | Bag size finder: shop categories (admin-managed) | name, code (clothing, shoe, …) |
| `bag_size_rules` | Bag size finder mapping (admin-managed) | shop_type_id, size (e.g. `17x30`), product_variant_id (recommended bag) |

> These are conceptual for design guidance; final schema via Laravel migrations.

---

## 7. Orders, Payments & Shipping

### 7.1 Payment
- **Manual only** — no gateway integration.
- Customer selects from available methods: **COD, KPay, Wave** (defaults).
- **Admin can create additional payment methods.**
- Payment status is recorded/updated manually by staff (e.g. pending → paid).

### 7.2 Order Status
A clear status set (exact set configurable; proposed):

| Status | Meaning |
|--------|---------|
| `pending` | Order placed, awaiting confirmation |
| `confirmed` | Order confirmed by staff |
| `processing` | Being packed/prepared |
| `shipped` | Handed to delivery (manual update) |
| `delivered` | Completed delivery |
| `cancelled` | Cancelled |

### 7.3 Payment Status
| Status | Meaning |
|--------|---------|
| `unpaid` | Not yet paid |
| `partial` | Partial payment received |
| `paid` | Fully paid |

### 7.4 Shipping / Delivery
- **Manual** — no courier API.
- Delivery info captured on the order; status updated manually by staff.

---

## 8. Localization (i18n)

- UI supports **English** and **Burmese (Myanmar)**.
- All user-facing strings (labels, messages, product names if localized, reports) must be translatable.
- Use a standard Laravel localization approach (`lang/` files) and a frontend i18n library (e.g. `i18next`).
- Dates, numbers, and currency formatting should respect locale.
- Currency: **MMK** (Myanmar Kyat) only.

---

## 9. Non-Functional Requirements

- **Database:** MySQL.
- **Performance:** catalog search/filter should be responsive on typical product volume.
- **Security:** role-based access control, hashed passwords, CSRF/session protection (Laravel defaults), input validation.
- **Reporting:** daily/weekly/monthly aggregations with filterable ranges.
- **Availability:** not hosting-critical at this stage.

---

## 10. Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel (PHP) |
| Frontend | React + TypeScript + Vite |
| Database | MySQL |
| i18n | Laravel `lang/` + frontend i18n library |

---

## 11. Project Structure

```
packaging-supplies/
├── backend/          # Laravel application
│   ├── app/
│   ├── routes/       # API routes
│   ├── database/     # migrations, seeders
│   └── lang/         # en, mm translation files
├── frontend/         # React + TypeScript (Vite)
│   └── src/
└── docs/
    └── PROJECT.md    # this document
```

---

## 12. Assumptions & Open Questions

The following were inferred and should be confirmed before/while implementing:

1. **Bag size finder** — confirmed: admin-managed lookup where the customer selects shop type + size and the system **recommends** the matching Delivery Bag size (dimension-based, e.g. `17×30`, `25×35`). Confirm the complete list of shop types and size options.
2. **Sale channels (Facebook/TikTok)** — assumed to be order-source tags used for attribution and reporting. Confirm whether any deeper integration (e.g. importing orders from FB/TikTok) is required.
3. **Reports** — assumed standard metrics (sales, orders, units, payment status, inventory movement) with date/channel/payment/category filters. Confirm exact report types.
4. **Currency** — confirmed: MMK only.
5. **Stock decrement timing** — assumed decrement on order placement/confirmation. Confirm the exact trigger.
6. **Invoice generation timing** — assumed per order, generated after confirmation. Confirm.

---

## 13. Implementation Order (Suggested)

1. Auth & roles (users, login, RBAC)
2. Categories, products, variants, SKU, stock
3. Catalog browse + search/filter
4. Bag size finder
5. Cart & checkout (manual payment methods)
6. Orders + order status + payment status
7. Manual order creation + sale channels
8. Invoices
9. Reports (daily/weekly/monthly)
10. i18n (en/mm) pass across UI
