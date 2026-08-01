<?php

namespace App\Livewire\Admin\Ads;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ad;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $link = '';
    public $tag = 'Featured Ad';
    public $image;
    public $is_active = true;
    
    public $edit_id;
    public $edit_title = '';
    public $edit_description = '';
    public $edit_link = '';
    public $edit_tag = '';
    public $edit_image;
    public $existing_image;
    public $edit_is_active = true;

    public $isEditing = false;

    public function saveAd()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:50',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $this->image->store('ads', 'uploads');

        Ad::create([
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
            'tag' => $this->tag,
            'image' => $imagePath,
            'is_active' => $this->is_active,
        ]);

        $this->reset(['title', 'description', 'link', 'tag', 'image', 'is_active']);
        session()->flash('success', 'Ad created successfully.');
    }

    public function edit($id)
    {
        $ad = Ad::findOrFail($id);
        $this->edit_id = $ad->id;
        $this->edit_title = $ad->title;
        $this->edit_description = $ad->description;
        $this->edit_link = $ad->link;
        $this->edit_tag = $ad->tag;
        $this->edit_is_active = $ad->is_active;
        $this->existing_image = $ad->image;
        $this->isEditing = true;
    }

    public function cancelEdit()
    {
        $this->reset(['edit_id', 'edit_title', 'edit_description', 'edit_link', 'edit_tag', 'edit_is_active', 'edit_image', 'existing_image', 'isEditing']);
    }

    public function updateAd()
    {
        $this->validate([
            'edit_title' => 'required|string|max:255',
            'edit_description' => 'nullable|string',
            'edit_link' => 'nullable|string|max:255',
            'edit_tag' => 'nullable|string|max:50',
            'edit_image' => 'nullable|image|max:2048',
        ]);

        $ad = Ad::findOrFail($this->edit_id);
        
        $data = [
            'title' => $this->edit_title,
            'description' => $this->edit_description,
            'link' => $this->edit_link,
            'tag' => $this->edit_tag,
            'is_active' => $this->edit_is_active,
        ];

        if ($this->edit_image) {
            if ($ad->image) {
                Storage::disk('uploads')->delete($ad->image);
            }
            $data['image'] = $this->edit_image->store('ads', 'uploads');
        }

        $ad->update($data);

        $this->cancelEdit();
        session()->flash('success', 'Ad updated successfully.');
    }

    public function toggleStatus($id)
    {
        $ad = Ad::findOrFail($id);
        $ad->update(['is_active' => !$ad->is_active]);
    }

    public function delete($id)
    {
        $ad = Ad::findOrFail($id);
        if ($ad->image) {
            Storage::disk('uploads')->delete($ad->image);
        }
        $ad->delete();
        session()->flash('success', 'Ad deleted successfully.');
    }

    public function render()
    {
        $ads = Ad::latest()->get();
        return view('livewire.admin.ads.index', compact('ads'))
            ->layout('layouts.app', ['title' => __('Manage Ads')]);
    }
}
