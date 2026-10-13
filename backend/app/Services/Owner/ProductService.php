<?php

namespace App\Services\Owner;

use App\Models\Product;

class ProductService
{
    public function store(array $data, int $userId): Product
    {
        $product = Product::create([
            ...$data,
            'user_id' => $userId,
        ]);

        return $product->load('category');
    }
}
