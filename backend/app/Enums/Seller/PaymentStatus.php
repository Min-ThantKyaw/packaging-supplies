<?php

namespace App\Enums\Seller;

enum PaymentStatus: string
{
    case Unpaid = 'unpaid';
    case PendingSettlement = 'pending_settlement';
    case Partial = 'partial';
    case Paid = 'paid';
}
