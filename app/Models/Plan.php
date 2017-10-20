<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    const CURRENCY = 'usd';
    const STRIPE_ID = 'yearly';

    protected $fillable = [
        'stripe_id',
        'name',
        'currency',
        'amount',
        'interval'
    ];
}
