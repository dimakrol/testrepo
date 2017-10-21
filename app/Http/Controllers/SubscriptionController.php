<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\Payment\StripePaymentService;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plan = Plan::where('name', 'yearly')->first();

        return view('subscription', compact('plan'));
//        $plan = Plan::where('name', 'yearly')->first();
//        return StripePaymentService::getPlan($plan->name);
    }

    public function store(Request $request)
    {
        $plan = Plan::default();
        try {
            $customer = StripePaymentService::createCustomerWithSubscription(
                $request->input('stripeEmail'),
                $request->input('stripeToken'),
                $plan
            );
        } catch (Exception $e) {
            Log::error('Customer has not been created: ' . $e->getMessage());
            return response()->json([
                'status' => $e->getMessage()
            ], 422);
        }

        Log::debug($customer);
        $request->user()->activateStripeSubscription($customer);

        return response()->json(['message' => 'Subscription activated successfully'], 201);
    }
}
