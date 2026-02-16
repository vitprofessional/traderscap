<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        Testimonial::truncate();

        Testimonial::create([
            'name' => 'Alice Johnson',
            'company' => 'Acme Co',
            'position' => 'CEO',
            'message' => 'Great service and support!',
            'is_active' => true,
            'order' => 1,
        ]);

        Testimonial::create([
            'name' => 'Bob Smith',
            'company' => 'Beta Ltd',
            'position' => 'Marketing Lead',
            'message' => 'Highly recommend for speed and reliability.',
            'is_active' => true,
            'order' => 2,
        ]);
    }
}
