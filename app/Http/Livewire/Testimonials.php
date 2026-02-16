<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Testimonial;

class Testimonials extends Component
{
    public function render()
    {
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('livewire.testimonials', compact('testimonials'));
    }
}
