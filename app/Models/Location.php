<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department',
        'location',
    ];

    protected $table = 'location_lists';

    public function task()
    {
        return $this->hasMany(Tasks::class, 'location_id', 'id');
    }
}
