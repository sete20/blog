<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            $user = User::create([
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => $i . 'a@a.com',
                'password' => bcrypt('123456789')
            ]);
            $user->attachRole('superadministrator');
        }
    }
}
