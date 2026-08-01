<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $name = '';
    public $icon;
    
    public $edit_id;
    public $edit_name = '';
    public $edit_icon;
    public $existing_icon;

    public $isEditing = false;

    public function saveCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|image|max:1024',
        ]);

        $iconPath = $this->icon->store('categories', 'uploads');

        Category::create([
            'name' => $this->name,
            'icon' => $iconPath,
        ]);

        $this->reset(['name', 'icon']);
        session()->flash('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->edit_id = $category->id;
        $this->edit_name = $category->name;
        $this->existing_icon = $category->icon;
        $this->isEditing = true;
    }

    public function cancelEdit()
    {
        $this->reset(['edit_id', 'edit_name', 'edit_icon', 'existing_icon', 'isEditing']);
    }

    public function updateCategory()
    {
        $this->validate([
            'edit_name' => 'required|string|max:255',
            'edit_icon' => 'nullable|image|max:1024',
        ]);

        $category = Category::findOrFail($this->edit_id);
        
        $data = ['name' => $this->edit_name];

        if ($this->edit_icon) {
            if ($category->icon) {
                Storage::disk('uploads')->delete($category->icon);
            }
            $data['icon'] = $this->edit_icon->store('categories', 'uploads');
        }

        $category->update($data);

        $this->cancelEdit();
        session()->flash('success', 'Category updated successfully.');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->icon) {
            Storage::disk('uploads')->delete($category->icon);
        }
        $category->delete();
        session()->flash('success', 'Category deleted successfully.');
    }

    public function render()
    {
        $categories = Category::latest()->get();
        return view('livewire.admin.categories.index', compact('categories'))
            ->layout('layouts.app', ['title' => __('Manage Categories')]);
    }
}
