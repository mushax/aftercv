<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'name' => json_encode(['en' => 'Syria', 'ar' => 'سوريا']),
                'iso_code' => 'SY',
                'country_code' => '+963',
                'flag_emoji' => '🇸🇾',
            ],
            [
                'name' => json_encode(['en' => 'Saudi Arabia', 'ar' => 'المملكة العربية السعودية']),
                'iso_code' => 'SA',
                'country_code' => '+966',
                'flag_emoji' => '🇸🇦',
            ],
            [
                'name' => json_encode(['en' => 'United Arab Emirates', 'ar' => 'الإمارات العربية المتحدة']),
                'iso_code' => 'AE',
                'country_code' => '+971',
                'flag_emoji' => '🇦�',
            ],
            // Add more countries as needed
        ]);
    }
}