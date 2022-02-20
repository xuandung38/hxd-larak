<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach (Permissions::asArray() as $permission => $key) {
			$existPermission = Permission::where('key', $key)->first();
			if (!$existPermission) {
				$existPermission = new Permission([
					'key' => $key,
					'name' => __('enum.permissions.' . strtolower($permission)),
				]);
			} else {
				$existPermission->name = __('enum.permissions.' . strtolower($permission));
			}

			$existPermission->save();

		}

	}
}
