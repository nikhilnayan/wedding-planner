<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gift_registry_id',
        'name',
        'description',
        'price',
        'status', // e.g., "purchased", "pending", etc.
    ];

    /**
     * A gift item belongs to a gift registry.
     */
    public function giftRegistry()
    {
        return $this->belongsTo(GiftRegistry::class);
    }
}
