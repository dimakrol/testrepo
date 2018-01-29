<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $users = User::all();
//
//        foreach ($users as $user) {
//            Storage::disk('local')->append('public/index.csv', $user->id.','.$user->first_name.','.$user->email.','.($user->subscriptions()->count() ? $user->subscriptions()->first()->created_at:'Not Subscribed') . ','.$user->created_at);
//        }

        $user = new User;
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('123123');
        $user->is_admin = true;
        $user->save();
    }
}
