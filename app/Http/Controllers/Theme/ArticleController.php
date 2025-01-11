<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Responsable de thème') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $theme = Auth::user()->managedTheme;
        $articles = $theme->articles()
            ->with(['auteur'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('theme.articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        // Vérifier si l'article appartient au thème géré par le responsable
        if ($article->theme_id !== Auth::user()->managedTheme->id) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cet article.');
        }

        return view('theme.articles.show', [
            'article' => $article->load(['auteur', 'theme'])
        ]);
    }

    public function proposeForPublication(Article $article)
    {
        try {
            // Vérifier si l'article appartient au thème géré par le responsable
            if ($article->theme_id !== Auth::user()->managedTheme->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'êtes pas autorisé à gérer cet article.'
                ], 403);
            }

            // Vérifier si l'article peut être proposé (En cours ou Publié)
            if ($article->statut !== 'En cours' && $article->statut !== 'Publié') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cet article ne peut pas être proposé dans son état actuel.'
                ], 400);
            }

            // Mettre à jour le statut de l'article
            $article->update([
                'statut' => 'Retenu',
                'date_proposition_editeur' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'L\'article a été proposé à l\'éditeur pour validation.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la proposition d\'article: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du traitement de votre demande.'
            ], 500);
        }
    }

    public function reject(Request $request, Article $article)
    {
        // Vérifier si l'article appartient au thème géré par le responsable
        if ($article->theme_id !== Auth::user()->managedTheme->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à gérer cet article.'
            ], 403);
        }

        // Vérifier si l'article est en attente
        if ($article->statut !== 'En cours') {
            return response()->json([
                'success' => false,
                'message' => 'Cet article n\'est pas en attente de validation.'
            ], 400);
        }

        $request->validate([
            'motif_rejet' => 'required|string|max:500'
        ]);

        // Mettre à jour le statut de l'article
        $article->update([
            'statut' => 'Refusé',
            'motif_rejet' => $request->motif_rejet
        ]);

        return response()->json([
            'success' => true,
            'message' => 'L\'article a été refusé.'
        ]);
    }
} 