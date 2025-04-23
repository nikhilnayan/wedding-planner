<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftRegistry extends Model
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
        'registry_name',
        'store_name',
        'description',
        'created_by', // If someone else is managing the registry
    ];

    /**
     * A gift registry belongs to a wedding.
     */
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    /**
     * A gift registry has many gift items.
     */
    public function giftItems()
    {
        return $this->hasMany(GiftItem::class);
    }
}
