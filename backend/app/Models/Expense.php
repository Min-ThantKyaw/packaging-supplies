<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'expense_category_id',
        'expense_date',
        'amount',
        'note',
        'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
