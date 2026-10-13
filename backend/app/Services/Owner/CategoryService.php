<?php

namespace App\Services\Owner;

use App\Models\Category;

class CategoryService
{
    public function store(array $data, int $userId): Category
    {
        return Category::create([
            ...$data,
            'user_id' => $userId,
        ]);
    }
}
