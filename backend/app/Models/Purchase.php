<?php

namespace App\Models;

use App\Enums\PurchaseStatus;
use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'purchase_number',
        'purchased_at',
        'status',
        'subtotal',
        'discount',
        'total',
        'note',
    ];

    protected $casts = [
        'purchased_at' => 'date',
        'status' => PurchaseStatus::class,
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
