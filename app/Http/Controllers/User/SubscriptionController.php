<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $themes = Theme::all();
        $subscribedThemeIds = $user->subscribedThemes()
            ->pluck('theme_id')
            ->toArray();

        return view('user.subscriptions', compact('themes', 'subscribedThemeIds'));
    }

    public function subscribe(Theme $theme)
    {
        try {
            // Vérifier si l'utilisateur n'est pas déjà abonné
            $existingSubscription = Subscription::where('user_id', Auth::id())
                ->where('theme_id', $theme->id)
                ->exists();

            if ($existingSubscription) {
                return back()->with('error', 'Vous êtes déjà abonné à ce thème.');
            }

            // Créer l'abonnement
            Subscription::create([
                'user_id' => Auth::id(),
                'theme_id' => $theme->id,
                'date_abonnement' => now()
            ]);

            return back()->with('success', 'Vous êtes maintenant abonné à ce thème.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'abonnement: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'abonnement.');
        }
    }

    public function unsubscribe(Theme $theme)
    {
        try {
            // Supprimer l'abonnement
            Subscription::where('user_id', Auth::id())
                ->where('theme_id', $theme->id)
                ->delete();

            return back()->with('success', 'Vous êtes maintenant désabonné de ce thème.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors du désabonnement: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du désabonnement.');
        }
    }
} 