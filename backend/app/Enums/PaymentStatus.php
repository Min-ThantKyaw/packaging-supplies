<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Unpaid = 'unpaid';
    case PendingSettlement = 'pending_settlement';
    case Partial = 'partial';
    case Paid = 'paid';
}
