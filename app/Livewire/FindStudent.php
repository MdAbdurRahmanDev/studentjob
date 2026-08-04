<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Category;

class FindStudent extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id = '';
    public $selectedSkills = [];
    public $availability = [];
    public $sort = 'newest';

    protected $queryString = [
        'search' => ['except' => ''],
        'category_id' => ['except' => ''],
        'selectedSkills' => ['except' => []],
        'availability' => ['except' => []],
        'sort' => ['except' => 'newest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingSelectedSkills()
    {
        $this->resetPage();
    }

    public function updatingAvailability()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'category_id', 'selectedSkills', 'availability', 'sort']);
        $this->resetPage();
    }

    public function render()
    {
        $query = User::where('role', 'user')->where('is_profile_visible', true);

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('title', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->category_id)) {
            $query->where('category_id', $this->category_id);
        }

        if (!empty($this->selectedSkills)) {
            $query->where(function($q) {
                foreach ($this->selectedSkills as $skill) {
                    $q->orWhereJsonContains('skills', $skill);
                }
            });
        }

        if (!empty($this->availability)) {
            $query->whereIn('availability', $this->availability);
        }

        if ($this->sort === 'newest') {
            $query->latest();
        } else {
            $query->orderBy('name', 'asc');
        }

        $students = $query->paginate(12);
        $categories = Category::all();

        return view('livewire.find-student', compact('students', 'categories'))
               ->layout('components.layouts.front', ['title' => 'শিক্ষার্থী খুঁজুন']);
    }
}
