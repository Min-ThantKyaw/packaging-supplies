# Changelog

Reverse chronological. One section per feature; each row is a touched file and a
short description. Updated at the end of every feature.

## Categories API

| File | Change |
|---|---|
| `backend/app/Enums/CategoryGroup.php` | New: four backed cases (`mailers-envelopes`, `boxes-cartons`, `bags-pouches`, `protective-tapes`) with `label()`, matching the SPA's `CategoryGroupId`. |
| `backend/database/migrations/2026_11_28_090000_create_categories_table.php` | New: `categories` with unique slug, enum-backed `group`, optional description, `is_active`, `is_featured`, `sort_order`, and indexes on `(group, sort_order)` / `(is_active, sort_order)`. |
| `backend/app/Models/Category.php` | New: enum/boolean casts, slug generation with `-2` suffixing on create, slug stability on rename, `active` / `featured` / `ordered` scopes. |
| `backend/database/factories/CategoryFactory.php` | New: default, `inactive`, `featured` and `inGroup` states. |
| `backend/app/Http/Requests/Category/StoreCategoryRequest.php` | New: name and group required; optional slug, description, flags, sort order. |
| `backend/app/Http/Requests/Category/UpdateCategoryRequest.php` | New: PATCH semantics; slug unique ignoring the bound category. |
| `backend/app/Http/Requests/Category/ReorderCategoriesRequest.php` | New: `ids` must exist and be distinct; optional `group`. |
| `backend/app/Http/Requests/Category/FilterCategoriesRequest.php` | New: `search`, `group`, `is_active`, `per_page`, `page`. |
| `backend/app/Http/Resources/CategoryResource.php` | New: category payload including `group_label`; `image_url` is null until F16. |
| `backend/app/Http/Controllers/Api/Public/CategoryController.php` | New: active-only, ordered, paginated index with `group` and `featured` filters. |
| `backend/app/Http/Controllers/Api/Admin/CategoryController.php` | New: index with filters, store (201), show, update, destroy (204), reorder inside a transaction. |
| `backend/routes/api.php` | Added public `GET /categories` and the first `/admin` group (`auth:sanctum` + `admin`) with the category resource; reorder declared before the resource. |
| `backend/database/seeders/CategorySeeder.php` | New: the 20 starting categories, idempotent on slug, mirroring `web/src/features/catalog/data/categories.ts`. |
| `backend/database/seeders/DatabaseSeeder.php` | Calls `CategorySeeder`. |
| `backend/tests/Feature/CategoryEndpointsTest.php` | New: 13 tests — visibility, ordering, filters, pagination, auth, slug generation and collisions, slug stability, reorder, delete. |
| `docs/API.md` | New Categories section; removed the F11 planned contract and the dangling `FEATURES.md` reference. |
| `docs/CHANGELOG.md` | Added this section. |

## D13 — Editorial split hero

| File | Change |
|---|---|
| `web/src/features/catalog/components/HomeHero.tsx` | Rebuilt as an editorial split: all-caps condensed Archivo headline (`font-stretch` 64% → 68% from `sm`), body copy, solid primary CTA plus a text link, and a `dl` spec strip under a rule (60 micron / 50 pcs / Yangon). Right column is an `accent-soft` stage with no border and three overlapping mailers; the middle one breaks the stage's top edge. Dropped the icon fact row and the per-mailer colour captions. |
| `web/src/components/ui/button.ts` | `buttonPrimary` fill moved from `accent` (#EA580C, 3.56:1 with white) to `accent-strong` (#C2410C, 5.18:1); hover is now `ink`. |
| `docs/FEATURES.md` | D13 added and ticked; D14 queued for the remaining `text-accent` contrast failures. |
| `docs/CHANGELOG.md` | Added this section. |

## D12 — Hero without a card

| File | Change |
|---|---|
| `web/src/features/catalog/components/HomeHero.tsx` | Removed the outer `rounded-card border bg-card` frame, the inner bordered preview panel and the two floating chips. Mailers now sit directly on `surface` as figures with colour captions and one line about the self-seal strip. Headline is one colour (the accent second line is gone), the badge pill is gone, and the fact icons are `muted` so the primary button is the only accent. |
| `docs/FEATURES.md` | D12 added and ticked. |
| `docs/CHANGELOG.md` | Added this section. |

## F10 — Account shell

| File | Change |
|---|---|
| `web/src/layouts/AccountLayout.tsx` | Rebuilt on D07 tokens: MG brand header, signed-in identity from `/me`, Overview · Orders · Addresses rail, sign-out. |
| `web/src/features/account/components/AccountPanel.tsx` | New: shared D07 panel for the account pages. |
| `web/src/features/account/pages/AccountHomePage.tsx` | Replaced the placeholder: greeting plus name and email from the session, with cards linking Orders and Addresses. |
| `web/src/features/account/pages/AccountOrdersPage.tsx` | New placeholder; links to `/products` while order history waits for F27. |
| `web/src/features/account/pages/AccountAddressesPage.tsx` | New placeholder; saved addresses arrive with F23. |
| `web/src/routes/router.tsx` | Added `/account/orders` and `/account/addresses`. |
| `docs/FEATURES.md` | F09 and F10 ticked; D10 now lists auth and admin only, since the account shell moved to D07. |
| `web/AGENTS.md` | Session and 401 conventions updated; account noted as D07. |
| `docs/CHANGELOG.md` | Added the F09 and F10 sections. |

## F09 — Session bootstrap

| File | Change |
|---|---|
| `web/src/api/client.ts` | Token store with `subscribeToToken`; `setToken`/`clearToken` notify subscribers; a `401` clears the token instead of redirecting, so public pages are not bounced to login. |
| `web/src/api/auth.ts` | Added the shared `meQueryKey`; `logout` accepts an explicit token so the revoke survives the local sign-out. |
| `web/src/features/auth/session.ts` | New: `useAuthToken` (cross-tab token store), `useSession` (`GET /me` hydration, `loading`/`authenticated`/`anonymous`/`error`, no retry on 401), `useSignOut` (navigate out first, clear token and cache, then revoke best-effort). |
| `web/src/routes/guards.tsx` | `RequireAuth` reacts to token changes; `AdminRoute` now role-gates on `user.role` with a 403 panel. |
| `web/src/features/auth/components/SessionError.tsx` | New: retry panel when `/me` cannot be reached while a token is stored. |
| `web/src/components/ui/ForbiddenPage.tsx` | New: D07 403 page for customers visiting `/admin` (server still enforces). |
| `web/src/components/ui/PageFallback.tsx` | Loading text moved to the `muted` token. |
| `web/src/layouts/StorefrontLayout.tsx` | Session-aware nav: Sign out when signed in, Sign in otherwise, plus a mobile Account link. |
| `web/src/features/auth/pages/LoginPage.tsx` | Seeds the shared `meQueryKey` after login. |
| `web/src/features/auth/pages/RegisterPage.tsx` | Seeds the shared `meQueryKey` after registration. |

## Maintenance — demo customer seeder

| File | Change |
|---|---|
| `backend/database/seeders/DemoCustomerSeeder.php` | New: creates or updates `customer@example.com` (`password`), overridable with `DEMO_CUSTOMER_EMAIL` / `DEMO_CUSTOMER_PASSWORD`; skips outside `APP_ENV=local` so known-password accounts cannot be seeded in production. |
| `backend/database/seeders/DatabaseSeeder.php` | Runs `DemoCustomerSeeder` after `AdminUserSeeder`. |
| `backend/tests/Feature/DemoCustomerSeederTest.php` | New: creates the customer, updates without duplicating, and skips outside `local`. |
| `backend/.env.example` | Documented the optional demo customer overrides. |
| `docs/docker.md` | Added the seeding command and what each seeder creates. |

## D02 — Storefront home and shell

| File | Change |
|---|---|
| `web/src/features/catalog/data/sizeLadder.ts` | New: five mailers and five bags in inches with "what fits" copy, pack and unit prices as placeholder integers, plus the 10 × 13 pack ladder; F18 replaces it with `/api/products`. |
| `web/src/features/catalog/pages/HomePage.tsx` | Replaced the placeholder: hero, to-scale size wall (column widths = the bags' own inches), per-family size lists with prices, pack ladder, ordering steps. |
| `web/src/layouts/StorefrontLayout.tsx` | Header, badge, footer and type retinted to the tokens; footer carries hours and the kyat note. |
| `web/src/components/ui/nav.ts` | Added `storefrontNavLinkClass` to the tokens; admin and account keep `navLinkClass` until D04. |
| `web/src/components/ui/BagPlate.tsx` | Caption accepts a node (so a `SpecTag` can stand in for the text) and `showCaption` for thumbnail rows. |
| `web/src/components/ui/SpecTag.tsx` | Added `compact` for the size wall: no unit, tighter type, so five tags fit across a 360 px row without colliding. |
| `docs/FEATURES.md` | D02 ticked; scope recorded as built, including why the nav keeps its three current links. |
| `docs/CHANGELOG.md` | Added this section. |

## D01 — Design tokens and primitives

| File | Change |
|---|---|
| `web/src/index.css` | `@font-face` for Archivo Variable plus a matched-metric Arial fallback (measured x-height and ascent overrides); `@theme` tokens for film/sheet/ink/silver/seal, `radius-diecut`/`radius-label` and `--font-sans`; film body, ink text, one `seal` focus ring. |
| `web/public/fonts/archivo-var.woff2` | New: Archivo variable, Latin subset (90 KB), wdth 62–125 · wght 100–900. |
| `web/public/fonts/OFL.txt` | New: SIL Open Font License 1.1 for Archivo. |
| `web/index.html` | Preloaded the font, added `theme-color`, and rewrote the description and title in the shop's voice. |
| `web/src/components/ui/button.ts` | New: `buttonPrimary`, `buttonQuiet`, `buttonTight` class constants. |
| `web/src/components/ui/SpecTag.tsx` | New: condensed tabular dimension tag with a spelled-out accessible label. |
| `web/src/components/ui/BagPlate.tsx` | New: to-scale SVG die-line, `photoSrc` slot for F16, `sealHeld` for pointer/focus state. |
| `web/src/components/ui/PerforatedDivider.tsx` | New: horizontal or vertical tear line, presentation only. |
| `web/src/layouts/StorefrontLayout.tsx` | Wrapper switched to `bg-film text-ink`; structure untouched. |
| `docs/FEATURES.md` | Working agreement now covers `D..` items; added the Design track with D01 ticked; F08, F16 and F18 state what they consume. |
| `docs/CHANGELOG.md` | Added this section. |

## F06 — Auth endpoints

| File | Change |
|---|---|
| `backend/routes/api.php` | Added public `POST /register` and `POST /login`; `GET /me` and `POST /logout` behind `auth:sanctum`. |
| `backend/app/Http/Controllers/Api/Public/AuthController.php` | New: register (customer by default, 201 + token) and login (credential check, 422 on failure). |
| `backend/app/Http/Controllers/Api/Account/AuthController.php` | New: `me` and `logout` (revokes only the current token). |
| `backend/app/Http/Requests/Auth/AuthRequest.php` | New: shared authorization and lowercase email normalisation. |
| `backend/app/Http/Requests/Auth/RegisterRequest.php` | New: name, unique email, confirmed min-8 password. |
| `backend/app/Http/Requests/Auth/LoginRequest.php` | New: email and password validation. |
| `backend/app/Http/Resources/UserResource.php` | New: user payload (id, name, email, role, timestamps). |
| `backend/app/Http/Resources/AuthTokenResource.php` | New: `data.token`, `data.token_type`, `data.user`. |
| `backend/tests/Feature/AuthEndpointsTest.php` | New: register, validation, login, `/me`, logout and revoked-token cases. |
| `docs/API.md` | Documented the four auth endpoints and their error cases. |
| `docs/FEATURES.md` | F06 ticked. |
| `docs/CHANGELOG.md` | Added the F06 section. |

## Maintenance — Docker vendor resync

| File | Change |
|---|---|
| `backend/docker/entrypoint.sh` | Runs `composer install` when `composer.lock` is newer than the installed packages, so new dependencies reach the container's `vendor` volume. |
| `docs/docker.md` | Documented the lockfile resync. |

## F05 — API reference skeleton

| File | Change |
|---|---|
| `docs/API.md` | Documented the JSON-only error envelope, added 401/403/404/429 examples, and corrected the health endpoint path and healthcheck note. |
| `docs/FEATURES.md` | F03, F04 and F05 ticked. |
| `docs/CHANGELOG.md` | Added F03–F05 sections. |

## F04 — SPA shell

| File | Change |
|---|---|
| `web/package.json`, `web/package-lock.json` | Added `react-router` 8, `@tanstack/react-query` 5 and `axios`. |
| `web/src/api/client.ts` | New: axios instance, bearer token storage, `ApiError` normalisation, 401 logout + redirect. |
| `web/src/lib/queryClient.ts` | New: TanStack Query client defaults. |
| `web/src/lib/money.ts` | New: `formatMoney`, 1 minor unit = 1 kyat. |
| `web/src/routes/router.tsx` | New: data router with storefront, account and admin branches. |
| `web/src/routes/guards.tsx` | New: `RequireAuth` and `AdminRoute` stubs that preserve `?redirect=`. |
| `web/src/routes/lazy.tsx` | New: lazy admin layout and dashboard chunks. |
| `web/src/layouts/StorefrontLayout.tsx` | New: storefront header, navigation and footer. |
| `web/src/layouts/AccountLayout.tsx` | New: account shell behind the auth guard. |
| `web/src/layouts/AdminLayout.tsx` | New: lazy-loaded admin shell. |
| `web/src/components/ui/nav.ts` | New: shared `NavLink` active styling. |
| `web/src/components/ui/PlaceholderPage.tsx` | New: shared placeholder panel for shell pages. |
| `web/src/components/ui/PageFallback.tsx` | New: suspense fallback. |
| `web/src/components/ui/NotFoundPage.tsx` | New: 404 page. |
| `web/src/features/catalog/pages/HomePage.tsx` | New: storefront placeholder route. |
| `web/src/features/auth/pages/LoginPage.tsx` | New: login placeholder that surfaces `?redirect=`. |
| `web/src/features/account/pages/AccountHomePage.tsx` | New: account placeholder route. |
| `web/src/features/admin/pages/AdminDashboardPage.tsx` | New: admin dashboard placeholder route. |
| `web/src/App.tsx` | Replaced the Vite template with `QueryClientProvider` + `RouterProvider`. |
| `web/index.html` | Shop title and description. |
| `web/.env.example` | Documented `VITE_API_URL`. |

## F03 — Domain scaffolding

| File | Change |
|---|---|
| `backend/app/Enums/OrderStatus.php` | New: statuses, labels and the transition map. |
| `backend/app/Enums/StockMovementType.php` | New: movement types with inbound/outbound helpers. |
| `backend/app/Http/Resources/Resource.php` | New: base resource with `data` wrapping. |
| `backend/app/Services/CheckoutService.php` | New: documented service scaffold. |
| `backend/app/Services/PurchaseService.php` | New: documented service scaffold. |
| `backend/app/Services/StockAdjustmentService.php` | New: documented service scaffold. |
| `backend/app/Services/ReportService.php` | New: documented service scaffold. |
| `backend/app/Http/Middleware/ForceJsonResponse.php` | New: forces `Accept: application/json` on API routes. |
| `backend/bootstrap/app.php` | Prepended the JSON middleware to the API group; added validation, auth and HTTP exception renderers for the consistent envelope. |
| `backend/tests/Feature/DomainScaffoldingTest.php` | New: transition map, enums, base resource and service autoload tests. |
| `backend/tests/Feature/ErrorEnvelopeTest.php` | New: 401/403/404/422/429 and JSON-without-Accept tests. |

Factory skeleton: `UserFactory` (F02) remains the pattern; there are no new models to add factories for until F11/F12.

## Project setup

| File | Change |
|---|---|
| `AGENTS.md` | Root instructions: layout, stack decisions, invariants, commands, guardrails, verification. |
| `backend/AGENTS.md` | Appended project rules (services, requests, resources, enums, tests, API docs). |
| `web/AGENTS.md` | New: routing, data fetching, forms, styling, admin isolation, token handling. |
| `docs/API.md` | New: API conventions, auth, money, pagination, errors, `GET /health`. |
| `docs/FEATURES.md` | New: 42-feature backlog, working agreement, MVP line, out-of-scope list. |

## D10 — remove the /demo sandbox

| File | Change |
|---|---|
| `web/src/routes/router.tsx` | Removed `/demo`, `/demo/products` and `/demo/catalog`. |
| `web/src/routes/lazy.tsx` | Removed the `DemoPage` lazy chunk. |
| `web/src/features/demo/**` | Deleted with its mock admin, cart, quick view and category components. |
| `web/src/features/catalog/data/products.ts` | Dropped the `demoShipping` alias and demo-only comments. |
| `docs/FEATURES.md` | D10 ticked; reskin split into D11. |

## D09 — products page

| File | Change |
|---|---|
| `web/src/features/catalog/pages/ProductsPage.tsx` | New: `/products` with sticky category rail, `?category=` filter, read-only cards and quick view. |
| `web/src/features/catalog/components/CategoryList.tsx` | New: grouped category list with counts, “Soon” and active state, shared by the sidebar. |
| `web/src/features/catalog/components/CategorySidebar.tsx` | New: sticky desktop rail. |
| `web/src/features/catalog/components/CategoryMenu.tsx`, `CategoryDrawer.tsx` | Category links now target `/products?category=…`; “All products” replaces “View all categories”. |
| `web/src/features/catalog/pages/HomePage.tsx` | “View all products” links to `/products`. |
| `web/src/features/catalog/components/ProductQuickView.tsx` | “Browse category” links to the filtered products page. |
| `web/src/routes/router.tsx` | Added `/products`; `/categories`, `/catalog` and `/catalog/:slug` redirect to it. |
| Deleted | `CategoriesPage`, `CategoryPlaceholderPage`, `CategoryTile`, `CategoryPlate`. |
| `docs/FEATURES.md` | D09 ticked. |

## D08 — storefront home

| File | Change |
|---|---|
| `web/src/features/catalog/data/categories.ts` | Rewritten as the canonical mock: 20 categories with group, icon, active flag and sort order. |
| `web/src/features/catalog/data/products.ts` | New: canonical mock products, sizes, colours, pack tiers, pricing helpers, products-per-category and from-price. |
| `web/src/features/demo/data.ts` | Reduced to a compatibility re-export; the demo now shares the canonical catalogue. |
| `web/src/features/catalog/components/MailerPreview.tsx` | Moved from the demo; shared by both surfaces. |
| `web/src/features/catalog/components/Blueprint.tsx` | Moved from the demo; shared dimension drawing. |
| `web/src/features/catalog/components/HomeHero.tsx` | New: MG Packaging hero with spec stats and tinted previews. |
| `web/src/features/catalog/components/CatalogProductCard.tsx` | New: live swatches, sizes, pack tiers and spec badges; “View details” only. |
| `web/src/features/catalog/components/ProductQuickView.tsx` | New: read-only quick view with blueprint and pack pricing; no cart or quantity. |
| `web/src/features/catalog/pages/HomePage.tsx` | Rebuilt as hero + Best sellers. |
| `web/src/features/catalog/components/CategoryMenu.tsx`, `CategoryDrawer.tsx` | Per-category icons and counts derived from products. |
| `web/src/features/catalog/components/CategoryTile.tsx`, `pages/CategoryPlaceholderPage.tsx` | Counts and from-prices derived from products. |
| `web/src/layouts/StorefrontLayout.tsx` | MG monogram square and MG Packaging wordmark. |
| `web/index.html` | Title and description updated to MG Packaging. |
| Deleted | `BagPlate`, `SpecTag`, `FilterPills`, `MostOrderedRow`, `sizeLadder`, demo-local `MailerPreview`/`Blueprint`/`categoryIcons`. |
| `docs/FEATURES.md` | D08 ticked. |

## D07 — palette and storefront shell

| File | Change |
|---|---|
| `web/src/index.css` | New D07 `@theme` tokens (surface/card/ink/line/muted/accent, card/control radii); Archivo kept; legacy D01 aliases retained for unmigrated pages. |
| `web/src/components/ui/button.ts` | Primary/quiet/tight buttons restyled to the accent system. |
| `web/src/components/ui/field.ts` | Labels, inputs, hints and errors moved to the new tokens with a dedicated danger colour. |
| `web/src/hooks/useDialogA11y.ts` | New shared location for the overlay focus/scroll behaviour. |
| `web/src/features/catalog/components/CategoryMenu.tsx` | New: desktop category dropdown with inline search, counts and all categories. |
| `web/src/features/catalog/components/CategoryDrawer.tsx` | New: mobile category drawer with grouped accordions, search and focus handling. |
| `web/src/layouts/StorefrontLayout.tsx` | Rebuilt header/footer; dropdown on desktop, drawer below `lg`, Account/Sign in nav. |
| `web/src/features/catalog/components/ShopMegaMenu.tsx` | Deleted — replaced by `CategoryMenu`. |
| `web/src/features/catalog/components/MobileCategoryDrawer.tsx` | Deleted — replaced by `CategoryDrawer`. |
| `web/src/features/demo/useDialogA11y.ts` | Deleted; demo overlays import the shared hook. |
| `web/index.html` | Theme colour updated to `#F8FAFC`. |
| `docs/FEATURES.md` | D07 ticked; D01/D02/D05 marked superseded; D08–D10 added; storefront decisions rewritten. |

## D06 follow-up — products page and category rail

| File | Change |
|---|---|
| `web/src/features/demo/data.ts` | Removed the shortlist; the category navigation now shows every active category. |
| `web/src/features/demo/components/CategoryList.tsx` | New: shared grouped category list with icons, counts and “Soon” for empty categories. |
| `web/src/features/demo/components/CategorySidebar.tsx` | New: sticky desktop rail for the products page. |
| `web/src/features/demo/components/CategoryMenu.tsx` | New: desktop category dropdown with inline search and counts. |
| `web/src/features/demo/components/CategoryDrawer.tsx` | New: off-canvas drawer with search and focus handling, used below `lg`. |
| `web/src/features/demo/components/ProductsView.tsx` | New: `/demo/products` page with sidebar, `?category=` filtering and product grid. |
| `web/src/features/demo/DemoPage.tsx` | Desktop dropdown plus mobile hamburger, drawer state, and home links/CTAs pointed at `/demo/products`. |
| `web/src/features/demo/components/MegaMenu.tsx` | Deleted. |
| `web/src/features/demo/components/CatalogView.tsx` | Deleted. |
| `web/src/routes/router.tsx` | Added `/demo/products`; `/demo/catalog` now loader-redirects there with the query preserved. |
| `docs/FEATURES.md` | D06 description updated. |

## D06 — Gemini-style /demo sandbox

| File | Change |
|---|---|
| `web/src/features/demo/data.ts` | New: mock types, 20 categories, six products, pack tiers, pricing and cart-line helpers. |
| `web/src/features/demo/ui.ts` | New: demo-scoped input, button and card classes. |
| `web/src/features/demo/useDialogA11y.ts` | New: shared scroll lock, Escape, focus trap and focus restore for overlays. |
| `web/src/features/demo/components/MailerPreview.tsx` | New: colour-tinted mailer illustration. |
| `web/src/features/demo/components/Blueprint.tsx` | New: dimension drawing with usable area and seal flap. |
| `web/src/features/demo/components/MegaMenu.tsx` | New: grouped desktop mega-menu with inline filter and Lucide category icons. |
| `web/src/features/demo/components/CategoryPills.tsx` | New: scrollable filter pills with pointer scroll buttons. |
| `web/src/features/demo/components/Hero.tsx` | New: split hero with colour previews and bulk/spec stats. |
| `web/src/features/demo/components/ProductCard.tsx` | New: live swatch, size chips, 50/100/500 tiers and spec badges. |
| `web/src/features/demo/components/QuickView.tsx` | New: dialog/bottom sheet with blueprint, tiers, quantity and add-to-cart. |
| `web/src/features/demo/components/CartDrawer.tsx` | New: slide-over cart with free-delivery progress, quantities and totals. |
| `web/src/features/demo/components/AdminView.tsx` | New: category reorder/rename/toggle/add and product size, colour and price editors. |
| `web/src/features/demo/DemoPage.tsx` | New: demo shell, shared state, Storefront/Admin toggle, cart and quick view. |
| `web/src/routes/lazy.tsx` | Added the lazy `DemoPage` chunk. |
| `web/src/routes/router.tsx` | Added `/demo`, outside the storefront layout. |
| `docs/FEATURES.md` | D06 ticked. |

## D05 — Category index and navigation shell

| File | Change |
|---|---|
| `web/package.json`, `web/package-lock.json` | Added `lucide-react` for utility icons only. |
| `web/src/features/catalog/data/categories.ts` | New: 21 mock categories in four groups, group metadata and counter picks. |
| `web/src/features/catalog/components/CategoryPlate.tsx` | New: four group silhouettes (mailer, box, pouch, roll) in the D01 line language. |
| `web/src/features/catalog/components/CategoryTile.tsx` | New: category link with plate, product count and from-price. |
| `web/src/features/catalog/components/CategorySearch.tsx` | New: shared inline category filter input. |
| `web/src/features/catalog/components/ShopMegaMenu.tsx` | New: desktop grouped mega-menu with search, outside-click and Escape. |
| `web/src/features/catalog/components/MobileCategoryDrawer.tsx` | New: full-screen drawer with search, accordion groups, focus trap and scroll lock. |
| `web/src/features/catalog/components/FilterPills.tsx` | New: scrollable category pills with pointer-only scroll buttons. |
| `web/src/features/catalog/components/MostOrderedRow.tsx` | New: snap row filtered by the active pill. |
| `web/src/features/catalog/pages/HomePage.tsx` | Reordered for mobile: hero → categories → pills/picks → size teaser → ordering steps. |
| `web/src/features/catalog/pages/CategoriesPage.tsx` | New: full grouped index at `/categories`. |
| `web/src/features/catalog/pages/CategoryPlaceholderPage.tsx` | New: `/catalog/:slug` stub until F18, so category links never 404. |
| `web/src/layouts/StorefrontLayout.tsx` | Mega-menu in the desktop nav; menu button and drawer on small screens. |
| `web/src/routes/router.tsx` | Added `/categories` and `/catalog/:slug`. |
| `docs/FEATURES.md` | D05 ticked. |

## Docs — storefront scope review

| File | Change |
|---|---|
| `docs/FEATURES.md` | Added D05 (category index/navigation shell), the four storefront decisions and the approved `lucide-react` use; expanded F11–F15 (groups, colour hex, dimensions, pack tiers, specs), F18–F22 (grouped nav, filter pills, quick view, slide-over cart, shipping summary) and F24 (shipping at checkout). |
| `docs/API.md` | Added a clearly marked "Planned contracts" block: category summary for F11, cart shipping summary for F20. |

Decisions recorded: D01 tokens stay; pack tiers are variants; bulk pricing only; admin
behind auth with no public toggle; plate illustrations until photos exist; shipping
values demo-only in `backend/config/shop.php`.

## F08 — Login and register pages

| File | Change |
|---|---|
| `web/package.json`, `web/package-lock.json` | Added `react-hook-form`, `zod`, `@hookform/resolvers` (approved). |
| `web/src/api/auth.ts` | New: auth types plus login, register, logout, me calls. |
| `web/src/features/auth/schemas.ts` | New: zod schemas for login and registration. |
| `web/src/features/auth/redirect.ts` | New: rejects non-same-origin `?redirect=` targets. |
| `web/src/features/auth/formErrors.ts` | New: maps `ApiError` to per-field and form-level messages. |
| `web/src/components/ui/field.ts` | New: label, input, hint and error classes. |
| `web/src/features/auth/components/AuthShell.tsx` | New: die-cut sign-in slip with mode switch and order-notes stub (D03). |
| `web/src/features/auth/pages/LoginPage.tsx` | Replaced the placeholder with the wired form, 422 mapping and redirect. |
| `web/src/features/auth/pages/RegisterPage.tsx` | New: registration form with confirmation and 422 mapping. |
| `web/src/routes/router.tsx` | Added the `/register` route. |
| `docs/FEATURES.md` | D03 and F08 ticked. |

## F07 — Auth hardening

| File | Change |
|---|---|
| `backend/app/Providers/AppServiceProvider.php` | Named `login` (email + IP) and `register` (IP) rate limiters. |
| `backend/routes/api.php` | Applied `throttle:login` and `throttle:register`. |
| `backend/lang/en/auth.php` | New: human-readable credential failure copy. |
| `backend/tests/Feature/AuthRateLimitTest.php` | New: throttling, per-email isolation, expired tokens, message copy. |
| `docs/API.md` | Documented the 429 limits on register and login. |
| `docs/FEATURES.md` | F07 ticked. |

## F02 — Roles and admin guard

| File | Change |
|---|---|
| `backend/app/Enums/UserRole.php` | New: `customer` / `admin` backed enum with `label()`. |
| `backend/database/migrations/2026_11_23_160529_add_role_to_users_table.php` | New: `role` column, default `customer`, indexed. |
| `backend/app/Models/User.php` | `role` enum cast, `isAdmin()`, role excluded from `$fillable`. |
| `backend/app/Http/Middleware/EnsureUserIsAdmin.php` | New: 401 for guests, 403 for customers. |
| `backend/bootstrap/app.php` | Registered `admin` middleware alias. |
| `backend/database/seeders/AdminUserSeeder.php` | New: idempotent owner account from `ADMIN_EMAIL` / `ADMIN_PASSWORD`. |
| `backend/database/seeders/DatabaseSeeder.php` | Calls `AdminUserSeeder`. |
| `backend/database/factories/UserFactory.php` | Default `customer` role, added `admin()` state. |
| `backend/tests/Feature/AdminMiddlewareTest.php` | New: 401 / 403 / 200 cases. |
| `backend/tests/Feature/AdminUserSeederTest.php` | New: creates and updates the owner without duplicating. |
| `backend/tests/Feature/UserRoleTest.php` | New: default role, role not mass assignable. |
| `docs/API.md` | Documented roles and 401/403 behaviour. |
| `docs/FEATURES.md` | F02 ticked. |

## F01 — Sanctum, CORS, environment

| File | Change |
|---|---|
| `backend/composer.json`, `backend/composer.lock` | Added `laravel/sanctum`. |
| `backend/config/sanctum.php` | New: published, `expiration` from `SANCTUM_EXPIRATION` (default 10080). |
| `backend/config/cors.php` | New: origins from `FRONTEND_URL`, credentials disabled, max-age set. |
| `backend/config/app.php` | Timezone from `APP_TIMEZONE`. |
| `backend/app/Models/User.php` | Added `HasApiTokens`. |
| `backend/database/migrations/2026_11_23_092323_create_personal_access_tokens_table.php` | New: Sanctum token table. |
| `backend/.env.example` | Added `APP_TIMEZONE`, `FRONTEND_URL`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`. |
| `backend/.env` (local, untracked) | Appended `APP_TIMEZONE`, `FRONTEND_URL`, `SANCTUM_EXPIRATION`. |
| `backend/phpunit.xml` | Pinned timezone, frontend URL, token expiry for tests. |
| `backend/tests/Feature/CorsTest.php` | New: allowed origin, preflight, rejected origin. |
| `backend/tests/Feature/FoundationConfigTest.php` | New: timezone, token expiry, `HasApiTokens`. |
| `docs/API.md` | Documented token lifetime and CORS rules. |
| `docs/FEATURES.md` | F01 ticked. |

## Pending

- Design migration: D07–D10 are done and the account shell moved to D07 in F10. D11
  remains: auth and admin on D07 tokens, then remove the D01 aliases.
- Header cart, quick-view ordering and checkout wait for F20–F22.
- `ADMIN_EMAIL` / `ADMIN_PASSWORD` must be set in `backend/.env` before seeding the owner.
  The demo customer (`customer@example.com` / `password`) is seeded only in `local`.
- Composer audit advisories could not be fetched; Packagist is unreachable from the dev machine.
