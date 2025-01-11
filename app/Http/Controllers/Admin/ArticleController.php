<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Éditeur') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $articles = Article::where('statut', 'Proposé')
            ->with(['auteur', 'theme'])
            ->orderBy('date_proposition_editeur', 'desc')
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        if ($article->statut !== 'Proposé') {
            abort(404);
        }

        return view('admin.articles.show', [
            'article' => $article->load(['auteur', 'theme'])
        ]);
    }

    public function publish(Article $article)
    {
        if ($article->statut !== 'Proposé') {
            return response()->json([
                'success' => false,
                'message' => 'Cet article n\'est pas en attente de validation finale.'
            ], 400);
        }

        $article->update([
            'statut' => 'Publié',
            'date_publication' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'L\'article a été publié avec succès.'
        ]);
    }

    public function reject(Request $request, Article $article)
    {
        if ($article->statut !== 'Proposé') {
            return response()->json([
                'success' => false,
                'message' => 'Cet article n\'est pas en attente de validation finale.'
            ], 400);
        }

        $request->validate([
            'motif_rejet' => 'required|string|max:500'
        ]);

        $article->update([
            'statut' => 'Rejeté',
            'motif_rejet' => $request->motif_rejet
        ]);

        return response()->json([
            'success' => true,
            'message' => 'L\'article a été rejeté.'
        ]);
    }
} 