<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('users', \App\Livewire\ManajemenPengguna::class)
    ->middleware(['auth', 'verified'])
    ->name('users.index');

Route::get('guests', \App\Livewire\ManajemenTamu::class)
    ->middleware(['auth', 'verified'])
    ->name('guests.index');

Route::get('dispatch', \App\Livewire\PenugasanTugas::class)
    ->middleware(['auth', 'verified'])
    ->name('tasks.dispatch');

Route::get('my-tasks', \App\Livewire\DashboardAnggota::class)
    ->middleware(['auth', 'verified'])
    ->name('member.dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
