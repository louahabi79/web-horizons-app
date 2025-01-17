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
                        <span>{{ $theme->articles_count }} articles</span>
                        <span>{{ $theme->subscribers_count }} abonnés</span>
                    </div>
                </div>
                <div class="theme-actions">
                    @if(in_array($theme->id, $subscribedThemeIds))
                        <button 
                            class="btn btn-danger unsubscribe-btn" 
                            data-theme-id="{{ $theme->id }}"
                            onclick="unsubscribeFromTheme({{ $theme->id }})"
                        >
                            Se désabonner
                        </button>
                    @else
                        <button 
                            class="btn btn-primary subscribe-btn" 
                            data-theme-id="{{ $theme->id }}"
                            onclick="subscribeToTheme({{ $theme->id }})"
                        >
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
function subscribeToTheme(themeId) {
    fetch(`/member/memberships/${themeId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mettre à jour l'interface sans recharger la page
            const button = document.querySelector(`[data-theme-id="${themeId}"]`);
            button.classList.remove('btn-primary', 'subscribe-btn');
            button.classList.add('btn-danger', 'unsubscribe-btn');
            button.textContent = 'Se désabonner';
            button.onclick = () => unsubscribeFromTheme(themeId);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue lors de l\'abonnement');
    });
}

function unsubscribeFromTheme(themeId) {
    
        fetch(`/member/memberships/${themeId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'interface sans recharger la page
                const button = document.querySelector(`[data-theme-id="${themeId}"]`);
                button.classList.remove('btn-danger', 'unsubscribe-btn');
                button.classList.add('btn-primary', 'subscribe-btn');
                button.textContent = 'S\'abonner';
                button.onclick = () => subscribeToTheme(themeId);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors du désabonnement');
        });
    }

</script>
@endsection 