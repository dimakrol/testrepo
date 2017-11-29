<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    const CURRENCY = 'usd';
    const STRIPE_ID = 'yearly';
    const STRIPE_ID_UK = 'yearlyuk';

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

    public static function getByUser(User $user)
    {
        if ($user->country_code != 'GB') {
            return static::default();
        }
        return static::where('stripe_id', static::STRIPE_ID_UK)->first();
    }

    public function amountInCurrency()
    {
        return number_format(($this->amount / 100), 2, '.', ' ');
    }
}
