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
        
    ];
}
