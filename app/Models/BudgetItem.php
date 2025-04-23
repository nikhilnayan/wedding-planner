<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'budget_category_id',
        'name',
        'amount',
        'estimated_cost',
        'actual_cost',
        'budget_category_id',
        'status',  // e.g., "paid", "pending", etc.
        'notes',    // additional notes about the budget item
    ];

    /**
     * A budget item belongs to a budget category.
     */
    public function budgetCategory()
    {
        return $this->belongsTo(BudgetCategory::class);
    }
}
