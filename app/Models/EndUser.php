<?php

namespace App\Models;

use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EndUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'department',
        'created_by',
    ];

    protected $table = 'endusers';

    public function task()
    {
        return $this->hasMany(Task::class, 'enduser_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
