<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin([
            'name' => 'System Admin',
            'username' => 'sysadmin',
            'phone' => '0981964698',
            'email' => 'system@example.com',
            'image' => '/images/avatar.jpg',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);
        $admin->save();
        $adminRole = Role::whereGuard('admin')->whereLevel(1)->first();
        $admin->roles()->sync($adminRole);

        $admin = new Admin([
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '0989614698',
            'email' => 'admin@example.com',
            'image' => '/images/avatar.jpg',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);
        $admin->save();
        $adminRole = Role::whereGuard('admin')->whereLevel(5)->first();
        $admin->roles()->sync($adminRole);
    }
}
