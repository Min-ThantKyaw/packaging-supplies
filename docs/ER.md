## Table `migrations`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int4` | Primary |
| `migration` | `varchar` |  |
| `batch` | `int4` |  |

## Table `users`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `name` | `varchar` |  |
| `email` | `varchar` |  Unique |
| `role` | `varchar` |  |
| `email_verified_at` | `timestamp` |  Nullable |
| `password` | `varchar` |  |
| `remember_token` | `varchar` |  Nullable |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |
| `phone` | `varchar` |  Nullable |
| `shop_name` | `varchar` |  Nullable |
| `locale` | `varchar` |  |
| `is_active` | `bool` |  |

## Table `categories`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `name` | `varchar` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `products`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `category_id` | `int8` |  |
| `name` | `varchar` |  |
| `description` | `text` |  Nullable |
| `origin` | `varchar` |  |
| `is_active` | `bool` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `personal_access_tokens`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `tokenable_type` | `varchar` |  |
| `tokenable_id` | `int8` |  |
| `name` | `text` |  |
| `token` | `varchar` |  Unique |
| `abilities` | `text` |  Nullable |
| `last_used_at` | `timestamp` |  Nullable |
| `expires_at` | `timestamp` |  Nullable |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `sale_channels`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `name` | `varchar` |  |
| `code` | `varchar` |  Unique |
| `is_active` | `bool` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `payment_methods`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `name` | `varchar` |  |
| `code` | `varchar` |  Unique |
| `is_active` | `bool` |  |
| `sort_order` | `int4` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `customers`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `name` | `varchar` |  |
| `phone` | `varchar` |  Nullable |
| `email` | `varchar` |  Nullable |
| `address` | `text` |  Nullable |
| `note` | `text` |  Nullable |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `suppliers`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `name` | `varchar` |  |
| `phone` | `varchar` |  Nullable |
| `email` | `varchar` |  Nullable |
| `address` | `text` |  Nullable |
| `note` | `text` |  Nullable |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `delivery_services`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `name` | `varchar` |  |
| `phone` | `varchar` |  Nullable |
| `note` | `text` |  Nullable |
| `is_active` | `bool` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `product_variants`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `product_id` | `int8` |  |
| `sku` | `varchar` |  |
| `size` | `varchar` |  Nullable |
| `color` | `varchar` |  Nullable |
| `thickness` | `varchar` |  Nullable |
| `unit` | `varchar` |  Nullable |
| `pack_size` | `int4` |  Nullable |
| `unit_price` | `numeric` |  |
| `pack_price` | `numeric` |  |
| `sell_by_unit` | `bool` |  |
| `sell_by_pack` | `bool` |  |
| `cost_price` | `numeric` |  |
| `is_active` | `bool` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `stocks`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `product_variant_id` | `int8` |  Unique |
| `quantity` | `int4` |  |
| `low_stock_threshold` | `int4` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `stock_movements`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `product_variant_id` | `int8` |  |
| `type` | `varchar` |  |
| `quantity_change` | `int4` |  |
| `reference_type` | `varchar` |  Nullable |
| `reference_id` | `int8` |  Nullable |
| `note` | `text` |  Nullable |
| `created_by` | `int8` |  Nullable |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `purchases`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `supplier_id` | `int8` |  Nullable |
| `purchase_number` | `varchar` |  |
| `purchased_at` | `date` |  |
| `status` | `varchar` |  |
| `subtotal` | `numeric` |  |
| `discount` | `numeric` |  |
| `total` | `numeric` |  |
| `note` | `text` |  Nullable |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `purchase_items`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `purchase_id` | `int8` |  |
| `product_variant_id` | `int8` |  Nullable |
| `product_name` | `varchar` |  |
| `sku` | `varchar` |  |
| `unit_type` | `varchar` |  |
| `quantity` | `int4` |  |
| `base_quantity` | `int4` |  |
| `unit_cost` | `numeric` |  |
| `subtotal` | `numeric` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `sales`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `sale_number` | `varchar` |  |
| `customer_id` | `int8` |  Nullable |
| `payment_method_id` | `int8` |  Nullable |
| `sale_channel_id` | `int8` |  Nullable |
| `delivery_service_id` | `int8` |  Nullable |
| `tracking_number` | `varchar` |  Nullable |
| `delivery_status` | `varchar` |  |
| `status` | `varchar` |  |
| `subtotal` | `numeric` |  |
| `discount` | `numeric` |  |
| `total` | `numeric` |  |
| `paid_amount` | `numeric` |  |
| `payment_status` | `varchar` |  |
| `settled_at` | `timestamp` |  Nullable |
| `delivered_at` | `timestamp` |  Nullable |
| `note` | `text` |  Nullable |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `sale_items`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `sale_id` | `int8` |  |
| `product_variant_id` | `int8` |  Nullable |
| `product_name` | `varchar` |  |
| `variant_label` | `varchar` |  Nullable |
| `sku` | `varchar` |  |
| `unit_type` | `varchar` |  |
| `quantity` | `int4` |  |
| `base_quantity` | `int4` |  |
| `unit_price` | `numeric` |  |
| `subtotal` | `numeric` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `expense_categories`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `name` | `varchar` |  |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

## Table `expenses`

### Columns

| Name | Type | Constraints |
|------|------|-------------|
| `id` | `int8` | Primary |
| `user_id` | `int8` |  |
| `expense_category_id` | `int8` |  Nullable |
| `expense_date` | `date` |  |
| `amount` | `numeric` |  |
| `note` | `text` |  Nullable |
| `created_by` | `int8` |  Nullable |
| `created_at` | `timestamp` |  Nullable |
| `updated_at` | `timestamp` |  Nullable |

