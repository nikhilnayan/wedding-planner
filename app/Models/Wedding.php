<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'partner1_name',       // Add partner1_name
        'partner2_name',       // Add partner2_name
        'wedding_date',        // Add wedding_date
        'venue',               // Add venue
        'venue_address',       // Add venue_address
        'guest_count',         // Add guest_count
        'budget_total',        // Add budget_total
        'notes',               // Add notes
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'wedding_date' => 'date',
    ];

    /**
     * A wedding belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A wedding has many guests.
     */
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    /**
     * A wedding has many vendors.
     */
    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    /**
     * A wedding has many budget categories.
     */
    public function budgetCategories()
    {
        return $this->hasMany(BudgetCategory::class);
    }

    /**
     * A wedding has many timelines.
     */
    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    /**
     * A wedding has many gift registries.
     */
    public function giftRegistries()
    {
        return $this->hasMany(GiftRegistry::class);
    }
}
