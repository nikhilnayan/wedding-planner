<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wedding_id',
        'name',
        'allocated_amount',
        'budgeted_amount', // total amount allocated for this category
        'description',     // any description or additional info
    ];

    /**
     * A budget category belongs to a wedding.
     */
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    /**
     * A budget category has many budget items.
     */
    public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class);
    }
}
