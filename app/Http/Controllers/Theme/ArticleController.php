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
                return back()->with('error', 'Vous n\'êtes pas autorisé à gérer cet article.');
            }

            // Vérifier si l'article peut être proposé
            if ($article->statut !== 'En cours' && $article->statut !== 'Publié') {
                return back()->with('error', 'Cet article ne peut pas être proposé dans son état actuel.');
            }

            // Mettre à jour le statut de l'article
            $article->update([
                'statut' => 'Retenu',
                'date_proposition_editeur' => now()
            ]);

            return back()->with('success', 'L\'article a été proposé à l\'éditeur pour validation.');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la proposition d\'article: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du traitement de votre demande.');
        }
    }

    public function reject(Request $request, Article $article)
    {
        // Vérifier si l'article appartient au thème géré par le responsable
        if ($article->theme_id !== Auth::user()->managedTheme->id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à gérer cet article.');
        }

        // Vérifier si l'article peut être rejeté
        if ($article->statut !== 'En cours' && $article->statut !== 'Retenu') {
            return back()->with('error', 'Cet article ne peut pas être rejeté dans son état actuel.');
        }

        $request->validate([
            'motif_rejet' => 'required|string|max:500'
        ]);

        // Mettre à jour le statut de l'article
        $article->update([
            'statut' => 'Refusé',
            'motif_rejet' => $request->motif_rejet
        ]);

        return back()->with('success', 'L\'article a été refusé.');
    }

    public function accept(Article $article)
    {
        try {
            // Vérifier si l'article appartient au thème géré par le responsable
            if ($article->theme_id !== Auth::user()->managedTheme->id) {
                return back()->with('error', 'Vous n\'êtes pas autorisé à gérer cet article.');
            }

            // Vérifier si l'article peut être accepté
            if ($article->statut !== 'En cours') {
                return back()->with('error', 'Cet article ne peut pas être accepté dans son état actuel.');
            }

            // Mettre à jour le statut de l'article
            $article->update([
                'statut' => 'Publié',
                'date_publication' => now()
            ]);

            return back()->with('success', 'L\'article a été accepté.');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'acceptation d\'article: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du traitement de votre demande.');
        }
    }
} 