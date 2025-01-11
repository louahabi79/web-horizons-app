<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticlePropositionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $propositions = $user->articles()
            ->with('theme')
            ->orderBy('date_proposition', 'desc')
            ->get()
            ->groupBy('statut');

        return view('user.propositions.index', [
            'propositions' => $propositions
        ]);
    }

    public function retirer(Article $article)
    {
        $user = Auth::user();
        
        // Vérifier si l'article appartient à l'utilisateur
        if ($article->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à supprimer cet article'
            ]);
        }

        // Supprimer l'article
        $article->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Article supprimé avec succès'
        ]);
    }
} 