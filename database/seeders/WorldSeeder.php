<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class WorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // The correct way: include the PHP array file directly from the package.
        $countriesPath = base_path('vendor/stefangabos/world_countries/data/countries/en/countries.php');

        if (!file_exists($countriesPath)) {
            $this->command->error('Country data file not found. Please ensure the stefangabos/world_countries package is installed correctly.');
            return;
        }

        $allCountriesEN = require $countriesPath;
        $allCountriesAR = require base_path('vendor/stefangabos/world_countries/data/countries/ar/countries.php');

        foreach ($allCountriesEN as $countryData) {
            // Check if essential keys exist to avoid errors
            if (!isset($countryData['alpha2']) || !isset($countryData['name'])) {
                continue;
            }

            $country = Country::create([
                'name' => [
                    'en' => $countryData['name'],
                    'ar' => $allCountriesAR[$countryData['alpha2']]['name'] ?? $countryData['name'] // Fallback to English name
                ],
                'iso_code' => strtolower($countryData['alpha2']),
                'country_code' => $countryData['dialing_code'] ?? '',
                'flag_emoji' => $countryData['emoji'] ?? '',
            ]);

            // For now, we will manually seed some cities for key countries
            if ($country->iso_code === 'sy') {
                $country->cities()->createMany([
                    ['name' => ['en' => 'Damascus', 'ar' => 'دمشق']],
                    ['name' => ['en' => 'Aleppo', 'ar' => 'حلب']],
                    ['name' => ['en' => 'Homs', 'ar' => 'حمص']],
                ]);
            }

            if ($country->iso_code === 'ae') {
                $country->cities()->createMany([
                    ['name' => ['en' => 'Dubai', 'ar' => 'دبي']],
                    ['name' => ['en' => 'Abu Dhabi', 'ar' => 'أبوظبي']],
                ]);
            }
        }
    }
}
