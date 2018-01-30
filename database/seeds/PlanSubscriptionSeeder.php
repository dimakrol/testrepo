<?php

use App\Models\Plan;
use App\Services\Payment\StripePaymentService;
use Illuminate\Database\Seeder;

class PlanSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Plan::where('stripe_id', 'yearly')->first()) {
             $plan = Plan::create([
                "amount" => 999,
                "interval" => "year",
                "name" => "yearly",
                "currency" => Plan::CURRENCY,
                "stripe_id" => Plan::STRIPE_ID
            ]);

//            StripePaymentService::createPlan($plan);
        }
    }
}
