<?php
/**
 * Created by PhpStorm.
 * User: dimak
 * Date: 07.11.17
 * Time: 16:36
 */

namespace App\Services;

use App\Models\User;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Log;

class SocialAccountService
{
    /**
     * @param ProviderUser $providerUser
     * @return mixed
     */
    public function createOrGetUser(ProviderUser $providerUser)
    {
        if ($user = User::where('facebook_id', $providerUser->getId())->first()) {
            return $user;
        }

        if ($user = User::whereEmail($providerUser->getEmail())->first()) {
            $user->facebook_id = $providerUser->getId();
            $user->save();
            return $user;
        }

        //todo need to refactor it.
        if (array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            Log::debug('HTTP_X_FORWARDED_FOR: '.$_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
            Log::debug('No HTTP_X_FORWARDED_FOR new sing up user!');
        }

        $user = User::create([
            'email' => $providerUser->getEmail(),
            'first_name' => $providerUser->getName(),
            'facebook_id' => $providerUser->getId(),
            'country_code' => geoip()->getLocation($ip)->iso_code
        ]);

        session(['completeRegistration' => true]);

        return $user;
    }
}