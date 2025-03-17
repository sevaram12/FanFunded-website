<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betting extends Model
{
    use HasFactory;

    protected $fillable = [
        'bet_id', 'sport_key', 'sport_title', 'commence_time',
        'home_team', 'away_team', 'bookmaker_key', 'bookmaker_title',
        'type', 'team', 'pick', 'to_win', 'bet_type', 'total_collect', 'user_id' , 'price' , 'sport'
    ];
}
