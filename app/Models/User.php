<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password','last_name',
        'gender','facebook_id','ip_address','date_of_birth',
        'payment_date','stripe_customer_id','last_signin',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function activateStripeSubscription(Customer $customer)
    {
        $this->billing_type = 'stripe';
        $this->stripe_customer_id = $customer->id;
        $this->active_subscription = true;

        foreach ($customer->subscriptions->data as $subscription) {
            $this->stripe_subscription_id = $subscription->id;
            $this->subscription_end_at = Carbon::createFromTimestamp($subscription->current_period_end);
            $this->payment_date = Carbon::createFromTimestamp($subscription->current_period_start);
            $this->save();
        }
    }
}
