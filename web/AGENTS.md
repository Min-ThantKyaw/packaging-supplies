# Web app instructions

React 19 + TypeScript SPA with a public storefront, a customer account area, and an
admin panel. Read the root `AGENTS.md` first; its invariants apply here too.

## Layout

- `src/routes/` — router definition and guards (`router.tsx`, `guards.tsx`).
- `src/layouts/` — `StorefrontLayout`, `AccountLayout`, `AdminLayout`.
- `src/features/` — `catalog/`, `cart/`, `checkout/`, `orders/`, `auth/`, `admin/`.
- `src/api/` — `client.ts` plus one module per resource. All HTTP lives here.
- `src/components/ui/` — shared primitives. Storefront and admin both use them.
- `src/lib/` — `money.ts`, `queryClient.ts`, zod schemas shared by forms.
- `src/hooks/` — reusable hooks; no data fetching that belongs in `api/`.

## Conventions

- Routing uses React Router's data router. `/admin/*` is a lazy-loaded chunk wrapped in
  `AdminRoute`; `/account/*` uses `RequireAuth`. Guards redirect to `/login` with a
  `redirect` parameter and preserve it after login.
- All server state goes through TanStack Query. No `useEffect` + `fetch` in components.
  Query keys live next to their resource module.
- Every request goes through `src/api/client.ts`: it attaches the bearer token, maps
  401 to a logout + redirect, and normalises API errors. Components never call `fetch`
  directly and never read the token from storage.
- Forms use react-hook-form + zod. Map Laravel 422 field errors onto form fields.
- Styling is Tailwind utilities only. Put repeated patterns in `components/ui/`;
  avoid new CSS files and inline styles.
- Money is an integer in minor units from the API. Format with `lib/money.ts`; never
  `parseFloat` a price or compute totals client-side.
- Admin code may import from `components/ui`, `lib`, and `api` — but storefront code
  must never import from `features/admin/` or `layouts/AdminLayout`.
- The guest cart token and guest order token are stored in `localStorage` under
  namespaced keys (`cart_token`, `order_token:<number>`); only the cart/order modules
  touch them.
- Client-side role checks are UX only. The server enforces authorization; never rely on
  hiding a button for security.
- Only `VITE_API_URL` goes in Vite env. No secrets in `import.meta.env`.

## Commands

```sh
npm run dev      # Vite dev server on :5173
npm run build    # tsc -b && vite build
npm run lint     # ESLint
```

## Verification

- `npm run lint` and `npm run build` must pass before a change is considered done.
- Route changes: check both a signed-out visit and an admin-role visit to `/admin/*`.
