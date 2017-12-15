<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Plan
 *
 * @property int $id
 * @property string $stripe_id
 * @property string $name
 * @property string $currency
 * @property int $amount
 * @property string $interval
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan default()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $dot
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereDot($value)
 */
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

    /**
     * @return string
     */
    public function amountInCurrency()
    {
        if (!$this->dot) {
            return ceil($this->amount/100/12);
        }
        return number_format(($this->amount / 100 / 12), 1, '.', ' ');
    }
}
