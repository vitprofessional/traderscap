<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TestimonialSeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\AdminSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed testimonials
        $this->call(TestimonialSeeder::class);
        // Seed packages
        $this->call(PackageSeeder::class);
        // Seed default admin
        $this->call(AdminSeeder::class);
        // Seed countries
        $this->call(CountrySeeder::class);
    }
}
