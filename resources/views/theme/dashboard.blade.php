@extends('layouts.app')

@section('title', 'Dashboard Responsable - ' . $theme->nom_theme)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/theme/dashboard.css') }}">
@endsection

@section('content')
<div class="theme-dashboard-wrapper">
    <div class="dashboard-header">
        <h1>Tableau de bord - {{ $theme->nom_theme }}</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <h3>Abonnés</h3>
                <p class="stat-number">{{ $stats['total_subscribers'] }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-info">
                <h3>Articles en attente</h3>
                <p class="stat-number">{{ $stats['pending_articles'] }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-info">
                <h3>Articles publiés</h3>
                <p class="stat-number">{{ $stats['published_articles'] }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">👁️</div>
            <div class="stat-info">
                <h3>Vues totales</h3>
                <p class="stat-number">{{ $stats['total_views'] }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <section class="recent-articles">
            <h2>Articles récents</h2>
            <div class="articles-list">
                @forelse($stats['recent_articles'] as $article)
                    <div class="article-item">
                        <h3>{{ $article->titre }}</h3>
                        <div class="article-meta">
                            <span>Par {{ $article->auteur->nom }}</span>
                            <span>{{ $article->created_at->format('d/m/Y') }}</span>
                            <span class="status-badge status-{{ $article->statut }}">
                                {{ $article->statut }}
                            </span>
                        </div>
                        <div class="article-actions">
                            <a href="{{ route('theme.articles.show', $article) }}" 
                               class="btn btn-primary">Voir</a>
                        </div>
                    </div>
                @empty
                    <p>Aucun article récent</p>
                @endforelse
            </div>
        </section>

        <section class="recent-subscriptions">
            <h2>Nouveaux abonnés</h2>
            <div class="subscribers-list">
                @forelse($stats['recent_subscriptions'] as $subscriber)
                    <div class="subscriber-item">
                        <span>{{ $subscriber->nom }}</span>
                        <span>{{ $subscriber->pivot->created_at->format('d/m/Y') }}</span>
                    </div>
                @empty
                    <p>Aucun nouvel abonné</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection 