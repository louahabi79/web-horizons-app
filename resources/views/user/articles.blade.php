@extends('layouts.app')

@section('title', 'Articles - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/user/articles.css') }}">
@endsection

@section('content')
<div class="articles-wrapper">
    <div class="articles-header">
        <h1>Articles</h1>
        <div class="theme-filter">
            <select onchange="window.location.href=this.value">
                <option value="{{ route('user.articles') }}" {{ !$selectedTheme ? 'selected' : '' }}>
                    Tous les thèmes
                </option>
                @foreach($subscribedThemes as $theme)
                    <option 
                        value="{{ route('user.articles', ['theme' => $theme->id]) }}"
                        {{ $selectedTheme == $theme->id ? 'selected' : '' }}
                    >
                        {{ $theme->nom_theme }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="articles-grid">
        @forelse($articles as $article)
            <div class="article-card">
                <div class="article-image">
                    <img src="{{ asset('storage/articles/' . $article->image_couverture) }}" alt="{{ $article->titre }}">
                </div>
                <div class="article-content">
                    <div class="article-theme">{{ $article->theme->nom_theme }}</div>
                    <h3>{{ $article->titre }}</h3>
                    <div class="article-meta">
                        <span>Par {{ $article->auteur->nom }}</span>
                        <span>{{ $article->date_publication->format('d/m/Y') }}</span>
                    </div>
                    <p>{{ Str::limit($article->contenu, 150) }}</p>
                    <a href="{{ route('user.articles.show', $article) }}" class="read-more">
                        Lire la suite
                    </a>
                </div>
            </div>
        @empty
            <div class="no-articles">
                <p>Aucun article disponible pour le moment.</p>
                @if($selectedTheme)
                    <a href="{{ route('user.articles') }}" class="btn btn-primary">
                        Voir tous les articles
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $articles->links() }}
    </div>
</div>
@endsection 