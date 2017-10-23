<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * @param Customer $customer
     * @return bool
     */
    public function activateStripeSubscription(Customer $customer)
    {
        if (count($customer->subscriptions->data)) {
            $this->stripe_customer_id = $customer->id;

            foreach ($customer->subscriptions->data as $subscription) {
                $subscription = new Subscription([
                    'name' => $subscription->plan->name,
                    'billing_type' => 'stripe',
                    'stripe_id' => $subscription->id,
                    'stripe_plan' => $subscription->plan->id,
                    'quantity' => $subscription->plan->amount,
                    'next_payment' => Carbon::createFromTimestamp($subscription->current_period_end)
                ]);
            }
            return Auth::user()->subscriptions()->save($subscription);
        }

        return false;
    }

    public function cancelStripeSubscription(Customer $customer)
    {

    }
}
