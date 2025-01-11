<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ModerationController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Responsable de thème') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function deleteMessage(Conversation $message)
    {
        $theme = Auth::user()->managedTheme;
        
        // Vérifier si le message appartient à un article du thème
        if ($message->article->theme_id !== $theme->id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à modérer ce message.');
        }

        $message->delete();
        return back()->with('success', 'Message supprimé avec succès.');
    }
} 