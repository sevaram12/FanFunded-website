<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'straight_bets', 'parlay_bets', 'total_collect'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
