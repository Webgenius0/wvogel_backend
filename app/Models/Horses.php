<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horses extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
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
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function horseShareForSale(){
        return $this->hasMany(HorseShareForSale::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
