<?php

namespace App\Http\Controllers;

use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    // Redirect to Google for authentication
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback from Google
    public function handleGoogleCallback()
    {
        try {
            // Use stateless to avoid session issues
            $googleUser = Socialite::driver('google')
                ->stateless()
                // Uncomment below line if you're disabling SSL verification (Not recommended for production)
                // ->setConfig(['verify' => false])
                ->user();

            // Check if user already exists
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // Log the user in if they already exist
                Auth::login($user);
            } else {
                // Create a new user if they don't exist
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(uniqid()), // Generate a random password
                    'google_id' => $googleUser->id, // Store Google ID
                ]);
                Auth::login($user);
            }

            // Redirect to success page
            return redirect('/auth/success');
        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('Google login error: ' . $e->getMessage());

            // Optional: You can also dump the exception message for further insights
            dd('Google login error: ' . $e->getMessage());

            return redirect('/auth/error')->withErrors('Unable to authenticate using Google. Please try again.');
        }
    }

    // Logout function
    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect the user to the login page or home page
        return redirect('/login')->with('message', 'You have been successfully logged out.');
    }
}
