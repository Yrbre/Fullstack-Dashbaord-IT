<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tasks;
use App\Models\Activity;

class ActivityHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'reference_id',
        'reference_type',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'reference_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'reference_id');
    }
}
