<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;

class ShiftDetails extends Component
{
    public Job $shift;

    public function mount(Job $shift)
    {
        $this->shift = $shift;
    }

    public function render()
    {
        return view('livewire.shift-details')->layout('components.layouts.front');
    }
}
