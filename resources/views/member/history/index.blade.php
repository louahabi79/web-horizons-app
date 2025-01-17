@extends('layouts.member')

@section('title', 'Historique de Lecture - Tech Magazine')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/member/history.css') }}">
@endsection

@section('page-title', 'Historique de Lecture')

@section('content')
<div class="history-container">
    <header class="history-header">
        <!-- <h1>Historique de Lecture</h1> -->
        <h1></h1>
    </header>

    <div class="filters-section">
        <form action="{{ route('member.history') }}" method="GET" class="filters-form">
            <div class="filter-group">
                <label for="theme">Thème</label>
                <select name="theme" id="theme" class="form-control">
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
                <input type="date" 
                       name="date_start" 
                       id="date_start" 
                       value="{{ request('date_start') }}" 
                       class="form-control">
            </div>

            <div class="filter-group">
                <label for="date_end">Date fin</label>
                <input type="date" 
                       name="date_end" 
                       id="date_end" 
                       value="{{ request('date_end') }}" 
                       class="form-control">
            </div>

            <div class="filter-group">
                <label for="search">Recherche</label>
                <input type="text" 
                       name="search" 
                       id="search" 
                       value="{{ request('search') }}" 
                       placeholder="Rechercher un article..."
                       class="form-control">
            </div>

            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="{{ route('member.history') }}" class="btn-reset">Réinitialiser</a>
        </form>
    </div>

    <div class="history-list">
        @forelse($history as $entry)
            <div class="history-item">
                <div class="article-info">
                    <h2>
                        <a href="{{ route('member.articles.show', $entry->article) }}">
                            {{ $entry->article->titre }}
                        </a>
                    </h2>
                    <div class="meta">
                        <span class="theme">{{ $entry->article->theme->nom_theme }}</span>
                        <span class="author">Par {{ $entry->article->auteur->nom }}</span>
                        <span class="date">Lu le {{ $entry->date_consultation->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-history">
                <p>Aucun article lu pour le moment.</p>
                <a href="{{ route('member.articles') }}" class="btn-primary">
                    Découvrir des articles
                </a>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $history->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 