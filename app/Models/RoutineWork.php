<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoutineWork extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'duration',
        'description',
    ];
    protected $table = 'routine_work';
}
