<?php

namespace App\Models;

use App\Enums\DeliveryStatus;
use App\Enums\PaymentStatus;
use App\Enums\SaleStatus;
use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'sale_number',
        'customer_id',
        'payment_method_id',
        'sale_channel_id',
        'delivery_service_id',
        'tracking_number',
        'delivery_status',
        'status',
        'subtotal',
        'discount',
        'total',
        'paid_amount',
        'payment_status',
        'settled_at',
        'delivered_at',
        'note',
    ];

    protected $casts = [
        'delivery_status' => DeliveryStatus::class,
        'status' => SaleStatus::class,
        'payment_status' => PaymentStatus::class,
        'settled_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function saleChannel(): BelongsTo
    {
        return $this->belongsTo(SaleChannel::class);
    }

    public function deliveryService(): BelongsTo
    {
        return $this->belongsTo(DeliveryService::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
