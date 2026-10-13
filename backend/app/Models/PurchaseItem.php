<?php

namespace App\Models;

use App\Enums\UnitType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_variant_id',
        'product_name',
        'sku',
        'unit_type',
        'quantity',
        'base_quantity',
        'unit_cost',
        'subtotal',
    ];

    protected $casts = [
        'unit_type' => UnitType::class,
        'quantity' => 'integer',
        'base_quantity' => 'integer',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
