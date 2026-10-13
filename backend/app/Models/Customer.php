<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'note',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
