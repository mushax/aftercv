<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountryCitySeeder extends Seeder
{
    public function run(): void
    {
        // CORRECTED: Pass a PHP array directly. The model's cast will handle JSON encoding.
        $syria = Country::create([
            'name' => ['en' => 'Syria', 'ar' => 'سوريا'],
            'iso_code' => 'SY', 'country_code' => '+963', 'flag_emoji' => '🇸🇾',
        ]);
        $syria->cities()->createMany([
            ['name' => ['en' => 'Damascus', 'ar' => 'دمشق']],
            ['name' => ['en' => 'Aleppo', 'ar' => 'حلب']],
            ['name' => ['en' => 'Homs', 'ar' => 'حمص']],
        ]);

        $uae = Country::create([
            'name' => ['en' => 'United Arab Emirates', 'ar' => 'الإمارات'],
            'iso_code' => 'AE', 'country_code' => '+971', 'flag_emoji' => '🇦🇪',
        ]);
        $uae->cities()->createMany([
            ['name' => ['en' => 'Dubai', 'ar' => 'دبي']],
            ['name' => ['en' => 'Abu Dhabi', 'ar' => 'أبوظبي']],
        ]);
    }
}
