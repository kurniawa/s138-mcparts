<?php

use App\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $site_settings = [
            ['setting' => 'load_num', 'value' => 0]
        ];
        for ($i = 0; $i < count($site_settings); $i++) {
            SiteSetting::create([
                'setting' => $site_settings[$i]['setting'],
                'value' => $site_settings[$i]['value'],
            ]);
        }
    }
}
