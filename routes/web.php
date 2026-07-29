<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');
Route::get('/shifts', \App\Livewire\ShiftList::class)->name('shifts.index');
Route::get('/shifts/{shift}', \App\Livewire\ShiftDetails::class)->name('shifts.show');
Route::get('/admin/login', \App\Livewire\AdminLogin::class)->name('admin.login');

Route::get('/employer/register', \App\Livewire\EmployerRegister::class)->name('employer.register');
Route::get('/employer/post-shift', \App\Livewire\PostShift::class)->name('employer.post-shift')->middleware(['auth']);
Route::get('/employer/shifts/{shift}/edit', function (\App\Models\Job $shift) {
    return view('employer.edit-shift', compact('shift'));
})->name('employer.edit-shift')->middleware(['auth']);
Route::get('/employer/shifts/{shift}/applications', \App\Livewire\Employer\ManageApplications::class)->name('employer.applications')->middleware(['auth']);

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
    Route::get('settings/home-page', \App\Livewire\Admin\Settings\HomePage::class)->name('settings.home-page');
});

require __DIR__.'/settings.php';
