<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateArticleController extends Controller
{
    public function showCreatePoste()
    {
        // Récupérer tous les thèmes pour le formulaire
        $themes = Theme::all();
        
        return view('user.articles.create', [
            'themes' => $themes
        ]);
    }

    public function createPoste(Request $request)
    {
        // Valider la requête
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'theme_id' => 'required|exists:themes,id',
            'contenu' => 'required|string',
            'temps_lecture' => 'required|integer|min:1',
            'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Gérer l'upload de l'image
        $imagePath = null;
        if ($request->hasFile('image_couverture')) {
            // Stocker uniquement le chemin relatif
            $imagePath = $request->file('image_couverture')->store('articles', 'public');
        }

        // Créer l'article
        $article = Article::create([
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'],
            'theme_id' => $validated['theme_id'],
            'temps_lecture' => $validated['temps_lecture'],
            'image_couverture' => $imagePath,
            'statut' => 'En cours',
            'user_id' => Auth::id(),
            'date_proposition' => now(),
            'vues' => 0
        ]);

        return redirect()
            ->route('user.propositions')
            ->with('success', 'Votre article a été soumis avec succès et est en attente de validation.');
    }
}

