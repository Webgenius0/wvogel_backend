<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorseShareForSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'horse_id',
        'category_id',
        'ownership_share',
        'sub_total_price',
        'total_price',
        'paypal_payment_id',
        'approval_url',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function horse()
    {
        return $this->belongsTo(Horses::class, 'horse_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected $hidden =[
        // 'user_id',
        // 'horse_id',
        'created_at',
        'updated_at',
    ];
}
