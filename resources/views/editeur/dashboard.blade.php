@extends('layouts.app')

@section('title', 'Dashboard Éditeur')

@section('styles')
<style>
.dashboard-container {
    padding: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.stat-card h3 {
    margin: 0 0 0.5rem 0;
    color: #2d3748;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #4a5568;
}

.recent-data {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.data-section {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.data-section h2 {
    margin-bottom: 1rem;
    color: #2d3748;
}

.chart-container {
    margin-top: 2rem;
}

.data-list {
    list-style: none;
    padding: 0;
}

.data-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.data-item:last-child {
    border-bottom: none;
}
</style>
@endsection

@section('content')
<br> <br><br>
<div class="page-container dashboard-container">
    <!-- <h1>Dashboard Éditeur</h1> -->

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Abonnés</h3>
            <p class="stat-number">{{ $stats['total_abonnes'] }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Responsables</h3>
            <p class="stat-number">{{ $stats['total_responsables'] }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Numéros</h3>
            <p class="stat-number">{{ $stats['total_numeros'] }}</p>
            <p class="stat-detail">Publiés: {{ $stats['numeros_publies'] }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Articles</h3>
            <p class="stat-number">{{ $stats['total_articles'] }}</p>
            <p class="stat-detail">Publiés: {{ $stats['articles_publies'] }}</p>
            <p class="stat-detail">En cours: {{ $stats['articles_en_cours'] }}</p>
            <p class="stat-detail">Proposés par les responsables: {{ $stats['articles_proposes'] }}</p>
        </div>
    </div>

    <div class="recent-data">
        <div class="data-section">
            <h2>Articles par Thème</h2>
            <ul class="data-list">
                @foreach($stats['articles_par_theme'] as $theme)
                <li class="data-item">
                    {{ $theme->nom_theme }}: {{ $theme->articles_count }} articles
                </li>
                @endforeach
            </ul>
        </div>

        <div class="data-section">
            <h2>Abonnements par Thème</h2>
            <ul class="data-list">
                @foreach($stats['abonnements_par_theme'] as $theme)
                <li class="data-item">
                    {{ $theme->nom_theme }}: {{ $theme->abonnements_count }} abonnés
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="recent-data">
        <div class="data-section">
            <h2>Derniers Articles</h2>
            <ul class="data-list">
                @foreach($stats['derniers_articles'] as $article)
                <li class="data-item">
                    <div class="item-title">{{ $article->titre }}</div>
                    <div class="item-meta">
                        Par {{ $article->auteur->nom }} - {{ $article->theme->nom_theme }}
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="data-section">
            <h2>Articles Proposés Récemment</h2>
            <ul class="data-list">
                @foreach($stats['derniers_articles_proposes'] as $article)
                <li class="data-item">
                    <div class="item-title">{{ $article->titre }}</div>
                    <div class="item-meta">
                        Proposé par {{ $article->auteur->nom }} - {{ $article->theme->nom_theme }}
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="recent-data">
        <div class="data-section">
            <h2>Derniers Utilisateurs</h2>
            <ul class="data-list">
                @foreach($stats['derniers_utilisateurs'] as $user)
                <li class="data-item">
                    <div class="item-title">{{ $user->nom }}</div>
                    <div class="item-meta">{{ $user->role }} - Inscrit le {{ $user->created_at->format('d/m/Y') }}</div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection 