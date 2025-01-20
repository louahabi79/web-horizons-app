@extends('layouts.editor')

@section('title', 'Dashboard - Éditeur')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/editor/dashboard.css') }}">
@endsection

@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-grid">
    <div class="stats-card">
        <div class="stats-header">
            <h3>Articles en attente</h3>
            <span class="icon">📝</span>
        </div>
        <div class="stats-content">
            <span class="stats-value">{{ $stats['articles_proposes'] }}</span>
            <span class="stats-label">Articles à valider</span>
        </div>
        <a href="{{ route('editor.articles.index') }}" class="stats-link">Voir les articles</a>
    </div>

    <div class="stats-card">
        <div class="stats-header">
            <h3>Numéros</h3>
            <span class="icon">🎯</span>
        </div>
        <div class="stats-content">
            <span class="stats-value">{{ $stats['total_numeros'] }}</span>
            <span class="stats-label">Numéros publiés</span>
        </div>
        <a href="{{ route('editor.issues.index') }}" class="stats-link">Gérer les numéros</a>
    </div>

    <div class="stats-card">
        <div class="stats-header">
            <h3>Articles publiés</h3>
            <span class="icon">✅</span>
        </div>
        <div class="stats-content">
            <span class="stats-value">{{ $stats['articles_publies'] }}</span>
            <span class="stats-label">Total des publications</span>
        </div>
    </div>
</div>

<div class="recent-section">
    <div class="section-header">
        <h2>Articles récemment soumis</h2>
        <a href="{{ route('editor.articles.index') }}" class="btn-view-all">Voir tout</a>
    </div>

    <div class="articles-grid">
        @forelse($stats['derniers_articles_proposes'] as $article)
            <div class="article-card">
                @if($article->image_couverture)
                    <div class="article-image">
                        <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="{{ $article->titre }}">
                    </div>
                @endif
                <div class="article-content">
                    <div class="article-header">
                        <h3>{{ $article->titre }}</h3>
                        <div class="article-badges">
                            <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                            <span class="status-badge {{ $article->statut }}">{{ $article->statut }}</span>
                        </div>
                    </div>
                    <div class="article-meta">
                        <span>Par {{ $article->auteur->nom }}</span>
                        <span>{{ $article->created_at->format('d/m/Y') }}</span>
                    </div>
                    <a href="{{ route('editor.articles.show', $article) }}" class="btn-review">
                        Examiner
                    </a>
                </div>
            </div>
        @empty
            <p class="no-articles">Aucun article récent</p>
        @endforelse
    </div>
</div>
@endsection 