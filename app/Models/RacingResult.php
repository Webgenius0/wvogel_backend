<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RacingResult extends Model
{

    protected $fillable = [
        'racing_result_start',
        'racing_result_win',
        'racing_result_place',
        'racing_result_show',
        'racing_result_win_percentage',
        'racing_result_wps_percentage',
        'racing_result_purses_percentage',
        'racing_result_earning_percentage',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}

