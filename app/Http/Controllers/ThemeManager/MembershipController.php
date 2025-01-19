<?php

namespace App\Http\Controllers\ThemeManager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
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
        $subscribers = $theme->subscribers()
            ->withPivot('created_at')
            ->orderBy('pivot_created_at', 'desc')
            ->paginate(10);

        return view('themeManager.members.index', compact('subscribers'));
    }

    public function export()
    {
        $theme = Auth::user()->managedTheme;
        $subscribers = $theme->subscribers;

        // Logique d'export CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="abonnes.csv"',
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nom', 'Email', 'Date d\'abonnement']);

            foreach ($subscribers as $user) {
                fputcsv($file, [
                    $user->nom,
                    $user->email,
                    $user->pivot->created_at->format('d/m/Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function remove(User $user)
    {
        $theme = Auth::user()->managedTheme;
        
        if (!$theme->subscribers->contains($user)) {
            return back()->with('error', 'Cet utilisateur n\'est pas abonné à votre thème.');
        }

        $theme->subscribers()->detach($user->id);
        return back()->with('success', 'Abonné retiré avec succès.');
    }
} 