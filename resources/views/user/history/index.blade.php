@extends('layouts.app')

@section('title', 'Historique de Navigation - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/history.css') }}">
@endsection

@section('content')
<div class="history-wrapper">
    <div class="history-header">
        <h1>Historique de Navigation</h1>
    </div>

    <div class="filters-section">
        <form action="{{ route('user.history') }}" method="GET" class="filters-form">
            <div class="filter-group">
                <label for="theme">Thème</label>
                <select name="theme" id="theme" class="filter-select">
                    <option value="">Tous les thèmes</option>
                    @foreach($themes as $theme)
                        <option value="{{ $theme->id }}" {{ request('theme') == $theme->id ? 'selected' : '' }}>
                            {{ $theme->nom_theme }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="date_start">Date début</label>
                <input type="date" name="date_start" id="date_start" 
                       value="{{ request('date_start') }}" 
                       class="filter-input">
            </div>

            <div class="filter-group">
                <label for="date_end">Date fin</label>
                <input type="date" name="date_end" id="date_end" 
                       value="{{ request('date_end') }}" 
                       class="filter-input">
            </div>

            <div class="filter-group">
                <label for="search">Rechercher</label>
                <input type="text" name="search" id="search" 
                       value="{{ request('search') }}" 
                       placeholder="Titre ou contenu..."
                       class="filter-input">
            </div>

            <button type="submit" class="btn btn-primary">Filtrer</button>
            @if(request()->hasAny(['theme', 'date_start', 'date_end', 'search']))
                <a href="{{ route('user.history') }}" class="btn btn-secondary">
                    Réinitialiser
                </a>
            @endif
        </form>
    </div>

    <div class="history-grid">
        @forelse($history as $entry)
            <div class="history-card">
                <div class="history-date">
                    {{ $entry->date_consultation }}
                </div>
                <div class="article-info">
                    <div class="theme-badge">{{ $entry->article->theme->nom_theme }}</div>
                    <h3>{{ $entry->article->titre }}</h3>
                    <div class="article-meta">
                        <span>Par {{ $entry->article->auteur->nom }}</span>
                    </div>
                    <p>{{ Str::limit($entry->article->contenu, 100) }}</p>
                    <a href="{{ route('user.articles.show', $entry->article) }}" class="btn btn-link">
                        Relire l'article
                    </a>
                </div>
            </div>
        @empty
            <div class="no-history">
                <p>Aucun article lu pour le moment.</p>
                <a href="{{ route('user.articles') }}" class="btn btn-primary">
                    Découvrir les articles
                </a>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $history->links() }}
    </div>
</div>
@endsection 