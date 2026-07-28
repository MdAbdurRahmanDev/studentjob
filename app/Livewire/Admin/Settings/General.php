<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class General extends Component
{
    use WithFileUploads;

    public $site_name = '';
    public $site_logo;
    public $site_favicon;

    public $footer_copyright = '';
    public $footer_text = '';
    public $whatsapp_number = '';

    public $existing_logo = '';
    public $existing_favicon = '';

    public function mount()
    {
        $this->site_name = Setting::get('site_name', config('app.name', 'StudentJob'));
        $this->existing_logo = Setting::get('site_logo', '');
        $this->existing_favicon = Setting::get('site_favicon', '');
        $this->footer_copyright = Setting::get('footer_copyright', '© ' . date('Y') . ' ' . config('app.name', 'StudentJob') . '. সর্বস্বত্ব সংরক্ষিত।');
        $this->footer_text = Setting::get('footer_text', 'শিক্ষার্থীদের জন্য, শিক্ষার্থীদের দ্বারা তৈরি। (অ্যাডমিনের জন্য লোগোতে ৫x ট্যাপ করুন)');
        $this->whatsapp_number = Setting::get('whatsapp_number', '');
    }

    public function saveSettings()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:1024|mimes:ico,png,jpg,svg',
            'footer_copyright' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:255',
        ]);

        Setting::set('site_name', $this->site_name);
        Setting::set('footer_copyright', $this->footer_copyright);
        Setting::set('footer_text', $this->footer_text);
        Setting::set('whatsapp_number', $this->whatsapp_number);

        if ($this->site_logo) {
            if ($this->existing_logo) {
                Storage::disk('public')->delete($this->existing_logo);
            }
            $logoPath = $this->site_logo->store('settings', 'public');
            Setting::set('site_logo', $logoPath);
            $this->existing_logo = $logoPath;
            $this->site_logo = null;
        }

        if ($this->site_favicon) {
            if ($this->existing_favicon) {
                Storage::disk('public')->delete($this->existing_favicon);
            }
            $faviconPath = $this->site_favicon->store('settings', 'public');
            Setting::set('site_favicon', $faviconPath);
            $this->existing_favicon = $faviconPath;
            $this->site_favicon = null;
        }

        session()->flash('success', 'Settings updated successfully.');
        
        $this->dispatch('settings-updated');
    }

    public function render()
    {
        return view('livewire.admin.settings.general')
            ->layout('layouts.app', ['title' => __('General Settings')]);
    }
}
