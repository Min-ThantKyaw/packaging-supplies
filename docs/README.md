# Packaging Supplies — Documentation Index

B2B ordering portal for a packaging supplies business (**Delivery Bags**, **Delivery Stickers**, **Bubble Wrap**). Serves both customers (public storefront) and internal staff (back office).

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel (PHP) |
| Frontend | React + TypeScript + Vite |
| Database | MySQL |
| Auth | Laravel Sanctum (token-based API) |
| i18n | Laravel `lang/` (backend) + i18next (frontend) |

## Documentation Set

| Doc | Purpose |
|-----|---------|
| [PROJECT.md](PROJECT.md) | **Overview** — product vision, goals, roles, scope, business model |
| [INSTRUCTIONS.md](INSTRUCTIONS.md) | **Instructions** — environment setup, run commands, dev workflow |
| [RULES.md](RULES.md) | **Rules** — business rules, RBAC, validation, conventions |
| [DATA_STRUCTURE.md](DATA_STRUCTURE.md) | **Data structure** — full database schema, relationships, seed data |
| [DESIGN.md](DESIGN.md) | **Design** — architecture, API design, UI/frontend design |
| [FEATURE_SPECS.md](FEATURE_SPECS.md) | **Feature specs** — detailed per-feature requirements + acceptance criteria |

## Reading Order (for AI agents)

1. [PROJECT.md](PROJECT.md) — understand what the product is and who uses it
2. [RULES.md](RULES.md) — business rules and constraints that govern behavior
3. [DATA_STRUCTURE.md](DATA_STRUCTURE.md) — the data model everything is built on
4. [DESIGN.md](DESIGN.md) — architecture, API contracts, UI structure
5. [FEATURE_SPECS.md](FEATURE_SPECS.md) — implement features against the specs
6. [INSTRUCTIONS.md](INSTRUCTIONS.md) — set up and run the project

## Key Facts (quick reference)

- **Roles:** `admin`, `sales_staff`, `customer`
- **Products:** Delivery Bags, Delivery Stickers, Bubble Wrap
- **Variants:** size (dimension-based for bags), color, thickness
- **Origin:** `local` / `import`
- **Pricing:** MMK only; each variant has a `unit_price` and a `pack_price`
- **Payments:** manual only (COD, KPay, Wave + admin-created methods)
- **Shipping:** manual (no courier API)
- **Sale channels:** website, facebook, tiktok, walk_in, phone
- **i18n:** English + Burmese (Myanmar)
- **Reports:** daily / weekly / monthly, with filters
