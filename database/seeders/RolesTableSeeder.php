<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$permissions = Permission::all()->pluck('id');
		$role = new Role([
			'name' => 'System Admin',
			'guard' => 'admin', // Guard name in config/auth.php
			'level' => 1,
		]);
		$role->save();
		$role->permissions()->sync($permissions);

		Role::create([
			'name' => 'Admin',
			'guard' => 'admin', // Guard name in config/auth.php
			'level' => 5,
		]);
		Role::create([
			'name' => 'Editor',
			'guard' => 'user',
			'level' => 5,
		]);
		Role::create([
			'name' => 'Player',
			'guard' => 'user',
			'level' => 5,
		]);
		Role::create([
			'name' => 'User',
			'guard' => 'user',
			'level' => 5,
		]);

	}
}
