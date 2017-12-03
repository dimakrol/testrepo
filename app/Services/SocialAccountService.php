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

        $user = User::create([
            'email' => $providerUser->getEmail(),
            'first_name' => $providerUser->getName(),
            'facebook_id' => $providerUser->getId(),
        ]);

        session(['completeRegistration' => true]);

        return $user;
    }
}