<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');
Route::get('/shifts', \App\Livewire\ShiftList::class)->name('shifts.index');
Route::get('/shifts/{shift}', \App\Livewire\ShiftDetails::class)->name('shifts.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
