<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function () {
    Route::get('register', function() {
        return view('livewire.auth.register');
    })->name('register');

    Route::get('login', function() {
        return view('livewire.auth.login');
    })->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});