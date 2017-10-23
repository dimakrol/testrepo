<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    protected $fillable = [
        'name',
        'billing_type',
        'stripe_id',
        'stripe_plan',
        'quantity',
        'trial_ends_at',
        'ends_at',
        'next_payment'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
