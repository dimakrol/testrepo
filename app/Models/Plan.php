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

    public function scopeDefault($query)
    {
        return $query->where('stripe_id', static::STRIPE_ID)->first();
    }

}
