<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinChampion extends Model
{
    use HasFactory;

    protected $fillable = [
        'champion_title', 'champion_image', 'champion_date'
    ];
}
