<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = User::factory()->make([
                'image' => '/images/user/user'.rand(1, 8).'.jpg',
                'username' => uniqid(),
            ]);

            $user->save();
        }
    }
}
