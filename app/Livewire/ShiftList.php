<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;
use Livewire\WithPagination;

class ShiftList extends Component
{
    use WithPagination;

    #[\Livewire\Attributes\Url]
    public $category = '';

    #[\Livewire\Attributes\Url]
    public $location = '';

    #[\Livewire\Attributes\Url]
    public $search = '';

    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Job::where('status', 'OPEN');

        if (!empty($this->category)) {
            $query->where('category_id', $this->category);
        }

        if (!empty($this->location)) {
            $query->where('location', 'like', '%' . $this->location . '%');
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('employer_name', 'like', '%' . $this->search . '%');
            });
        }

        $shifts = $query->latest()->paginate(9);

        $locations = Job::select('location')->distinct()->pluck('location');
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('livewire.shift-list', compact('shifts', 'locations', 'categories'))->layout('components.layouts.front');
    }
}
