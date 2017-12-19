<?php

namespace App\Http\Controllers;

use App\Mail\Subscribe;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\Payment\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plan = Plan::getByUser(Auth::user());
        return view('subscription', compact('plan'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'stripeToken' => 'required'
        ]);

        $plan = Plan::getByUser(Auth::user());
        if (!$plan) {
            Log::error('Default plan does not exists');
            return back();
        }

        if (StripePaymentService::createCustomerWithSubscription(
            $request->input('stripeToken'),
            Auth::user(),
            $plan
        )) {
            Mail::to(Auth::user()->email)
                ->send(new Subscribe([
                    'name' => Auth::user()->first_name,
                ]));
            flash('Success! Welcome to Words Won\'t Do!')->success();
            session(['subscription' => ['value' => $plan->amountInCurrency(), 'currency' => $plan->currency]]);
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

    public function paypalSuccess(Request $request)
    {
        if (!$request->auth) {
            return redirect(route('home'));
        }

        $plan = Plan::default();
        flash('Success! Welcome to Words Won\'t Do!')->success();
        return view('subscription.paypal_success', compact('plan'));
    }

    public function paypalError(Request $request)
    {
        if (!$request->auth) {
            return redirect(route('home'));
        }
        flash('Error! Your subscription has not been activated!!!')->error();
        return view('subscription.paypal_error');
    }
}
