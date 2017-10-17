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
        $user = new User;
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('123123');
        $user->is_admin = true;
        $user->save();
    }
}
