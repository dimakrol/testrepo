<?php
/**
 * Created by PhpStorm.
 * User: dimak
 * Date: 02.03.18
 * Time: 18:36
 */

namespace App\Services;


use App\Models\User;
use App\Models\VideoGenerated;
use Log;

class RegistrationService
{
    /**
     * Attach created videos to user after registration
     * @param User $user
     * @param array $generatedIds
     */
    public static function attachVideoIds(User $user, $generatedIds)
    {
        try {
            VideoGenerated::whereIn('id', $generatedIds)
                ->update(['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Error while attaching generated videos to user: '.$user->id);
            Log::error(print_r($generatedIds, true));
        }
    }

    public static function getIp()
    {
        $ip = null;
        if (array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            Log::debug('HTTP_X_FORWARDED_FOR: '.$_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
            Log::debug('No HTTP_X_FORWARDED_FOR new sing up user!');
        }
        return  $ip;
    }
}