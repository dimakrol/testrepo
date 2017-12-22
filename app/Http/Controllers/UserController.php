<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Socialite;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscription = \Auth::user()->subscriptions()->first();
        return view('account.index', compact('subscription'));
    }

    public function addFacebook()
    {
        config(['services.facebook.redirect' => route('connect-facebook')]);
        return Socialite::driver('facebook')->redirect();
    }

    public function connectFacebook()
    {
        config(['services.facebook.redirect' => route('connect-facebook')]);
        \Auth::user()->facebook_id = Socialite::driver('facebook')->user()->getId();
        \Auth::user()->save();
        flash('Facebook connected successfully!!!')->success();

        return redirect(route('account'));
    }

    public function disconnectFacebook($id)
    {
        $user = User::findOrFail($id);
        $user->update(['facebook_id' => null]);
        flash('Facebook disconnected successfully!!!')->success();

        return redirect(route('account'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        flash('Account information updated successfully!')->success();
        return redirect(route('account'));
    }
}
