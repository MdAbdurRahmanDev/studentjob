<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\RateLimiter;
use App\Models\BlockedIp;
use Illuminate\Http\Request;

class AdminLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login(Request $request)
    {
        $ip = $request->ip();

        if (BlockedIp::where('ip_address', $ip)->exists()) {
            $this->addError('email', 'আপনার IP ঠিকানা ব্লক করা হয়েছে। আনলক করতে অনুগ্রহ করে অন্য অ্যাডমিনের সাথে যোগাযোগ করুন।');
            return;
        }

        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $key = 'admin-login-' . $ip;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('email', 'অনেকবার চেষ্টা করা হয়েছে। একটু পরে আবার চেষ্টা করুন।');
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password, 'role' => 'admin'], $this->remember)) {
            RateLimiter::clear($key);
            session()->regenerate();
            return redirect()->intended('/admin/dashboard'); 
        }

        RateLimiter::hit($key);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            BlockedIp::create(['ip_address' => $ip]);
            RateLimiter::clear($key);
            $this->addError('email', 'আপনি ৩ বার ভুল পাসওয়ার্ড দিয়েছেন। আপনার IP ঠিকানা ব্লক করা হয়েছে।');
            return;
        }

        $attemptsLeft = 3 - RateLimiter::attempts($key);
        $this->addError('email', "সঠিক তথ্য দিন। আর {$attemptsLeft} বার ভুল করলে IP ব্লক হয়ে যাবে।");
    }

    public function render()
    {
        return view('livewire.admin-login')->layout('components.layouts.front');
    }
}
