<?php

namespace App\Http\Controllers;

use Fahim\PaypalIPN\PaypalIPNListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayPalWebhooksController extends Controller
{
    
    public function aaa(Request $request)
    {
        $ipn = new PaypalIPNListener();
        $ipn->use_sandbox = true;

        $verified = $ipn->processIpn();

        $report = $ipn->getTextReport();

        Log::info("-----new payment-----");

        Log::info($report);

        if ($verified) {
            if ($request->address_status == 'confirmed') {
                // Check outh POST variable and insert your logic here
                Log::info('User: ' . json_decode($request->custom)->user_id);
                Log::info("payment verified and inserted to db");
            }
        } else {
            Log::info("Some thing went wrong in the payment !");
        }
    }
}
