<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;

class MigrationController extends Controller
{
    public function index()
    {
        $users = DB::connection('mysql_old')->table('users')->get();
        foreach ($users as $old_user) {
            $new_user = new User;
            $new_user->first_name = $old_user->forename.' '.$old_user->surname;
            $new_user->email = $old_user->email;
            $new_user->password = bcrypt(str_random(10));
            $new_user->facebook_id = $old_user->fb_id;
            $new_user->stripe_customer_id = $old_user->stripe_customer_id ?: null;
            $new_user->country_code = $old_user->country_code;
            $new_user->save();

            if ($old_user->subscription_id) {
                $new_user->subscriptions()->create([
                    'name' => 'yearly',
                    'billing_type' => 'stripe',
                    'stripe_id' => $old_user->subscription_id,
                    'stripe_plan' => 'yearly',
                    'quantity' => 999
                ]);
            } else if ($old_user->payment_date) {
                $new_user->subscriptions()->create([
                    'name' => 'yearly',
                    'billing_type' => 'paypal',
                    'stripe_id' => 'paypal',
                    'stripe_plan' => 'yearly',
                    'quantity' => 999
                ]);
            }

            $cards = DB::connection('mysql_old')->table('user_card_details_tbl')->where('userID', $old_user->user_id)->get();
            foreach ($cards as $card) {
                $new_user->cards()->create([
                    'card_id' => $card->cardID,
                    'last4' => $card->last4,
                    'expiryDate' => $card->expiryDate,
                    'is_default' => $card->is_default,
                ]);
            }
        }
    }
}
