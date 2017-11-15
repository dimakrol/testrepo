<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MigrationController extends Controller
{
    public function index()
    {
        $user = DB::connection('mysql_old')->table('users')->get();
        dd($user);
        //        if ($user->subscription_id) {
//            dd('works');
//        }

    }
}
