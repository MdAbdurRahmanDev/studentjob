<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostShift extends Component
{
    public string $title = '';
    public $category_id;
    public string $location = '';
    public $start_datetime;
    public $end_datetime;
    public string $wage = '';
    public string $description = '';
    public string $requirements = '';

    public function post()
    {
        abort_if(Auth::user()->role !== 'company', 403, 'Unauthorized. Only employers can post shifts.');
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'location' => ['required', 'string', 'max:255'],
            'start_datetime' => ['required', 'date'],
            'end_datetime' => ['required', 'date', 'after:start_datetime'],
            'wage' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['employer_name'] = Auth::user()->name;
        $validated['status'] = 'OPEN';

        Job::create($validated);

        session()->flash('success', 'আপনার শিফট সফলভাবে পোস্ট করা হয়েছে!');
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $categories = \App\Models\Category::all();
        return view('livewire.post-shift', compact('categories'))->layout('components.layouts.front');
    }
}
