<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialAccountService;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialAccountService $service)
    {
        try {
            $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
            $user->last_signin = Carbon::now();
            $user->save();
            auth()->login($user);
        } catch (\Exception $e) {
            flash('You need to accept FB request')->error();
            return redirect('/home');
        }

        if (!$user->subscribed(Plan::default()->stripe_id)) {
            return redirect('/home');
        }
        return redirect('/home');
    }
}
