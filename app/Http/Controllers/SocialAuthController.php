<?php

namespace App\Http\Controllers;

use App\Models\Plan;
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
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());

        auth()->login($user);

//        flash('Message login user TO DO need to change')->success();
        if (!$user->subscribed(Plan::default()->stripe_id)) {
            return redirect(route('subscription.index'));
        }
        return redirect('/home');
    }
}
