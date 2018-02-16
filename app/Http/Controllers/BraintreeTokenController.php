<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree_ClientToken;
use Braintree_Plan;

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
//        dd($request->all());
        $request->user()->newSubscription('primary', 'yearly')->create($request->get('payment_nonce'));
    }
}
