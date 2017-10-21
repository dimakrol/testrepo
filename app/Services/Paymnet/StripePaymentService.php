<?php
/**
 * Created by PhpStorm.
 * User: dimak
 * Date: 20.10.17
 * Time: 14:41
 */

namespace App\Services\Payment;


use Stripe\{Customer, Plan, Stripe};
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

    /**
     * @param $stripeEmail
     * @param $stripeToken
     * @param EloquentPlan $plan
     * @return Customer
     */
    public static function createCustomerWithSubscription($stripeEmail, $stripeToken, EloquentPlan $plan)
    {
        static::setKey();

        return Customer::create([
            'email' => $stripeEmail,
            'source' => $stripeToken,
            'plan' => $plan->stripe_id
        ]);
    }



    /**
     * Set stripe key
     */
    public static function setKey()
    {
        Stripe::setApiKey(static::getStripeKey());
    }
}