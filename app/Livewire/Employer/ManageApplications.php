<?php

namespace App\Livewire\Employer;

use Livewire\Component;
use App\Models\Job;
use App\Models\Application;

class ManageApplications extends Component
{
    public $shift;

    public function mount(Job $shift)
    {
        // Ensure the shift belongs to the logged-in user
        if ($shift->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $this->shift = $shift;
    }

    public $earningsAmount;
    public $completingApplicationId = null;

    public function hire($applicationId)
    {
        $application = Application::findOrFail($applicationId);
        
        if ($application->job_id === $this->shift->id) {
            $application->update(['status' => 'hired']);
            session()->flash('success', 'Student has been hired!');
        }
    }

    public function reject($applicationId)
    {
        $application = Application::findOrFail($applicationId);
        
        if ($application->job_id === $this->shift->id) {
            $application->update(['status' => 'rejected']);
            session()->flash('success', 'Application rejected.');
        }
    }

    public function startCompleting($applicationId)
    {
        $this->completingApplicationId = $applicationId;
        $this->earningsAmount = '';
    }

    public function cancelCompleting()
    {
        $this->completingApplicationId = null;
        $this->earningsAmount = '';
    }

    public function markCompleted()
    {
        $this->validate(['earningsAmount' => 'required|numeric|min:0']);
        
        $application = Application::findOrFail($this->completingApplicationId);
        if ($application->job_id === $this->shift->id) {
            $application->update([
                'status' => 'completed',
                'earnings' => $this->earningsAmount
            ]);
            session()->flash('success', 'Student marked as completed and earnings added.');
        }
        
        $this->cancelCompleting();
    }

    public function markAbsent($applicationId)
    {
        $application = Application::findOrFail($applicationId);
        
        if ($application->job_id === $this->shift->id) {
            $application->update(['status' => 'absent']);
            session()->flash('success', 'Student marked as absent.');
        }
    }

    public function render()
    {
        // Fetch applications with the user details
        $applications = Application::with('user')
            ->where('job_id', $this->shift->id)
            ->latest()
            ->get();

        return view('livewire.employer.manage-applications', [
            'applications' => $applications
        ])->layout('components.layouts.front', ['title' => 'Manage Applications']);
    }
}
