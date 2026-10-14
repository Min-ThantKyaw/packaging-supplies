<?php

namespace App\Enums\Seller;

enum PurchaseStatus: string
{
    case Received = 'received';
    case Void = 'void';
}
