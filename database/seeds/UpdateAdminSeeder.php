<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UpdateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($user = User::find(1)) {
            $user->role = 'admin';
            $user->save();
        }
    }
}
