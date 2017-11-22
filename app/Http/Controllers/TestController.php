<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function aaa()
    {

        Mail::to('dmitriy.krol.v@gmail.com')->send(new TestEmail(['name' => 'jogn', 'email' => 'email@email', 'message' => 'mess']));
    }
}
