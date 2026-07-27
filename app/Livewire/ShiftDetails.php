<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;

class ShiftDetails extends Component
{
    public Job $shift;
    public $showApplyForm = false;
    public $applicationMessage = '';
    public $applied = false;

    public function mount(Job $shift)
    {
        $this->shift = $shift;

        // Check if user has already applied
        if (auth()->check()) {
            $this->applied = \App\Models\Application::where('user_id', auth()->id())
                                ->where('job_id', $this->shift->id)
                                ->exists();
        }
    }

    public function openApplyForm()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->showApplyForm = true;
    }

    public function submitApplication()
    {
        $this->validate([
            'applicationMessage' => 'required|min:10',
        ]);

        \App\Models\Application::create([
            'user_id' => auth()->id(),
            'job_id' => $this->shift->id,
            'message' => $this->applicationMessage,
            'status' => 'pending'
        ]);

        $this->showApplyForm = false;
        $this->applied = true;
        
        session()->flash('success', 'আপনার আবেদন সফলভাবে জমা দেওয়া হয়েছে!');
    }

    public function render()
    {
        return view('livewire.shift-details')->layout('components.layouts.front');
    }
}
