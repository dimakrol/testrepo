<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayPalWebhooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('web', ['except' => ['aaa']]);
    }
    
    public function aaa()
    {
        Log::debug('post paypal');
    }
}
