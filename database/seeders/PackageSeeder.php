<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run()
    {
        // Truncate with foreign key checks disabled to avoid FK constraint errors
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('packages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Package::create([
            'name' => 'Basic',
            'description' => 'Basic plan for new users',
            'price' => 0,
            'duration_days' => 30,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'Pro',
            'description' => 'Pro plan with extra features',
            'price' => 49.99,
            'duration_days' => 365,
            'is_active' => true,
        ]);
    }
}
