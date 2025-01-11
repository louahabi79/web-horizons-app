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
        
        if ($article->user_id !== $user->id || $article->statut !== 'En cours') {
            return back()->with('error', 'Action non autorisée');
        }

        $article->update(['statut' => 'Retiré']);
        
        return back()->with('success', 'Article retiré avec succès');
    }
} 