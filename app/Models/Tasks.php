<?php

namespace App\Models;

use Carbon\Carbon;
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
        'task_load',
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

    protected $casts = [
        'schedule_start' => 'datetime',
        'schedule_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
        'in_timeline' => 'boolean',
    ];

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

    public function deliveredUser()
    {
        return $this->belongsTo(User::class, 'delivered', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Tasks::class, 'relation_task');
    }

    public function children()
    {
        return $this->hasMany(Tasks::class, 'relation_task');
    }

    public function task_user()
    {
        return $this->belongsToMany(User::class, 'task_user')
            ->withPivot('taken')
            ->withTimestamps();
    }

    public function getDiffTimeAttribute()
    {
        if ($this->schedule_end && $this->actual_end) {
            $scheduleEnd = Carbon::parse($this->schedule_end);
            $actualEnd = Carbon::parse($this->actual_end);

            $diffInMinutes = $scheduleEnd->diffInMinutes($actualEnd, false);
            $days = floor(abs($diffInMinutes) / 1440);
            $hours = floor(abs($diffInMinutes) / 60);
            $minutes = abs($diffInMinutes) % 60;

            if ($diffInMinutes < 0) {
                return "-{$days}d {$hours}h {$minutes}m";
            }

            return "+{$days}d {$hours}h {$minutes}m";
        }
        return null;
    }
}
