<?php

namespace App\Enums;

enum PurchaseStatus: string
{
    case Received = 'received';
    case Void = 'void';
}
