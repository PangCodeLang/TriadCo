<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('login.login');
    }

    /**
     * Handle login requests.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('first_login', true);

            // Redirect to the intended route or dashboard
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Handle logout requests.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page after logout
        return redirect()->route('login');
    }
}