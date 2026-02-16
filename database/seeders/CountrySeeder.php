<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $countries = [
            ['name' => 'United States', 'iso2' => 'US', 'iso3' => 'USA', 'code' => 'US', 'phone_code' => '+1', 'is_active' => true],
            ['name' => 'United Kingdom', 'iso2' => 'GB', 'iso3' => 'GBR', 'code' => 'GB', 'phone_code' => '+44', 'is_active' => true],
            ['name' => 'Canada', 'iso2' => 'CA', 'iso3' => 'CAN', 'code' => 'CA', 'phone_code' => '+1', 'is_active' => true],
            ['name' => 'Australia', 'iso2' => 'AU', 'iso3' => 'AUS', 'code' => 'AU', 'phone_code' => '+61', 'is_active' => true],
            ['name' => 'India', 'iso2' => 'IN', 'iso3' => 'IND', 'code' => 'IN', 'phone_code' => '+91', 'is_active' => true],
        ];

        foreach ($countries as $data) {
            Country::updateOrCreate(
                ['iso2' => $data['iso2']],
                $data
            );
        }
    }
}
