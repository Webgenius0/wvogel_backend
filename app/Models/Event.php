<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'event_title',
        'event_description',
        'event_date',
        'event_location',
        'event_image'
    ];
    
 protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
