<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayPalWebhooksController extends Controller
{
    
    public function aaa(Request $request)
    {
        Log::debug($request->all());
    }
}
