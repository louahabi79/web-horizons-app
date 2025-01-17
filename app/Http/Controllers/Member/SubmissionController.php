<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $submissions = $user->articles()
            ->with('theme')
            ->orderBy('date_proposition', 'desc')
            ->get()
            ->groupBy('statut');

        return view('member.submissions.index', [
            'propositions' => $submissions
        ]);
    }

    public function create()
    {
        $themes = Theme::all();
        return view('member.submissions.create', ['themes' => $themes]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'theme_id' => 'required|exists:themes,id',
            'contenu' => 'required|string',
            'temps_lecture' => 'required|integer|min:1',
            'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image_couverture')) {
            $imagePath = $request->file('image_couverture')->store('articles', 'public');
        }

        Article::create([
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'],
            'theme_id' => $validated['theme_id'],
            'temps_lecture' => $validated['temps_lecture'],
            'image_couverture' => $imagePath,
            'statut' => 'En cours',
            'user_id' => Auth::id(),
            'date_proposition' => now(),
            'vues' => 0
        ]);

        return redirect()
            ->route('member.submissions')
            ->with('success', 'Votre article a été soumis avec succès.');
    }

    public function delete(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à supprimer cet article'
            ]);
        }

        if ($article->image_couverture) {
            Storage::disk('public')->delete($article->image_couverture);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article supprimé avec succès'
        ]);
    }
} 