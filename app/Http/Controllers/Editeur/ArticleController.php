<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Numero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['theme', 'auteur', 'numero'])
            ->where('statut', '!=', 'En cours')
            ->orderBy('date_proposition_editeur', 'desc')
            ->get()
            ->groupBy('statut');

        $numeros = Numero::where('is_published', false)->get();
        \Log::info('numeros récupérés', ['numeros' => $numeros]);

        return view('editeur.articles.index', compact('articles', 'numeros'));
    }

    public function approve(Article $article)
    {
        if ($article->statut !== 'Proposé') {
            return back()->with('error', 'Cet article ne peut pas être approuvé.');
        }

        $article->update([
            'statut' => 'Publié',
            'date_publication' => now()
        ]);

        return back()->with('success', 'Article approuvé avec succès.');
    }

    public function reject(Request $request, Article $article)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:500'
        ]);

        if ($article->statut !== 'Proposé') {
            return back()->with('error', 'Cet article ne peut pas être rejeté.');
        }

        $article->update([
            'statut' => 'Refusé',
            'motif_rejet' => $request->motif_rejet
        ]);

        return back()->with('success', 'Article rejeté.');
    }

    public function assignToNumero(Request $request, Article $article)
    {
        \Log::info('Tentative d\'affectation', [
            'article_id' => $article->id,
            'numero_id' => $request->numero_id,
            'statut_actuel' => $article->statut,
            'request_all' => $request->all()
        ]);

        $validated = $request->validate([
            'numero_id' => 'required|exists:numeros,Id_numero'
        ], [
            'numero_id.required' => 'Veuillez sélectionner un numéro',
            'numero_id.exists' => 'Le numéro sélectionné n\'existe pas'
        ]);

        if ($article->statut !== 'Retenu') {
            return back()->with('error', 'Seuls les articles retenus peuvent être affectés à un numéro.');
        }

        try {
            $article->update([
                'numero_id' => $validated['numero_id'],
                'statut' => 'Publié',
                'date_publication' => now()
            ]);

            return back()->with('success', 'Article affecté au numéro et publié avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'affectation', [
                'error' => $e->getMessage(),
                'article_id' => $article->id,
                'numero_id' => $validated['numero_id']
            ]);
            return back()->with('error', 'Une erreur est survenue lors de l\'affectation de l\'article.');
        }
    }

    public function toggleStatus(Article $article)
    {
        if ($article->statut === 'Publié') {
            $article->update([
                'statut' => 'Désactivé'
            ]);
            $message = 'Article désactivé avec succès.';
        } else {
            $article->update([
                'statut' => 'Publié',
                'date_publication' => now()
            ]);
            $message = 'Article activé avec succès.';
        }

        return back()->with('success', $message);
    }

    public function destroy(Article $article)
    {
        // Supprimer l'image de couverture si elle existe
        if ($article->image_couverture) {
            Storage::disk('public')->delete($article->image_couverture);
        }

        $article->delete();

        return back()->with('success', 'Article supprimé avec succès.');
    }
} 