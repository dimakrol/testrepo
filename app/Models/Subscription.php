<?php

namespace App\Models;

use Carbon\Carbon;
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

    /**
     * @param \Stripe\Subscription $subscription
     */
    public function cancelWithPeriod(\Stripe\Subscription $subscription)
    {
        $this->next_payment = null;
        $this->ends_at = Carbon::createFromTimestamp($subscription->current_period_end);
        $this->save();
    }
}
