<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        $pendingUsers = User::where('statut', 'en attente')->count();
        return view('editeur.users.index', compact('users', 'pendingUsers'));
    }

    public function pendingRequests()
    {
        $users = User::where('statut', 'en attente')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        return view('editeur.users.pending', compact('users'));
    }

    public function approveUser(User $user)
    {
        $user->update(['statut' => 'actif']);
        return back()->with('success', 'Inscription approuvée avec succès.');
    }

    public function rejectUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Inscription rejetée avec succès.');
    }

    public function block(User $user)
    {
        $user->update(['statut' => 'inactif']);
        return back()->with('success', 'Utilisateur bloqué avec succès.');
    }

    public function unblock(User $user)
    {
        $user->update(['statut' => 'actif']);
        return back()->with('success', 'Utilisateur débloqué avec succès.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:Abonné,Responsable de thème,Éditeur'
        ]);

        $user->update(['role' => $request->role]);
        return back()->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
} 