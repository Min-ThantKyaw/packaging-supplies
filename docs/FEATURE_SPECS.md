# Feature Specifications

Detailed requirements for each feature. Each spec includes behavior and acceptance criteria (AC).

## F1. Authentication & Users

**Description:** Login/registration for customers, staff, and admin.

- Customer self-registration (name, email/phone, password).
- Staff/admin accounts created by Admin only.
- Login returns a Sanctum token; SPA stores it and restores session via `/api/auth/me`.

**AC:**
- Customer can register, log in, log out.
- Admin can create/deactivate staff and customer accounts.
- A logged-in customer can view their own orders and payment status.
- A logged-out user can browse the catalog but cannot track orders/checkout.

## F2. Product Catalog

**Description:** Browsable catalog of Delivery Bags, Delivery Stickers, Bubble Wrap.

- Categories with slug; products belong to a category.
- Products have origin (`local`/`import`), SKU, description, and variants (size, color, thickness).
- Variants each have `unit_price` and `pack_price`.

**AC:**
- Admin can create/edit/archive products and variants with unique SKUs.
- Storefront lists products by category with pagination.

## F3. Search & Filter

**Description:** Find products quickly.

- Keyword search on name, SKU, description.
- Filters: category, size, color, thickness, origin, price range, in-stock.

**AC:**
- Searching a term returns matching products.
- Combining multiple filters returns correct results.
- Filters are reflected in the URL (shareable/bookmarkable).

## F4. Bag Size Finder

**Description:** Recommend the correct Delivery Bag size.

- Customer selects **shop type** and **size**.
- System recommends the matching bag variant via `bag_size_rules`.
- Admin manages the shop type list and rules.

**AC:**
- Admin can add/edit/remove shop types and rules.
- Customer selects a valid combination and sees the recommended bag with an "Add to cart" link.
- Selecting an unmatched combination shows a clear "no recommendation" message.

## F5. Cart

**Description:** Client-side cart of selected variants.

- Items reference a specific variant + `unit_type` (unit/pack) + quantity.
- Quantity validated against stock.

**AC:**
- Add items from product detail and bag size finder.
- Update quantity / remove items.
- Cannot exceed available stock.

## F6. Checkout & Orders

**Description:** Turn a cart into an order.

- Customer selects payment method and provides delivery info (name, phone, address).
- Order records sale channel (`website` for storefront orders) and totals.

**AC:**
- Placing an order creates an `order` with `order_items` and `status=pending`.
- Customer receives an order confirmation with an order number.
- Invalid/over-stock checkout is rejected with a clear message.

## F7. Manual Order Creation

**Description:** Staff create orders on behalf of customers (walk-in, phone, chat).

- Staff select/create a customer, add variants, set quantities, choose payment method and sale channel.

**AC:**
- Staff can create a full order that appears in the customer's order history.
- The order records `staff_id` and the chosen `sale_channel_id`.

## F8. Order Management

**Description:** Admin/staff manage orders and their statuses.

- Update order status (`pending → confirmed → processing → shipped → delivered`, or `cancelled`).
- Update payment status (`unpaid`, `partial`, `paid`).

**AC:**
- Staff can view all orders and update statuses.
- Cancelling releases committed stock.
- Status history is traceable (timestamps).

## F9. Payments

**Description:** Manual payment recording.

- Admin manages `payment_methods` (defaults: COD, KPay, Wave).
- Staff record payments (amount, method, reference, status) against an order.

**AC:**
- Admin can create/deactivate payment methods.
- Recording a payment updates the order's `payment_status` accordingly.
- Customer sees payment status on their order.

## F10. Inventory / Stock

**Description:** Track stock per variant.

- Stock decrements on order confirmation (see open questions).
- Staff can adjust stock (with `stock_movements` log).

**AC:**
- Stock reflects available quantity per variant.
- Low/out-of-stock items are flagged in the admin UI and excluded/limited at checkout.

## F11. Invoices

**Description:** Generate a printable invoice per order.

**AC:**
- Staff can generate an invoice with a unique number.
- Invoice lists customer, items, quantities, prices, totals, payment method/status.
- Invoice is exportable/printable (PDF).

## F12. Reports

**Description:** Daily/weekly/monthly sales reports with filters.

- Periods: daily, weekly, monthly.
- Filters: date range, sale channel, payment method, category.
- Metrics: total sales, order count, units sold, payment status breakdown, inventory movement.

**AC:**
- Admin (and scoped staff) can run a report for a chosen period and filter set.
- Report data matches the `orders`/`payments` records.
- Report is exportable (CSV/PDF) where applicable.

## F13. Sale Channels

**Description:** Tag orders with their source for attribution.

- Channels: `website`, `facebook`, `tiktok`, `walk_in`, `phone`.
- Used for filtering orders and reports.

**AC:**
- Every order has a sale channel.
- Reports can filter by sale channel.

## F14. Localization (i18n)

**Description:** English + Burmese UI.

**AC:**
- All UI text appears in the selected language.
- No hardcoded strings in components.
- Dates/numbers/currency (MMK) formatted per locale.
