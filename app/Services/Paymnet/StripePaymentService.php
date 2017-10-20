<?php
/**
 * Created by PhpStorm.
 * User: dimak
 * Date: 20.10.17
 * Time: 14:41
 */

namespace App\Services\Payment;


use Stripe\Plan;
use Stripe\Stripe;

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
    public static function createPlan(\App\Models\Plan $plan)
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

    public static function setKey()
    {
        Stripe::setApiKey(static::getStripeKey());
    }
}