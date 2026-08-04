<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\HireRequest;
use Illuminate\Support\Facades\Auth;

class StudentProfile extends Component
{
    public $student;
    
    // Hire Form Properties
    public $showHireModal = false;
    public $work_title = '';
    public $description = '';
    public $contact_number = '';

    public function mount($id)
    {
        $this->student = User::where('role', 'user')
                            ->where('is_profile_visible', true)
                            ->findOrFail($id);
    }

    public function openHireModal()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'), navigate: true);
        }
        
        $this->showHireModal = true;
    }

    public function closeHireModal()
    {
        $this->showHireModal = false;
        $this->reset(['work_title', 'description', 'contact_number']);
        $this->resetValidation();
    }

    public function submitHireRequest()
    {
        if (!Auth::check()) {
            return;
        }

        $this->validate([
            'work_title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'contact_number' => 'nullable|string|max:50',
        ]);

        HireRequest::create([
            'employer_id' => Auth::id(),
            'student_id' => $this->student->id,
            'work_title' => $this->work_title,
            'description' => $this->description,
            'contact_number' => $this->contact_number,
            'status' => 'pending',
        ]);

        session()->flash('success', 'আপনার হায়ার রিকোয়েস্ট সফলভাবে পাঠানো হয়েছে!');
        $this->closeHireModal();
    }

    public function render()
    {
        return view('livewire.student-profile')
            ->layout('components.layouts.front', [
                'title' => $this->student->name . ' - প্রোফাইল',
                'seoDescription' => $this->student->bio
            ]);
    }
}
