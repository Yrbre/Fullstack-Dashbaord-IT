<?php

namespace App\Models;

use App\Models\Tasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
    ];
    protected $table = 'category_lists';

    public function task()
    {
        return $this->hasMany(Tasks::class, 'category_id', 'id');
    }
}
