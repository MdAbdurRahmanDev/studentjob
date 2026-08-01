<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');
Route::get('/shifts', \App\Livewire\ShiftList::class)->name('shifts.index');
Route::get('/shifts/{shift}', \App\Livewire\ShiftDetails::class)->name('shifts.show');
Route::get('/admin/login', \App\Livewire\AdminLogin::class)->name('admin.login');

Route::get('/employer/register', \App\Livewire\EmployerRegister::class)->name('employer.register');
Route::get('/employer/post-shift', \App\Livewire\PostShift::class)->name('employer.post-shift')->middleware(['auth']);
Route::get('/employer/shifts/{shift}/edit', function (\App\Models\Job $shift) {
    abort_if($shift->user_id !== auth()->id(), 403, 'Unauthorized access.');
    return view('employer.edit-shift', compact('shift'));
})->name('employer.edit-shift')->middleware(['auth']);
Route::get('/employer/shifts/{shift}/applications', \App\Livewire\Employer\ManageApplications::class)->name('employer.applications')->middleware(['auth']);

// Custom Auth Routes for SMS OTP (Login)
Route::post('/login/custom', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.custom')->middleware(['guest', 'throttle:3,1']);
Route::get('/login/verify', [\App\Http\Controllers\Auth\LoginController::class, 'showVerifyOtp'])->name('login.verify')->middleware(['guest']);
Route::post('/login/verify', [\App\Http\Controllers\Auth\LoginController::class, 'verifyOtp'])->name('login.verify.post')->middleware(['guest', 'throttle:5,1']);

// Custom Auth Routes for SMS OTP (Registration)
Route::post('/register/custom', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.custom')->middleware(['guest', 'throttle:3,1']);
Route::get('/register/verify', [\App\Http\Controllers\Auth\RegisterController::class, 'showVerifyOtp'])->name('register.verify')->middleware(['guest']);
Route::post('/register/verify', [\App\Http\Controllers\Auth\RegisterController::class, 'verifyOtp'])->name('register.verify.post')->middleware(['guest', 'throttle:5,1']);

// Custom Auth Route for Forgot Password (OTP)
Route::get('/forgot-password', \App\Livewire\Auth\ForgotPassword::class)->name('password.request')->middleware(['guest']);
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/subscribe', \App\Livewire\Subscribe::class)->name('subscribe');
    Route::view('/verify-identity', 'student.verify-identity')->name('verify-identity');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('users/search', \App\Livewire\Admin\UserProfileSearch::class)->name('users.search');
    Route::view('users', 'admin.users')->name('users');
    Route::view('payment-methods', 'admin.payment-methods')->name('payment-methods');
    Route::view('jobs', 'admin.jobs')->name('jobs');
    Route::view('transactions', 'admin.transactions')->name('transactions');
    Route::get('applications', \App\Livewire\Admin\Applications\Index::class)->name('applications');
    Route::view('verifications', 'admin.verifications')->name('verifications');
    Route::view('documentation', 'admin.documentation')->name('documentation');
    Route::get('categories', \App\Livewire\Admin\Categories\Index::class)->name('categories');
    Route::get('ads', \App\Livewire\Admin\Ads\Index::class)->name('ads');
    Route::get('settings/general', \App\Livewire\Admin\Settings\General::class)->name('settings.general');
    Route::get('settings/seo', \App\Livewire\Admin\Settings\Seo::class)->name('settings.seo');
    Route::get('settings/home-page', \App\Livewire\Admin\Settings\HomePage::class)->name('settings.home-page');
    Route::get('settings/sms', \App\Livewire\Admin\Settings\Sms::class)->name('settings.sms');
    Route::get('blocked-ips', \App\Livewire\Admin\BlockedIps::class)->name('blocked-ips');
});

Route::get('/force-upload', function() {
    $method = \App\Models\PaymentMethod::first();
    return '
    <div style="padding: 50px; font-family: sans-serif;">
        <form method="POST" action="/force-upload" enctype="multipart/form-data">
            ' . csrf_field() . '
            <h2>Force Upload Logo for: ' . ($method ? $method->name : 'No Method') . '</h2>
            <input type="file" name="logo" required><br><br>
            <button type="submit" style="padding: 10px 20px; background: blue; color: white; cursor: pointer;">Force Upload</button>
        </form>
    </div>
    ';
});

Route::post('/force-upload', function(\Illuminate\Http\Request $request) {
    $method = \App\Models\PaymentMethod::first();
    if (!$method) return "Please create a payment method first from the admin panel!";
    
    if ($request->hasFile('logo')) {
        $path = $request->file('logo')->store('payment_logos', 'public');
        $method->logo = $path;
        $method->save();
        
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return "<h2 style='color:green'>Upload Success! Image saved successfully.</h2>
                <p>Path: " . $path . "</p>
                <a href='/'>Go to Website</a>";
    }
    return "No file uploaded.";
});

Route::get('/storage-link', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Storage linked successfully!';
})->middleware(['auth', 'admin']);

require __DIR__.'/settings.php';
