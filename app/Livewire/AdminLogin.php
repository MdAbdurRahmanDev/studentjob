<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password, 'role' => 'admin'], $this->remember)) {
            session()->regenerate();
            return redirect()->intended('/admin/dashboard'); 
        }

        $this->addError('email', 'The provided credentials do not match our records or you are not an admin.');
    }

    public function render()
    {
        return view('livewire.admin-login')->layout('components.layouts.front');
    }
}
