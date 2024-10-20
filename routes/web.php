<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;

// Redirect to login page for unauthenticated users
Route::get('/', function () {
    return redirect()->route('login'); // Use named route for better maintainability
});

// Google authentication routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Route for login view
Route::get('/login', function () {
    return view('auth.login'); // Render the login page
})->name('login');

// Handle success and error pages after Google authentication
Route::get('/auth/success', function () {
    return view('auth.success'); // Success page view
})->name('auth.success'); // Name the route for easier reference

Route::get('/auth/error', function () {
    return view('auth.error'); // Error page view
})->name('auth.error'); // Name the route for easier reference

// Logout route
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login')->with('message', 'You have been successfully logged out.');
})->name('logout');
// Redirect authenticated users to home or dashboard page
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home'); // Display home page to authenticated users
    })->name('home'); // Name the route for easier reference
});
