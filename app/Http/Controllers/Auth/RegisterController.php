<?php

namespace App\Http\Controllers\Auth;

use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Notifications\SignedUp;
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
//        Log::debug('Server '.$_SERVER['REMOTE_ADDR']);
//        if (array_key_exists('X-Forwarded-For',$_SERVER)) {
//            Log::debug('Debug X-Forwarded-For Dima: '.$_SERVER['X-Forwarded-For']);
//        } else {
//            Log::debug('No Debug X-Forwarded-For xxx');
//        }

        if (array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER)) {
            Log::debug('HTTP_X_FORWARDED_FOR: '.$_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            Log::debug('No HTTP_X_FORWARDED_FOR new sing up user!');
        }

//        if ( function_exists( 'apache_request_headers' ) ) {
//            Log::debug('Apache header exists: ');
//            $headers = apache_request_headers();
//        } else {
//            $headers = $_SERVER;
//        }
//
//
//        if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
//            $the_ip = $headers['X-Forwarded-For'];
//            Log::debug('Apache X-Forwarded-For '.$the_ip);
//
//        } elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )) {
//            $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
//            Log::debug('Apache HTTP_X_FORWARDED_FOR '.$the_ip);
//        } else {
//            Log::debug('No Apache header!!!');
//            $the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
//            Log::debug('ip: '.$the_ip);
//        }


        $user = User::create([
            'first_name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'country_code' => geoip()->getLocation($_SERVER['HTTP_X_FORWARDED_FOR'])->iso_code
        ]);
        try {
            Mail::to($user->email)
                ->send(new WelcomeEmail([
                    'name' => $user->first_name,
                ]));
        } catch (\Exception $e) {
            Log::error('');
        }
        return $user;

     }

    protected function registered(Request $request, $user)
    {
        return response()->json('success');
    }
}
