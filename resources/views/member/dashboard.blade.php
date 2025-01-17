@extends('layouts.member')

@section('title', 'Dashboard - Tech Magazine')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/member/dashboard.css') }}">
@endsection

@section('page-title', 'Tableau de bord')

@section('header-actions')
<a href="{{ route('member.submit') }}" class="btn btn-primary">
    <span class="nav-icon">✏️</span>
    Soumettre un Article
</a>
@endsection

@section('content')
<div class="dashboard-grid">
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-info">
                <span class="stat-value">{{ $articlesCount }}</span>
                <span class="stat-label">Articles Soumis</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🔔</div>
            <div class="stat-info">
                <span class="stat-value">{{ $subscriptionsCount }}</span>
                <span class="stat-label">Abonnements</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-info">
                <span class="stat-value">{{ $readArticlesCount }}</span>
                <span class="stat-label">Articles Lus</span>
            </div>
        </div>
    </div>

    <div class="recent-activity">
        <h2>Activité Récente</h2>
        <div class="activity-list">
            @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon">📖</div>
                    <div class="activity-content">
                        <h4>{{ $activity->article->titre }}</h4>
                        <p>Lu le {{ $activity->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="no-activity">Aucune activité récente</p>
            @endforelse
        </div>
    </div>
</div>
@endsection 