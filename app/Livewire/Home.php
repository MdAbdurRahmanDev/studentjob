<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;

class Home extends Component
{
    public function render()
    {
        $categories = \App\Models\Category::withCount('jobs')->get();
        
        $shifts = Job::where('status', 'OPEN')->latest()->take(6)->get();

        $ads = \App\Models\Ad::where('is_active', true)->latest()->get();

        return view('livewire.home', compact('shifts', 'categories', 'ads'))->layout('components.layouts.front');
    }
}
