@extends('layouts.app')

@section('title', $article->titre . ' - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/article-detail.css') }}">
@endsection

@section('content')
<div class="article-detail-wrapper">
    <div class="article-header">
        <div class="article-meta">
            <a href="{{ route('user.articles', ['theme' => $article->theme->id]) }}" class="theme-badge">
                {{ $article->theme->nom_theme }}
            </a>
            @if($article->date_publication)
                <span class="date">{{ $article->date_publication->format('d M Y') }}</span>
            @endif
        </div>
        <h1>{{ $article->titre }}</h1>
        <div class="author-info">
            <span>Par {{ $article->auteur->nom }}</span>
            <div class="stats">
                <span title="Temps de lecture">📚 {{ $article->temps_lecture }} min</span>
                <span title="Nombre de vues">👁️ {{ $article->vues }}</span>
            </div>
        </div>
    </div>

    @if($article->image_couverture)
        <div class="article-cover">
            <img src="{{ asset('storage/' . $article->image_couverture) }}" 
                 alt="Image de couverture de {{ $article->titre }}">
        </div>
    @endif

    <div class="article-content">
        {!! nl2br(e($article->contenu)) !!}
    </div>

    <div class="article-actions">
        <a href="{{ route('user.conversations.show', $article) }}" class="btn btn-primary">
            Participer à la conversation
        </a>
    </div>

    @if($similarArticles->count() > 0)
        <div class="similar-articles">
            <h2>Articles similaires</h2>
            <div class="articles-grid">
                @foreach($similarArticles as $similarArticle)
                    <div class="article-card">
                        @if($similarArticle->image_couverture)
                            <div class="article-image">
                                <img src="{{ asset('storage/articles/' . $similarArticle->image_couverture) }}" 
                                     alt="{{ $similarArticle->titre }}">
                            </div>
                        @endif
                        <div class="article-content">
                            <h3>{{ $similarArticle->titre }}</h3>
                            <p>{{ Str::limit($similarArticle->contenu, 100) }}</p>
                            <a href="{{ route('user.articles.show', $similarArticle) }}" class="read-more">
                                Lire la suite
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection 