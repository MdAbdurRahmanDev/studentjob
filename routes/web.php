<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');
Route::get('/shifts', \App\Livewire\ShiftList::class)->name('shifts.index');
Route::get('/shifts/{shift}', \App\Livewire\ShiftDetails::class)->name('shifts.show');
Route::get('/admin/login', \App\Livewire\AdminLogin::class)->name('admin.login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
