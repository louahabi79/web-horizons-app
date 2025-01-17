@extends('layouts.member')

@section('title', 'Mes Abonnements - Tech Magazine')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/member/memberships.css') }}">
@endsection

@section('page-title', 'Mes Abonnements')
@section('content')
<div class="memberships-container">
    <header class="memberships-header">
        <!-- <h1>Mes Abonnements</h1> -->
        <!-- <p class="subtitle">Gérez vos abonnements aux différents thèmes</p> -->
    </header>

    <div class="themes-grid">
        @foreach($themes as $theme)
            <div class="theme-card">
                <div class="theme-content">
                    <h2>{{ $theme->nom_theme }}</h2>
                    <p>{{ $theme->description }}</p>
                    
                    <div class="theme-meta">
                        <span class="articles-count">
                            {{ $theme->articles()->where('statut', 'Publié')->count() }} articles publiés
                        </span>
                    </div>
                </div>
                
                <div class="theme-actions">
                    @if(in_array($theme->id, $subscribedThemeIds))
                        <button onclick="toggleSubscription({{ $theme->id }}, false)" 
                                class="btn-unsubscribe">
                            Se désabonner
                        </button>
                    @else
                        <button onclick="toggleSubscription({{ $theme->id }}, true)" 
                                class="btn-subscribe">
                            S'abonner
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
<script>
function toggleSubscription(themeId, subscribe) {
    const method = subscribe ? 'POST' : 'DELETE';
    const message = subscribe ? 'abonner' : 'désabonner';
    
    if (confirm(`Êtes-vous sûr de vouloir vous ${message} de ce thème ?`)) {
        fetch(`/member/memberships/${themeId}`, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>
@endsection 