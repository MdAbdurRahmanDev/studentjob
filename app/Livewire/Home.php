<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;

class Home extends Component
{
    public function render()
    {
        $shifts = Job::where('status', 'OPEN')->latest()->take(6)->get();
        return view('livewire.home', compact('shifts'))->layout('components.layouts.front');
    }
}
