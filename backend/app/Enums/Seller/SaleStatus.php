<?php

namespace App\Enums\Seller;

enum SaleStatus: string
{
    case Completed = 'completed';
    case Void = 'void';
}
