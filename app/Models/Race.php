<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $fillable = [
        'race_name',
        'date',
        'location',
        'price',
        'video',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
