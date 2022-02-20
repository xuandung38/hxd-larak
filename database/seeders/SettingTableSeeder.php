<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$setting = new Setting([
			'logo' => '/images/logo.png',
			'name' => 'HXD Larak',
			'address' => 'Hà Nội, Việt Nam',
			'phone' => '0436xxxxxx',
			'hotline' => '09xxxxxxxx',
			'email' => 'contact@example.com',
			'color' => '#000',
			'title' => 'HXD Larak',
			'keyword' => 'HXD Larak',
			'description' => 'HXD Larak',
			'thumbnail' => '/images/logo.png',
		]);
		$setting->save();
	}
}
