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
}