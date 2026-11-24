<?php

namespace App\Enums;

/**
 * Why a stock movement was written. A movement is the only way variant stock
 * changes; `product_variants.stock` is a cached projection of these rows.
 */
enum StockMovementType: string
{
    case Opening = 'opening';
    case Sale = 'sale';
    case Purchase = 'purchase';
    case Adjustment = 'adjustment';

    public function label(): string
    {
        return match ($this) {
            self::Opening => 'Opening stock',
            self::Sale => 'Sale',
            self::Purchase => 'Purchase',
            self::Adjustment => 'Adjustment',
        };
    }

    /**
     * Opening and purchase movements always add stock. Adjustments carry their
     * own signed quantity, so they are neither inbound nor outbound by type.
     */
    public function isInbound(): bool
    {
        return $this === self::Opening || $this === self::Purchase;
    }

    public function isOutbound(): bool
    {
        return $this === self::Sale;
    }
}
