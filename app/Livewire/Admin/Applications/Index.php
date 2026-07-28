<?php

namespace App\Livewire\Admin\Applications;

use App\Models\Application;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Application::with(['user', 'job']);

        if ($this->search) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })->orWhereHas('job', function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('employer_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $applications = $query->latest()->paginate(15);

        return view('livewire.admin.applications.index', [
            'applications' => $applications
        ])->layout('layouts.app', ['title' => 'Job Applications Tracking']);
    }
}
