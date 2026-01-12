<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'name', 'value' => 'CRM'],
            ['key' => 'phone', 'value' => '00000000'],
            ['key' => 'mail_host', 'value' => env('MAIL_HOST')],
            ['key' => 'mail_port', 'value' => env('MAIL_PORT')],
            ['key' => 'mail_username', 'value' => env('MAIL_USERNAME')],
            ['key' => 'mail_password', 'value' => env('MAIL_PASSWORD')],
            ['key' => 'mail_encryption', 'value' => env('MAIL_ENCRYPTION')],
            ['key' => 'logo', 'value' => ''],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
