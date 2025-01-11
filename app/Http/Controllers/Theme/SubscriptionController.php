<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
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
        if (!$theme) {
            return back()->with('error', 'Vous n\'êtes pas responsable d\'un thème.');
        }

        $subscriptions = $theme->subscribers()
            ->withPivot(['id', 'date_abonnement'])
            ->orderBy('subscriptions.created_at', 'desc')
            ->paginate(10);

        return view('theme.subscriptions.index', compact('subscriptions'));
    }

    public function remove($subscriptionId)
    {
        $theme = Auth::user()->managedTheme;
        
        // Vérifier si l'abonnement existe et appartient au thème
        $subscription = Subscription::where('id', $subscriptionId)
            ->where('theme_id', $theme->id)
            ->first();

        if (!$subscription) {
            return back()->with('error', 'Abonnement introuvable ou non autorisé.');
        }

        // Vérifier que l'abonnement appartient bien au thème du responsable
        if ($subscription->theme_id !== $theme->id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à gérer cet abonnement.');
        }

        $subscription->delete();

        return back()->with('success', 'L\'abonnement a été retiré avec succès.');
    }
} 