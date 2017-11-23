<?php

namespace App\Http\Controllers;

use App\Mail\Subscribe;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Fahim\PaypalIPN\PaypalIPNListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PayPalWebhooksController extends Controller
{
    
    public function processPayment(Request $request)
    {
        $ipn = new PaypalIPNListener();

        try {
            $verified = $ipn->processIpn();

            $report = $ipn->getTextReport();

            Log::info("-----new payment-----");

            Log::info($report);

            if ($verified) {
                if ($request->address_status == 'confirmed') {
                    // Check outh POST variable and insert your logic here
                    Log::info('User: ' . json_decode($request->custom)->user_id);

                    if (!$subscription = Subscription::where('stripe_id', $request->subscr_id)
                        ->where('billing_type', 'paypal')->first()) {
                        $user = User::find(json_decode($request->custom)->user_id);
                        $subscription = new Subscription([
                            'name' => $request->item_name,
                            'billing_type' => 'paypal',
                            'stripe_id' => $request->subscr_id,
                            'stripe_plan' => $request->item_name,
                            'quantity' => $request->mc_gross * 100,
                            'next_payment' => Carbon::now()->addYear(),
                        ]);
                        $user->subscriptions()->save($subscription);

                        Mail::to($user->email)
                            ->send(new Subscribe([
                                'name' => $user->first_name,
                            ]));
                    }

                    Log::info("payment verified and inserted to db");
                }
            } else {
                Log::info("Some thing went wrong in the payment !");
            }
        } catch (\Exception $e) {
            Log::info("Error while processing payment: ". $e->getTraceAsString());
        }
    }
}
