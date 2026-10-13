<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariant extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'product_id',
        'sku',
        'size',
        'color',
        'thickness',
        'unit',
        'pack_size',
        'unit_price',
        'pack_price',
        'sell_by_unit',
        'sell_by_pack',
        'cost_price',
        'is_active',
    ];

    protected $casts = [
        'pack_size' => 'integer',
        'sell_by_unit' => 'boolean',
        'sell_by_pack' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
