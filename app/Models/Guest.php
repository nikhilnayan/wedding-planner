<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
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
        'email',
        'phone',
        'attendance_status',
        'party_size',
        'rsvp_status',  // could be "going", "not going", etc.
        'notes',  // any special instructions, allergies, etc.
    ];

    /**
     * A guest belongs to a wedding.
     */
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}
