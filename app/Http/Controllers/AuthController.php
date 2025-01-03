<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function showLoginForm(){
        return view("auth.login");
    }
    function showRegistrationForm(){
        return view("auth.register");
    }
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Get the authenticated user
            $user = Auth::user();

            // Redirect based on the user's role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            } elseif ($user->role === 'user') {
                return redirect()->route('user.dashboard'); // Redirect to user dashboard
            } else {
                return redirect()->route('home'); // Default redirect
            }
        }

        // If login fails, redirect back with errors
        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);



    }
    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route("login.form"));
    }
}
