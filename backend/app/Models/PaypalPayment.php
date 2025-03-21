<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'currency',
        'paypal_payment_id',
        'user_id',
        'minimum_picks',
        'minimum_picks_amount',
        'maximum_picks_amount',
        'maximum_loss',
        'maximum_daily_loss',
        'profit_target',
        'time_limit',
        'phase',
        'account_size',
        'challenge_fees',
        'your_balance',
        'start_date',
        'end_date',
        'challenge_status',
    ];
}
