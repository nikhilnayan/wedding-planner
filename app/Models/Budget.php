<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wedding_id',
        'total_budget',  // total allocated budget for the wedding
        'amount_spent',  // total amount spent so far
        'remaining_budget', // remaining budget
    ];

    /**
     * A budget belongs to a wedding.
     */
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    /**
     * Budget has many categories.
     */
    public function budgetCategories()
    {
        return $this->hasMany(BudgetCategory::class);
    }
}
