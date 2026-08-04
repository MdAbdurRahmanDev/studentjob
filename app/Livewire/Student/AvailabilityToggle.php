<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AvailabilityToggle extends Component
{
    public $is_profile_visible;

    public function mount()
    {
        $this->is_profile_visible = Auth::user()->is_profile_visible ?? true;
    }

    public function updatedIsProfileVisible()
    {
        $user = Auth::user();
        $user->is_profile_visible = $this->is_profile_visible;
        $user->save();
        
        if ($this->is_profile_visible) {
            session()->flash('status', 'আপনার প্রোফাইল এখন পাবলিক করা হয়েছে। ক্লায়েন্টরা আপনাকে হায়ার করতে পারবে।');
        } else {
            session()->flash('status', 'আপনার প্রোফাইল হাইড করা হয়েছে। আপনাকে সার্চে দেখা যাবে না।');
        }
    }

    public function render()
    {
        return view('livewire.student.availability-toggle');
    }
}
