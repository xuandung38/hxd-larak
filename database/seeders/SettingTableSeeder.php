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
        $settings = [
            [
                'key' => 'logo',
                'value' => '/images/logo.png',
            ],
            [
                'key' => 'name',
                'value' => 'Project Name',
            ],
            [
                'key' => 'address',
                'value' => 'Address',
            ],
            [
                'key' => 'phone',
                'value' => '0436xxxxxx',
            ],
            [
                'key' => 'hotline',
                'value' => '09xxxxxxxx',
            ],
            [
                'key' => 'email',
                'value' => 'contact@example.com',
            ],
            [
                'key' => 'color',
                'value' => '#000',
            ],
            [
                'key' => 'title',
                'value' => 'Project Name',
            ],
            [
                'key' => 'keyword',
                'value' => 'k,e,y,w,o,r,k',
            ],
            [
                'key' => 'description',
                'value' => 'Project Name',
            ],
            [
                'key' => 'thumbnail',
                'value' => '/images/logo.png',
            ],
            [
                'key' => 'gg_analytic_id',
                'value' => null,
            ],
            [
                'key' => 'slider',
                'value' => '[{"link": null, "image": "/storage/files/anonymous/0We7ZmVjHXNTSOPGZYrCxtL7m6DzCs1b02fz3w4Q.jpg"}]',
            ],
            [
                'key' => 'facebook',
                'value' => null,
            ],
            [
                'key' => 'twitter',
                'value' => null,
            ],
            [
                'key' => 'youtube',
                'value' => null,
            ],
            [
                'key' => 'telegram',
                'value' => null,
            ],

            [
                'key' => 'notification',
                'value' => null,
            ],

        ];

        Setting::insert($settings);
    }
}
