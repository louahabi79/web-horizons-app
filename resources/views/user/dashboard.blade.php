@extends('layouts.app')

@section('title', 'Dashboard - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-header">
        <h1>Tableau de bord</h1>
        <div class="quick-actions">
            <a href="{{ route('createPoste.form') }}" class="btn btn-primary">
                <span class="icon">✏️</span>
                Proposer un Article
            </a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-info">
                <h3>Articles Proposés</h3>
                <p class="stat-number">{{ $articlesCount ?? 0 }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🔔</div>
            <div class="stat-info">
                <h3>Abonnements</h3>
                <p class="stat-number">{{ $subscriptionsCount ?? 0 }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📖</div>
            <div class="stat-info">
                <h3>Articles Lus</h3>
                <p class="stat-number">{{ $readArticlesCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-sections">
        <section class="recent-activity">
            <h2>Activité Récente</h2>
            <div class="activity-list">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">📚</div>
                        <div class="activity-content">
                            <h4>{{ $activity->article->titre }}</h4>
                            <p>Lu le {{ $activity->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="no-activity">Aucune activité récente</p>
                @endforelse
            </div>
        </section>

        <section class="quick-access">
            <h2>Accès Rapide</h2>
            <div class="quick-links">
                <a href="{{ route('user.subscriptions') }}" class="quick-link-card">
                    <span class="icon">🔔</span>
                    <h3>Gérer mes Abonnements</h3>
                </a>
                <a href="{{ route('user.articles') }}" class="quick-link-card">
                    <span class="icon">📝</span>
                    <h3>Mes Articles</h3>
                </a>
                <a href="{{ route('user.history') }}" class="quick-link-card">
                    <span class="icon">📖</span>
                    <h3>Historique de Lecture</h3>
                </a>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
