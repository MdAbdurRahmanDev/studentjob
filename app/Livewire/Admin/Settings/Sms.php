<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;

class Sms extends Component
{
    public $sms_customer_id = '';
    public $sms_api_key = '';
    public $sms_verification_text = '';
    public $sms_password_reset_text = '';

    public function mount()
    {
        $this->sms_customer_id = Setting::get('sms_customer_id', env('SMS_CUSTOMER_ID', ''));
        $this->sms_api_key = Setting::get('sms_api_key', env('SMS_API_KEY', ''));
        $this->sms_verification_text = Setting::get('sms_verification_text', 'Your account verification code is: {otp}');
        $this->sms_password_reset_text = Setting::get('sms_password_reset_text', 'Your password reset code is: {otp}');
    }

    public function saveSettings()
    {
        $this->validate([
            'sms_customer_id' => 'required|string|max:255',
            'sms_api_key' => 'required|string|max:255',
            'sms_verification_text' => 'required|string|max:500',
            'sms_password_reset_text' => 'required|string|max:500',
        ]);

        Setting::set('sms_customer_id', $this->sms_customer_id);
        Setting::set('sms_api_key', $this->sms_api_key);
        Setting::set('sms_verification_text', $this->sms_verification_text);
        Setting::set('sms_password_reset_text', $this->sms_password_reset_text);

        session()->flash('success', 'SMS Settings updated successfully.');
        
        $this->dispatch('settings-updated');
    }

    public function render()
    {
        return view('livewire.admin.settings.sms')
            ->layout('layouts.app', ['title' => __('SMS Settings')]);
    }
}
