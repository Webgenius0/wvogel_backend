<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'category_name',
        'category_description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
