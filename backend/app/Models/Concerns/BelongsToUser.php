<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUser
{
    protected static function bootBelongsToUser(): void
    {
        static::creating(function (Model $model): void {
            if (empty($model->user_id) && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });

        static::addGlobalScope('user', function (Builder $builder): void {
            if (auth()->check()) {
                $builder->where($builder->qualifyColumn('user_id'), auth()->id());
            }
        });
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where($query->qualifyColumn('user_id'), $userId);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
