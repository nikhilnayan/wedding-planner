<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'timeline_id',
        'name',
        'title',
        'due_date',
        'status',
        'description',
    ];

    /**
     * A task belongs to a timeline.
     */
    public function timeline()
    {
        return $this->belongsTo(Timeline::class);
    }
}
