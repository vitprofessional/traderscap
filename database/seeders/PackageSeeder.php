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
            'description' => 'Ideal for new investors entering the forex market',
            'facilities' => [
                'Beginner-friendly account setup guidance',
                'Managed forex market exposure',
                'Weekly performance updates',
                'Email support',
            ],
            'price' => 0,
            'duration_type' => 'daily',
            'duration_value' => 30,
            'duration_days' => 30,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'Premium',
            'description' => 'Balanced growth with enhanced risk control',
            'facilities' => [
                'Advanced portfolio management',
                'Enhanced risk control strategy',
                'Priority support access',
                'Detailed performance reporting',
                'Dedicated account oversight',
            ],
            'price' => 25000,
            'duration_type' => 'yearly',
            'duration_value' => 1,
            'duration_days' => 365,
            'is_active' => true,
            'is_recommended' => true,
        ]);
    }
}
