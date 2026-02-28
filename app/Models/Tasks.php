<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tasks extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'relation_task',
        'name',
        'priority',
        'category_id',
        'assign_to',
        'task_level',
        'enduser_id',
        'status',
        'progress',
        'delivered',
        'location_id',
        'in_timeline',
        'schedule_start',
        'schedule_end',
        'actual_start',
        'actual_end',
        'description',
    ];
    protected $table = 'tasks';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function enduser()
    {
        return $this->belongsTo(EndUser::class, 'enduser_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Tasks::class, 'relation_task');
    }

    public function children()
    {
        return $this->hasMany(Tasks::class, 'relation_task');
    }
}
