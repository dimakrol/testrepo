<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\Payment\StripePaymentService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscription');
//        $plan = Plan::where('name', 'yearly')->first();
//        return StripePaymentService::getPlan($plan->name);
    }

    public function store(Request $request)
    {
        return $request->all();
    }
}
