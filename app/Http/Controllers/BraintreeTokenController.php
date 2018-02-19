<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Auth;
use Illuminate\Http\Request;
use Braintree_ClientToken;
use App\Mail\Subscribe;
use Mail;

class BraintreeTokenController extends Controller
{
    public function index()
    {
//        $braintreePlans = Braintree_Plan::all();
//        dd($braintreePlans);
        return view('b');
    }

    public function token()
    {
        return response()->json([
            'data' => [
                'token' => Braintree_ClientToken::generate(),
            ]
        ]);
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'payment_nonce' => 'required',
            'plan' => 'required'
        ]);
        $plan = Plan::whereName($request->get('plan'))->first();
//        //todo need to change stripe_id to braintree_id
//        //stripe_id old field name
        if ($request->user()
            ->newSubscription($plan->stripe_id, $plan->stripe_id)
            ->create($request->get('payment_nonce'))) {

            Mail::to(Auth::user()->email)
                ->send(new Subscribe([
                    'name' => Auth::user()->first_name,
                ]));
            flash('Success! Welcome to Words Won\'t Do!')->success();
            session(['subscription' => ['value' => $plan->amountInCurrency(), 'currency' => $plan->currency]]);
            return redirect('/');

        }
    }
}
