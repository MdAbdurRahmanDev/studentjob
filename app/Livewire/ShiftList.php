<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;
use Livewire\WithPagination;

class ShiftList extends Component
{
    use WithPagination;

    public $location = '';
    public $title = '';

    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Job::where('status', 'OPEN');

        if (!empty($this->location)) {
            $query->where('location', 'like', '%' . $this->location . '%');
        }

        if (!empty($this->title)) {
            $query->where('title', 'like', '%' . $this->title . '%');
        }

        $shifts = $query->latest()->paginate(9);

        $locations = Job::select('location')->distinct()->pluck('location');
        $titles = Job::select('title')->distinct()->pluck('title');

        return view('livewire.shift-list', compact('shifts', 'locations', 'titles'))->layout('components.layouts.front');
    }
}
