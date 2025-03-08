<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horses extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'about_horse',
        'horse_image',
        'racing_start',
        'racing_win',
        'racing_place',
        'racing_show',
        'breed',
        'gender',
        'age',
        'trainer',
        'owner',
        'color',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function horseShareForSale(){
        return $this->hasMany(HorseShareForSale::class);
    }
}
