<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Livewire\Component;
use App\Services\SmsService;

class EmployerRegister extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    
    public int $step = 1;
    public string $otp = '';
    public $generatedOtp = null;
    public $otp_expires_at = null;

    public function register(SmsService $smsService)
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class.',phone'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $this->generatedOtp = rand(1000, 9999);
        $this->otp_expires_at = now()->addMinutes(5);

        // Send SMS
        $messageTemplate = \App\Models\Setting::get('sms_company_verification_text', 'Your company account verification code is: {otp}');
        $message = str_replace('{otp}', $this->generatedOtp, $messageTemplate);
        
        $smsService->sendSms($this->phone, $message);

        $this->step = 2;
    }

    public function verifyOtp()
    {
        $this->validate([
            'otp' => 'required|numeric|digits:4',
        ]);

        if (now()->greaterThan($this->otp_expires_at)) {
            $this->addError('otp', 'OTP has expired. Please register again.');
            $this->step = 1;
            return;
        }

        if ((int) $this->otp !== (int) $this->generatedOtp) {
            $this->addError('otp', 'The provided OTP is incorrect.');
            return;
        }

        // OTP is valid, create the user
        $user = User::forceCreate([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'role' => 'company',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.employer-register')->layout('components.layouts.front');
    }
}
