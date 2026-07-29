<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('User Search')]

class UserProfileSearch extends Component
{
    public string $query = '';
    public ?User $user = null;
    public string $activeTab = 'overview';

    public function mount(): void
    {
        $q = request('q', '');
        if ($q) {
            $this->query = $q;
            $this->searchUser();
        }
    }

    public function searchUser(): void
    {
        if (blank($this->query)) {
            $this->user = null;
            return;
        }

        $this->user = User::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->orWhere('id', is_numeric($this->query) ? $this->query : null)
            ->first();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $applications = [];
        $subscriptions = [];

        if ($this->user) {
            $applications = $this->user->applications()
                ->with('job')
                ->latest()
                ->get();

            $subscriptions = $this->user->subscriptions()
                ->latest()
                ->get();
        }

        return view('livewire.admin.user-profile-search', [
            'applications' => $applications,
            'subscriptions' => $subscriptions,
        ]);
    }
}
