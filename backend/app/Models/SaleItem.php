<?php

namespace App\Models;

use App\Enums\UnitType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_variant_id',
        'product_name',
        'variant_label',
        'sku',
        'unit_type',
        'quantity',
        'base_quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_type' => UnitType::class,
        'quantity' => 'integer',
        'base_quantity' => 'integer',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
