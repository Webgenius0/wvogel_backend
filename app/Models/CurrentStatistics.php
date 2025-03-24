<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentStatistics extends Model
{
    protected $fillable = [
        'starts',
        'firsts',
        'seconds',
        'thirds',
        'earnings',

    ];
}
