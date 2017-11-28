<?php
/**
 * Created by PhpStorm.
 * User: dimak
 * Date: 20.10.17
 * Time: 14:41
 */

namespace App\Services\Payment;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Stripe\{
    Customer, Plan, Stripe, Subscription
};
use App\Models\Subscription as EloquentSubscription;
use App\Models\Plan as EloquentPlan;

class StripePaymentService
{
    /**
     * Get the Stripe API key.
     *
     * @return string
     */
    public static function getStripeKey()
    {
        if ($key = getenv('STRIPE_SECRET')) {
            return $key;
        }

        return config('services.stripe.secret');
    }

    /**
     * Get Stripe plan by name
     * @param $plan
     * @return Plan
     */
    public static function getPlan($plan)
    {
        static::setKey();
        return Plan::retrieve($plan);
    }

    /**
     * @param \App\Models\Plan $plan
     * @return Plan
     */
    public static function createPlan(EloquentPlan $plan)
    {
        static::setKey();

        return Plan::create([
                "amount" => $plan->amount,
                "interval" => $plan->interval,
                "name" => $plan->name,
                "currency" => $plan->currency,
                "id" => $plan->stripe_id
            ]);
    }

    public static function updatePlan(EloquentPlan $plan)
    {
        $stripePlan = StripePaymentService::getPlan($plan->stripe_id);
        $stripePlan->delete();
        try {
            StripePaymentService::createPlan($plan);
            return true;
        } catch (\Exception $e) {
            Log::error('Error while updating subscription: '.$e->getMessage());
            return false;
        }
    }

    public static function createCustomerWithSubscription($stripeToken, User $user, EloquentPlan $plan)
    {
        static::setKey();

        try {
            $stripeCustomer = Customer::create([
                'source' => $stripeToken,
                'email' => $user->email,
                'plan' => $plan->stripe_id
            ]);

            $user->update(['stripe_customer_id' => $stripeCustomer->id]);

            if (self::activateStripeSubscription($user, $stripeCustomer)) {
                return true;
            }
        } catch (\Exception $e) {
            Log::error('Error while creating subscription: '.$e->getMessage());
            return false;
        }
    }


    public static function cancelSubscription(EloquentSubscription $subscription)
    {
        static::setKey();

        $stripeSubscription = Subscription::retrieve($subscription->stripe_id);
        $canceledSubscription = $stripeSubscription->cancel(['at_period_end' => true]);

        $subscription->cancelWithPeriod($canceledSubscription);
    }

    private static function activateStripeSubscription(User $eloquentUser, Customer $customer)
    {
        if (count($customer->subscriptions->data)) {
            $subscription = null;
            foreach ($customer->subscriptions->data as $subscription) {
                $subscription = new EloquentSubscription([
                    'name' => $subscription->plan->name,
                    'billing_type' => 'stripe',
                    'stripe_id' => $subscription->id,
                    'stripe_plan' => $subscription->plan->id,
                    'quantity' => $subscription->plan->amount,
                    'next_payment' => Carbon::createFromTimestamp($subscription->current_period_end)
                ]);
            }
            if ($subscription) {
                if ($eloquentUser->subscriptions()->save($subscription)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Set stripe key
     */
    public static function setKey()
    {
        Stripe::setApiKey(static::getStripeKey());
    }
}