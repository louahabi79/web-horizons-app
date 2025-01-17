@extends('layouts.member')

@section('title', 'Articles - Tech Magazine')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/member/articles.css') }}">
@endsection

@section('page-title', 'Articles')

@section('header-actions')
<a href="{{ route('member.submit') }}" class="btn btn-primary">
    <span class="nav-icon">✏️</span>
    Soumettre un Article
</a>
@endsection

@section('content')
<div class="articles-container">
    <header class="articles-header">
        <div></div>
        <div class="theme-filter">
            <select onchange="window.location.href=this.value">
                <option value="{{ route('member.articles') }}" {{ !$selectedTheme ? 'selected' : '' }}>
                    Tous les thèmes
                </option>
                @foreach($subscribedThemes as $theme)
                    <option value="{{ route('member.articles', ['theme' => $theme->id]) }}" 
                            {{ $selectedTheme == $theme->id ? 'selected' : '' }}>
                        {{ $theme->nom_theme }}
                    </option>
                @endforeach
            </select>
        </div>
    </header>
    
    <div class="articles-grid">
        @forelse($articles as $article)
            <div class="article-card">
                @if($article->image_couverture)
                    <div class="article-image">
                        <img src="{{ asset('storage/' . $article->image_couverture) }}" 
                             alt="{{ $article->titre }}">
                    </div>
                @endif
                <div class="article-content">
                    <div class="article-meta">
                        <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                        <span class="date">{{ $article->date_publication->format('d M Y') }}</span>
                    </div>
                    <h2>{{ $article->titre }}</h2>
                    <p>{{ Str::limit($article->contenu, 150) }}</p>
                    <div class="article-footer">
                        <span class="author">Par {{ $article->auteur->nom }}</span>
                        <a href="{{ route('member.articles.show', $article) }}" class="read-more">
                            Lire la suite
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-articles">
                <p>Aucun article disponible pour le moment.</p>
                @if($selectedTheme)
                    <a href="{{ route('member.articles') }}" class="btn btn-primary">
                        Voir tous les articles
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $articles->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 