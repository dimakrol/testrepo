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
//        $users = User::whereRaw('LENGTH(first_name) > 31')->get();
//
//
//        foreach ($users as $user) {
//            list($name) = explode('@',$users[0]->email);
//
//            $user->first_name = $name;
//            if ($user->save()) {
//                Storage::disk('local')->append('public/index.csv', $user->id.','.$user->email);
//            }
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
