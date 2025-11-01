<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            'bakery_name' => 'Cuevas Bakery',
            'bakery_address' => '',
            'bakery_phone' => '',
            'bakery_email' => '',
            'operating_hours' => 'Mon-Sun: 6AM - 8PM',
            'notify_low_stock' => '1',
            'low_stock_threshold' => '10',
            'notify_orders' => '1',
            'notify_production' => '1',
        ];

        foreach ($defaults as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
