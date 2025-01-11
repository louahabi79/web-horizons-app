<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class CreateArticleController extends Controller
{
    // Show the form to create a post
    public function showCreatePoste()
    {
        return view("user.createPoste");
    }

    // Handle the form submission to create a post
    public function createPoste(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255', // Validate title
            'article' => 'required|string',       // Validate article content
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Create the article and associate it with the user
        $article = Article::create([
            'titre' => $request->title,
            'contenu' => $request->article,
            'statut' => 'En cours', // Default status
            'theme_id' => 1,  // You can update this to dynamically assign a theme
            'user_id' => $user->id, // Associate the article with the logged-in user
            'date_proposition' => now(),
        ]); 

        // Redirect back with a success message
        return redirect()->route('user.createPoste.submit')->with('success', 'Article created successfully!');
    }
}

