<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedTheme = $request->query('theme');
        
        $subscribedThemes = $user->subscribedThemes;
        
        $articlesQuery = Article::where('statut', 'publié')
            ->whereIn('theme_id', $subscribedThemes->pluck('id'))
            ->with(['theme', 'auteur'])
            ->latest('date_publication');
            
        if ($selectedTheme) {
            $articlesQuery->where('theme_id', $selectedTheme);
        }
        
        $articles = $articlesQuery->paginate(12);
        
        return view('user.articles', [
            'articles' => $articles,
            'subscribedThemes' => $subscribedThemes,
            'selectedTheme' => $selectedTheme
        ]);
    }

    public function show(Article $article)
    {
        $user = Auth::user();
        
        if (!$user->subscribedThemes->contains('id', $article->theme_id)) {
            return redirect()->route('user.subscriptions')
                ->with('error', 'Vous devez être abonné au thème pour lire cet article.');
        }

        // Incrémenter le compteur de vues
        $article->increment('vues');

        // Enregistrer dans l'historique
        $user->navigationHistory()->create([
            'article_id' => $article->id,
            'date_consultation' => now()
        ]);

        // Charger les articles similaires
        $similarArticles = Article::where('theme_id', $article->theme_id)
            ->where('id', '!=', $article->id)
            ->where('statut', 'publié')
            ->take(3)
            ->get();

        return view('user.articles.show', [
            'article' => $article->load(['theme', 'auteur']),
            'similarArticles' => $similarArticles
        ]);
    }
} 