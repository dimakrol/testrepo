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

        $ip = RegistrationService::getIp();

        $user = User::create([
            'email' => $providerUser->getEmail(),
            'first_name' => $providerUser->getName(),
            'facebook_id' => $providerUser->getId(),
            'country_code' => geoip()->getLocation($ip)->iso_code
        ]);

        if (session()->has('new-user.generated-videos')) {
            RegistrationService::attachVideoIds($user, session()->pull('new-user.generated-videos')) ;
        }

        session(['completeRegistration' => true]);
        return $user;
    }
}