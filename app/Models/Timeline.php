<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
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
        'title',
        'date',
        'description',
    ];

    /**
     * A timeline belongs to a wedding.
     */
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    /**
     * A timeline has many tasks.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
