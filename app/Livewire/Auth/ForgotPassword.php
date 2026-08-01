<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\SmsService;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.front', ['title' => 'পাসওয়ার্ড ভুলে গেছেন?', 'seoDescription' => 'পাসওয়ার্ড রিকভার করুন।'])]
class ForgotPassword extends Component
{
    public $step = 1;

    // Step 1: Phone
    public $phone = '';

    // Step 2: OTP
    public $otp = '';
    public $otp_sent = false;

    // Step 3: New Password
    public $password = '';
    public $password_confirmation = '';

    protected function messages()
    {
        return [
            'phone.required' => 'ফোন নম্বর দেওয়া আবশ্যক।',
            'phone.exists' => 'এই ফোন নম্বর দিয়ে কোনো ইউজার একাউন্ট নেই।',
            'otp.required' => 'OTP কোড দেওয়া আবশ্যক।',
            'otp.digits' => 'OTP কোড ৪ ডিজিটের হতে হবে।',
            'password.required' => 'নতুন পাসওয়ার্ড দেওয়া আবশ্যক।',
            'password.min' => 'পাসওয়ার্ড অন্তত ৮ ক্যারেক্টার হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড ম্যাচ করেনি।',
        ];
    }

    public function sendOtp(SmsService $smsService)
    {
        $this->validate([
            'phone' => ['required', 'string', 'exists:users,phone'],
        ]);

        $user = User::where('phone', $this->phone)->where('role', 'user')->first();

        if (!$user) {
            $this->addError('phone', 'এই ফোন নম্বর দিয়ে কোনো ইউজার একাউন্ট নেই।');
            return;
        }

        // Generate OTP
        $otpCode = rand(1000, 9999);
        
        session([
            'password_reset_otp' => $otpCode,
            'password_reset_phone' => $this->phone,
            'password_reset_expires_at' => now()->addMinutes(5),
        ]);

        // Send SMS
        $messageTemplate = \App\Models\Setting::get('sms_password_reset_text', 'Your password reset code is: {otp}');
        $message = str_replace('{otp}', $otpCode, $messageTemplate);
        
        try {
            $smsService->sendSms($this->phone, $message);
            $this->otp_sent = true;
            $this->step = 2;
        } catch (\Exception $e) {
            $this->addError('phone', 'SMS পাঠাতে সমস্যা হচ্ছে। দয়া করে আবার চেষ্টা করুন।');
        }
    }

    public function verifyOtp()
    {
        $this->validate([
            'otp' => ['required', 'numeric', 'digits:4'],
        ]);

        if (!session()->has('password_reset_otp') || now()->greaterThan(session('password_reset_expires_at'))) {
            $this->addError('otp', 'OTP এর মেয়াদ শেষ হয়ে গেছে। আবার চেষ্টা করুন।');
            return;
        }

        if ((int) $this->otp !== (int) session('password_reset_otp')) {
            $this->addError('otp', 'ভুল OTP কোড।');
            return;
        }

        // OTP verified
        $this->step = 3;
    }

    public function changePassword()
    {
        if ($this->step !== 3 || !session()->has('password_reset_phone')) {
            return;
        }

        $this->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('phone', session('password_reset_phone'))->first();

        if ($user) {
            $user->password = Hash::make($this->password);
            $user->save();
        }

        // Clear session
        session()->forget(['password_reset_otp', 'password_reset_phone', 'password_reset_expires_at']);

        // Redirect to login
        session()->flash('success', 'আপনার পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
