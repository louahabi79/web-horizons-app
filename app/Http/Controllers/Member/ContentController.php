<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedTheme = $request->query('theme');
        
        $subscribedThemes = $user->subscribedThemes;
        
        $articlesQuery = Article::where('statut', 'Publié')
            ->whereIn('theme_id', $subscribedThemes->pluck('id'))
            ->with(['theme', 'auteur'])
            ->latest('date_publication');
            
        if ($selectedTheme) {
            $articlesQuery->where('theme_id', $selectedTheme);
        }
        
        $articles = $articlesQuery->paginate(12);
        
        return view('member.articles', [
            'articles' => $articles,
            'subscribedThemes' => $subscribedThemes,
            'selectedTheme' => $selectedTheme
        ]);
    }

    public function show(Article $article)
    {
        $user = Auth::user();
        if (!$user->subscribedThemes->contains('id', $article->theme_id)) {
            return redirect()->route('member.memberships')
                ->with('error', 'Vous devez être abonné au thème pour lire cet article.');
        }

        // Increment view count
        $article->increment('vues');

        // Add to history
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

        return view('member.submissions.show', [
            'article' => $article->load(['theme', 'auteur']),
            'similarArticles' => $similarArticles
        ]);
    }

    public function rate(Request $request, Article $article)
    {
        $request->validate([
            'note' => 'required|integer|between:1,5'
        ]);

        $user = Auth::user();
        
        $article->notes()->updateOrCreate(
            ['user_id' => $user->id],
            ['note' => $request->note]
        );

        return response()->json([
            'success' => true,
            'message' => 'Note enregistrée',
            'newAverage' => $article->averageRating()
        ]);
    }
} 