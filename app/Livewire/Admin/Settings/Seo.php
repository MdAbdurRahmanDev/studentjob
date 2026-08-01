<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;

class Seo extends Component
{
    public $seo_title = '';
    public $seo_keywords = '';
    public $seo_description = '';

    public function mount()
    {
        $this->seo_title = Setting::get('seo_title', Setting::get('site_name', config('app.name', 'StudentJob')));
        $this->seo_keywords = Setting::get('seo_keywords', '');
        $this->seo_description = Setting::get('seo_description', '');
    }

    public function saveSettings()
    {
        $this->validate([
            'seo_title' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string',
            'seo_description' => 'nullable|string',
        ]);

        Setting::set('seo_title', $this->seo_title);
        Setting::set('seo_keywords', $this->seo_keywords);
        Setting::set('seo_description', $this->seo_description);

        session()->flash('success', 'SEO settings updated successfully.');

        $this->dispatch('settings-updated');
    }

    public function render()
    {
        return view('livewire.admin.settings.seo')
            ->layout('layouts.app', ['title' => __('SEO Settings')]);
    }
}
