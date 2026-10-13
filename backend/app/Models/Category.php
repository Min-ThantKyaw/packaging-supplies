<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
