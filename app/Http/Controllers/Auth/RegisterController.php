<?php

namespace App\Http\Controllers\Auth;

use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\VideoGenerated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/subscription';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (request('current_url')) {
            session(['current_url' => request('current_url')]);
        }
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            Log::debug('HTTP_X_FORWARDED_FOR: '.$_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
            Log::debug('No HTTP_X_FORWARDED_FOR new sing up user!');
        }

        $user = User::create([
            'first_name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'country_code' => geoip()->getLocation($ip)->iso_code
        ]);

        //todo refactoring
        if (session()->has('new-user.generated-videos')) {
            try {
                $generatedIds = session()->pull('new-user.generated-videos');
                VideoGenerated::whereIn('id', $generatedIds)
                    ->update(['user_id' => $user->id]);
            } catch (\Exception $e) {
                Log::error('Error while attaching generated videos to user: '.$user->id);
                Log::error(print_r($generatedIds, true));
            }
        }

        //todo refactoring
        try {
            Mail::to($user->email)
                ->send(new WelcomeEmail([
                    'name' => $user->first_name,
                ]));
        } catch (\Exception $e) {
            Log::error('Error while sending message to user with id: '.$user->id);
        }

        session(['completeRegistration' => true]);
        return $user;

     }

    protected function registered(Request $request, $user)
    {
        $path = route('subscription.index');

        if ($current_url = session('current_url')) {
            $path = $current_url;
            session()->forget('current_url');
        }

        return response()->json(['path' => $path]);
    }
}
