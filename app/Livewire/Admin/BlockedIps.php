<?php

namespace App\Livewire\Admin;

use App\Models\BlockedIp;
use Livewire\Component;
use Livewire\WithPagination;

class BlockedIps extends Component
{
    use WithPagination;

    public function unblock($id)
    {
        $blockedIp = BlockedIp::find($id);
        if ($blockedIp) {
            $blockedIp->delete();
            session()->flash('success', 'IP address has been unblocked successfully.');
        }
    }

    public function render()
    {
        $blockedIps = BlockedIp::latest()->paginate(20);
        return view('livewire.admin.blocked-ips', compact('blockedIps'))
            ->layout('layouts.app', ['title' => __('Blocked IPs')]);
    }
}
