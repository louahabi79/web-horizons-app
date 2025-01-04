<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function login(Request $request){
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
            if ($user->role === 'Éditeur') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome, ' . $user->first_name . '!');
            } elseif ($user->role === 'Abonné') {
                return redirect()->route('user.dashboard')->with('success', 'Welcome, ' . $user->first_name . '!');
            } else {
                return redirect()->route('home')->with('success', 'Welcome, ' . $user->first_name . '!');
            }
        }

        // If login fails, redirect back with errors
        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);



    }
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255', // Validate first name
            'last_name' => 'required|string|max:255',  // Validate last name
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Combine first name and last name into 'nom'
        $nom = $request->first_name . ' ' . $request->last_name;

        // Create the user
        $user = User::create([
            'nom' => $nom, // Use the combined name
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Abonné', // Default role
            'date_inscription' => now(), // Current timestamp
        ]);

        // Log the user in
        auth()->login($user);

        // Redirect to the user dashboard
        return redirect()->route('user.dashboard')->with('success', 'Welcome, ' . $user->nom . '!');
    }

    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route("login.form"));
    }
}
