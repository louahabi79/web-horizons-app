<?php

namespace App\Http\Controllers\User;
use App\Models\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Commencer avec l'historique de l'utilisateur connecté uniquement
        $query = $user->navigationHistory()
            ->with(['article.theme', 'article.auteur']);

        // Filtre par thème
        if ($request->theme) {
            $query->whereHas('article', function($q) use ($request) {
                $q->where('theme_id', $request->theme);
            });
        }

        // Filtre par date
        if ($request->date_start) {
            $query->whereDate('date_consultation', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->whereDate('date_consultation', '<=', $request->date_end);
        }

        // Filtre par mot-clé
        if ($request->search) {
            $query->whereHas('article', function($q) use ($request) {
                $q->where('titre', 'like', "%{$request->search}%")
                    ->orWhere('contenu', 'like', "%{$request->search}%");
            });
        }

        // Récupérer l'historique paginé
        $history = $query->orderBy('date_consultation', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Récupérer uniquement les thèmes des articles auxquels l'utilisateur est abonné
        $themes = Theme::all();

        return view('user.history.index', [
            'history' => $history,
            'themes' => $themes
        ]);
    }
} 