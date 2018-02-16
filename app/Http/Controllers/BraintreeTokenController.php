<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree_ClientToken;

class BraintreeTokenController extends Controller
{
    public function index()
    {
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
        $request->user()->newSubscription('yearly', 'yearly')->create($request->get('payment_nonce'));
    }
}
