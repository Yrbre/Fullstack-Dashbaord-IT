<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'absences';
    protected $fillable = [
        'user_id',
        'absent_at',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
