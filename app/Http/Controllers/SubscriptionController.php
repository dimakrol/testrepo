<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Services\Payment\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plan = Plan::where('name', 'yearly')->first();

        return view('subscription', compact('plan'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'stripeToken' => 'required'
        ]);

        dd($request->all());
        $plan = Plan::default();
        if (!$plan) {
            return response()->json(['message' => 'Error while creating subscription!'], 422);
        }
        try {
            $customer = StripePaymentService::createCustomerWithSubscription(
                $request->input('stripeEmail'),
                $request->input('stripeToken'),
                $plan
            );
        } catch (\Exception $e) {
            Log::error('Customer with subscription has not been created: ' . $e->getMessage());
            return response()->json([
                'status' => $e->getMessage()
            ], 422);
        }

        $request->user()->activateStripeSubscription($customer);

        return response()->json(['message' => 'Subscription activated successfully'], 201);
    }

    public function cancel()
    {
        try {
            $subscription = Auth::user()->subscriptions()->first();
            StripePaymentService::cancelSubscription($subscription);
        } catch (\Exception $e) {
            Log::error('Subscription has not been canceled: ' . $e->getMessage());
            return response()->json([
                'status' => $e->getMessage()
            ], 422);
        }

        return response()->json(['message' => 'Your subscription has been canceled!!!'], 201);
    }
}
