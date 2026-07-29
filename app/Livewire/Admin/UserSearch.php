<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserSearch extends Component
{
    public string $query = '';
    public ?User $selectedUser = null;
    public bool $showResults = false;

    public function updatedQuery(): void
    {
        $this->showResults = strlen($this->query) >= 1;
        $this->selectedUser = null;
    }

    public function selectUser(int $id): void
    {
        $this->selectedUser = User::find($id);
        $this->query = $this->selectedUser->name;
        $this->showResults = false;
    }

    public function clearSearch(): void
    {
        $this->query = '';
        $this->selectedUser = null;
        $this->showResults = false;
    }

    public function getResultsProperty()
    {
        if (strlen($this->query) < 1) {
            return collect();
        }

        return User::where(function ($q) {
            $q->where('name', 'like', '%' . $this->query . '%')
              ->orWhere('email', 'like', '%' . $this->query . '%')
              ->orWhere('id', $this->query);
        })->limit(6)->get();
    }

    public function render()
    {
        return view('livewire.admin.user-search', [
            'results' => $this->results,
        ]);
    }
}
