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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Redirect based on role
            return match($user->role) {
                'Éditeur' => redirect()->route('admin.dashboard'),
                'Responsable de thème' => redirect()->route('theme.dashboard'),
                'Abonné' => redirect()->route('user.dashboard'),
                default => redirect()->route('home'),
            };
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
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
        return redirect(route("login"));
    }
}
