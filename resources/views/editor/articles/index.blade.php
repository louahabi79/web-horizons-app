@extends('layouts.editor')

@section('title', 'Articles Proposés - Éditeur')

@section('styles')
<link href="{{ asset('css/editor/articles.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="articles-container">
    <div class="articles-header">
        <h1>Articles Proposés</h1>
        <div class="header-actions">
            <div class="filters">
                <select class="filter-select" name="status">
                    <option value="">Tous les statuts</option>
                    <option value="Proposé" {{ request('status') == 'Proposé' ? 'selected' : '' }}>Proposés</option>
                    <option value="Publié" {{ request('status') == 'Publié' ? 'selected' : '' }}>Publiés</option>
                    <option value="Désactivé" {{ request('status') == 'Désactivé' ? 'selected' : '' }}>Désactivés</option>
                </select>
            </div>
        </div>
    </div>

    <div class="articles-grid">
        @forelse($articles['Proposé'] ?? [] as $article)
            <div class="article-card">
                <div class="article-header">
                    <div class="article-meta">
                        <span class="status-badge status-proposé">Proposé</span>
                        <span class="date">{{ $article->date_proposition_editeur->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="article-content">
                    <h3 class="article-title">{{ $article->titre }}</h3>
                    <p class="article-excerpt">{{ Str::limit($article->contenu, 150) }}</p>
                    
                    <div class="article-footer">
                        <div class="author-info">
                            <div class="author-avatar">
                                {{ substr($article->auteur->prenom, 0, 1) }}{{ substr($article->auteur->nom, 0, 1) }}
                            </div>
                            <div class="author-details">
                                <span class="author-name">{{ $article->auteur->nom }} {{ $article->auteur->prenom }}</span>
                                <span class="theme-name">{{ $article->theme->nom }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="article-actions">
                    <a href="{{ route('editor.articles.show', $article) }}" class="btn-action">
                        <i class="fas fa-eye"></i>
                        Voir l'article
                    </a>
                    <form action="{{ route('editor.articles.assign-to-numero', $article) }}" method="POST" class="inline">
                        @csrf
                        <select name="numero_id" class="select-numero" required>
                            <option value="">Sélectionner un numéro</option>
                            @foreach($numeros as $numero)
                                <option value="{{ $numero->Id_numero }}">
                                    {{ $numero->titre_numero }} (#{{ $numero->numero_edition }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-action btn-primary">
                            <i class="fas fa-plus"></i>
                            Ajouter au numéro
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-newspaper"></i>
                <h3>Aucun article proposé</h3>
                <p>Il n'y a pas d'articles proposés pour le moment.</p>
            </div>
        @endforelse
    </div>

    <div class="section-divider">Articles Publiés</div>

    <div class="articles-grid">
        @forelse($articles['Publié'] ?? [] as $article)
            <!-- Similar card structure with published status -->
        @empty
            <div class="empty-state">
                <i class="fas fa-newspaper"></i>
                <h3>Aucun article publié</h3>
                <p>Il n'y a pas d'articles publiés pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection 