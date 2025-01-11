<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class DashboardController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Abonné') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function index()
    {
        try {
            $user = Auth::user();
            
            $data = [
                'articlesCount' => $user->articles()->count(),
                'subscriptionsCount' => $user->subscribedThemes()->count(),
                'readArticlesCount' => $user->navigationHistory()->count(),
                'recentActivities' => $user->navigationHistory()
                    ->with(['article' => function($query) {
                        $query->select('id', 'titre', 'date_publication');
                    }])
                    ->latest()
                    ->take(5)
                    ->get()
            ];

            return view('user.dashboard', $data);
        } catch (Exception $e) {
            return view('user.dashboard', [
                'articlesCount' => 0,
                'subscriptionsCount' => 0,
                'readArticlesCount' => 0,
                'recentActivities' => [],
                'error' => 'Une erreur est survenue lors du chargement des données.'
            ]);
        }
    }
} 