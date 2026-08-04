<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $title;
    public $bio;
    public $education;
    public $skills = [];
    public $availability;
    public $category_id;
    public $custom_category;
    public $is_profile_visible = true;
    public $profile_image;
    public $existing_profile_image;

    public function mount()
    {
        $user = auth()->user();
        $this->title = $user->title;
        $this->bio = $user->bio;
        $this->education = $user->education;
        $this->skills = $user->skills ?? [];
        $this->availability = $user->availability;
        $this->category_id = $user->category_id;
        $this->custom_category = $user->custom_category;
        $this->is_profile_visible = $user->is_profile_visible ?? true;
        $this->existing_profile_image = $user->profile_image;
    }

    public function updateProfile()
    {
        \Log::info('updateProfile called', [
            'title' => $this->title, 'category_id' => $this->category_id, 'custom_category' => $this->custom_category, 'bio' => $this->bio
        ]);
        $this->title = empty($this->title) ? null : $this->title;
        $this->bio = empty($this->bio) ? null : $this->bio;
        $this->education = empty($this->education) ? null : $this->education;
        $this->availability = empty($this->availability) ? null : $this->availability;
        $this->category_id = empty($this->category_id) ? null : $this->category_id;
        $this->custom_category = empty($this->custom_category) ? null : $this->custom_category;

        $this->validate([
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'education' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'custom_category' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'is_profile_visible' => 'boolean',
            'profile_image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        \Log::info('validation passed');

        $user = auth()->user();
        $imagePath = $this->existing_profile_image;

        if ($this->profile_image) {
            $imagePath = $this->profile_image->store('profile-images', 'uploads');
        }
        $user->update([
            'title' => $this->title,
            'bio' => $this->bio,
            'education' => $this->education,
            'skills' => $this->skills,
            'availability' => $this->availability,
            'category_id' => $this->category_id,
            'custom_category' => $this->custom_category,
            'is_profile_visible' => $this->is_profile_visible,
            'profile_image' => $imagePath,
        ]);

        session()->flash('success', 'আপনার প্রোফাইল সফলভাবে আপডেট করা হয়েছে!');
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.student.update-profile', compact('categories'))
               ->layout('components.layouts.front', ['title' => 'প্রোফাইল আপডেট করুন']);
    }
}
