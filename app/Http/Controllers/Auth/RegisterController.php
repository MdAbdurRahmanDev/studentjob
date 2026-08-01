<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Handle the registration form submission.
     */
    public function register(Request $request, SmsService $smsService)
    {
        // Fortify's CreateNewUser action has the validation rules
        $creator = new CreateNewUser();
        
        // We will validate manually to intercept before creation
        $input = $request->all();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);

        // Generate OTP
        $otp = rand(1000, 9999);
        
        // Store user data and OTP in session
        session([
            'register.data' => [
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'password' => $input['password'],
                'password_confirmation' => $input['password_confirmation'],
            ],
            'register.otp' => $otp,
            'register.otp_expires_at' => now()->addMinutes(5),
        ]);

        // Send SMS
        $messageTemplate = \App\Models\Setting::get('sms_verification_text', 'Your account verification code is: {otp}');
        $message = str_replace('{otp}', $otp, $messageTemplate);
        $smsService->sendSms($input['phone'], $message);

        return redirect()->route('register.verify');
    }

    /**
     * Show the registration OTP verification view.
     */
    public function showVerifyOtp()
    {
        if (!session()->has('register.otp')) {
            return redirect()->route('register');
        }

        return view('auth.register-verify-otp');
    }

    /**
     * Verify the OTP and create the user account.
     */
    public function verifyOtp(Request $request, CreateNewUser $creator)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:4',
        ]);

        if (!session()->has('register.otp') || now()->greaterThan(session('register.otp_expires_at'))) {
            session()->forget(['register.data', 'register.otp', 'register.otp_expires_at']);
            return redirect()->route('register')->withErrors(['phone' => 'OTP has expired. Please register again.']);
        }

        if ((int) $request->input('otp') !== (int) session('register.otp')) {
            throw ValidationException::withMessages([
                'otp' => 'The provided OTP is incorrect.',
            ]);
        }

        // OTP is valid, create the user
        $userData = session('register.data');
        
        // We use Fortify's creator to actually create the user
        $user = $creator->create($userData);

        Auth::login($user);
        $request->session()->regenerate();

        // Clear session data
        session()->forget(['register.data', 'register.otp', 'register.otp_expires_at']);

        return redirect()->intended(config('fortify.home', '/dashboard'));
    }
}
