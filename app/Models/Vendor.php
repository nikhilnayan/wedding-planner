<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'contact_person',
        'phone',
        'email',
        'website',
        'cost',
        'deposit_amount',
        'deposit_due_date',
        'payment_due_date',
        'is_booked',
        'is_paid',
        'notes'
    ];

    /**
     * A vendor belongs to a wedding.
     */
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}
