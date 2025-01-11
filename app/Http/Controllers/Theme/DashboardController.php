<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Theme;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Responsable de thème') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $user = Auth::user();
        $theme = $user->managedTheme;

        // Statistiques rapides
        $stats = [
            'total_subscribers' => $theme->abonnes()->count(),
            'pending_articles' => $theme->articles()->where('statut', 'En cours')->count(),
            'published_articles' => $theme->articles()->where('statut', 'Publié')->count(),
            'total_views' => $theme->articles()->sum('vues'),
            'recent_subscriptions' => $theme->abonnes()
                                         ->orderBy('created_at', 'desc')
                                         ->take(5)
                                         ->get(),
            'recent_articles' => $theme->articles()
                                    ->with('auteur')
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get(),
        ];

        return view('theme.dashboard', compact('theme', 'stats'));
    }
} 