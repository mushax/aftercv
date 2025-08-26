<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\File; // Important: Add this line

class WorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // A more robust way: read the JSON data file.
        $jsonPathEN = base_path('vendor/stefangabos/world_countries/data/countries/en/world.json');
        $jsonPathAR = base_path('vendor/stefangabos/world_countries/data/countries/ar/world.json');

        if (!File::exists($jsonPathEN) || !File::exists($jsonPathAR)) {
            $this->command->error('Country JSON data files not found. Please ensure the stefangabos/world_countries package is installed correctly.');
            return;
        }

        $allCountriesEN = json_decode(File::get($jsonPathEN), true);
        $allCountriesAR = json_decode(File::get($jsonPathAR), true);

        foreach ($allCountriesEN as $countryData) {
            // Check if essential keys exist to avoid errors
            if (!isset($countryData['name']) || !isset($countryData['alpha2'])) {
                continue;
            }

            $alpha2 = strtolower($countryData['alpha2']);

            Country::create([
                'name' => [
                    'en' => $countryData['name'],
                    'ar' => $allCountriesAR[$alpha2]['name'] ?? $countryData['name'] // Fallback to English name
                ],
                'iso_code' => $alpha2, // THE FIX IS HERE
                'country_code' => $countryData['dialing_code'] ?? '',
                'flag_emoji' => $countryData['emoji'] ?? '',
            ]);
        }
        
        // Manually seed cities for key countries after all countries are created
        $this->seedCities();
    }

    private function seedCities(): void
    {
        $syria = Country::where('iso_code', 'sy')->first();
        if ($syria) {
            $syria->cities()->createMany([
                ['name' => ['en' => 'Damascus', 'ar' => 'دمشق']],
                ['name' => ['en' => 'Aleppo', 'ar' => 'حلب']],
                ['name' => ['en' => 'Homs', 'ar' => 'حمص']],
            ]);
        }

        $uae = Country::where('iso_code', 'ae')->first();
        if ($uae) {
            $uae->cities()->createMany([
                ['name' => ['en' => 'Dubai', 'ar' => 'دبي']],
                ['name' => ['en' => 'Abu Dhabi', 'ar' => 'أبوظبي']],
            ]);
        }
    }
}
