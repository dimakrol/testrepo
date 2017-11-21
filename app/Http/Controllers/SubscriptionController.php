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

        $plan = Plan::default();
        if (!$plan) {
            Log::error('Default plan does not exists');
            return back();
        }

        if (StripePaymentService::createCustomerWithSubscription(
            $request->input('stripeToken'),
            Auth::user(),
            $plan
        )) {
            flash('Success! Welcome to Words Won\'t Do!')->success();
            return redirect('/');
        }
        return back();
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

    public function paypalSuccess()
    {
        flash('Success! Welcome to Words Won\'t Do!')->success();
        return view('subscription.paypal_success');
    }
}
