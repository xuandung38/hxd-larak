<?php

namespace Database\Seeders;

use App\Enums\RentStatus;
use App\Models\Donate;
use App\Models\Game;
use App\Models\Position;
use App\Models\Rent;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Str;

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
				'image' => '/images/user/user' . rand(1, 8) . '.jpg',
				'username' => uniqid()
			]);

			$user->save();
		}

	}
}
