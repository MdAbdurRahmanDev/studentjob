<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the custom login process.
     */
    public function login(Request $request, SmsService $smsService)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL) !== false;
        $field = $isEmail ? 'email' : 'phone';

        $user = User::where($field, $login)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        if (!$isEmail) {
            // Generate OTP
            $otp = rand(1000, 9999);
            
            // Store OTP in session
            session([
                'auth.otp' => $otp,
                'auth.user_id' => $user->id,
                'auth.remember' => $remember,
                'auth.otp_expires_at' => now()->addMinutes(5),
            ]);

            // Send SMS
            $messageTemplate = \App\Models\Setting::get('sms_verification_text', 'Your verification code is: {otp}');
            $message = str_replace('{otp}', $otp, $messageTemplate);
            $smsService->sendSms($user->phone, $message);

            return redirect()->route('login.verify');
        }

        // Standard Email Login bypasses OTP
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(config('fortify.home', '/dashboard'));
    }

    /**
     * Show the OTP verification view.
     */
    public function showVerifyOtp()
    {
        if (!session()->has('auth.otp')) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify the OTP and login the user.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:4',
        ]);

        if (!session()->has('auth.otp') || now()->greaterThan(session('auth.otp_expires_at'))) {
            session()->forget(['auth.otp', 'auth.user_id', 'auth.remember', 'auth.otp_expires_at']);
            return redirect()->route('login')->withErrors(['login' => 'OTP has expired. Please login again.']);
        }

        if ((int) $request->input('otp') !== (int) session('auth.otp')) {
            throw ValidationException::withMessages([
                'otp' => 'The provided OTP is incorrect.',
            ]);
        }

        // OTP is valid
        $user = User::find(session('auth.user_id'));
        $remember = session('auth.remember');

        Auth::login($user, $remember);
        $request->session()->regenerate();

        // Clear session data
        session()->forget(['auth.otp', 'auth.user_id', 'auth.remember', 'auth.otp_expires_at']);

        return redirect()->intended(config('fortify.home', '/dashboard'));
    }
}
