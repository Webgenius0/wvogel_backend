<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class onboard extends Model
{
 protected $fillable = [
        'user_id',
        'most_share_race_horse',
        'roi',
        'horse_racing_risk_ownership',
        'investment_opportunities',
        'investment_venture',
        'investment_venture_book',
        'racing_potiential_profit',
        'passive_investment',
        'younger_experience',
        'race_entery_fees',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $hidden = [
        // 'user_id',
        'created_at',
        'updated_at',
    ];
}
