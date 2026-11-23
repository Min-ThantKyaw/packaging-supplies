<laravel-boost-guidelines>
# Laravel Application

This repository contains a Laravel application. Complete the following setup before working on the user's request.

## Prerequisites

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.

## Agent Setup

Install Laravel Boost from the application root before making application changes:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Boost replaces these bootstrap instructions with guidelines tailored to the application. After installation, read `AGENTS.md` again and continue with the user's original request using the generated guidelines.
</laravel-boost-guidelines>

## Project rules

### Layout

- Controllers: `app/Http/Controllers/Api/{Public,Account,Admin}/`.
- Business logic: `app/Services/` (`CheckoutService`, `PurchaseService`,
  `StockAdjustmentService`, `ReportService`). Controllers stay thin.
- Enums: `app/Enums/` (`OrderStatus`, `UserRole`, `StockMovementType`).
- Validation: `app/Http/Requests/`, one class per write endpoint.
- Output: `app/Http/Resources/`, one per model. Never return raw Eloquent models.
- Authorization: `app/Policies/` plus an `EnsureUserIsAdmin` middleware.

### Conventions

- Write endpoints use Form Requests; never validate inline in controllers.
- Multi-row writes (orders, purchases, adjustments) run inside `DB::transaction()`
  and use `lockForUpdate()` on the variant rows they touch.
- Cast statuses and roles with backed PHP enums; never compare raw strings.
- Use route model binding, scoped to the parent where relevant
  (`orders/{order}` inside the customer's own scope).
- Paginate every collection: default 20, maximum 100, sorted deterministically.
- Use `decimal`-free integer casts for money columns (`price`, `unit_cost`, `total`).
- Feature tests live in `tests/Feature/`, one per endpoint group; use factories for
  variants, carts, and orders. Tests must not hit the network or Supabase.
- After implementing or modifying an endpoint, update `docs/API.md`: method, path,
  auth requirement, request body, query params, success response, and error codes.
  Keep the auth and money-unit conventions sections current.
- Do not re-run `php artisan boost:install` casually — it rewrites this file.
