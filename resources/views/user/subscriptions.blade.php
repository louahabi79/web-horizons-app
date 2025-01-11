@extends('layouts.app')

@section('title', 'Mes Abonnements - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/user/subscriptions.css') }}">
@endsection

@section('content')
<div class="subscriptions-wrapper">
    <div class="subscriptions-header">
        <h1>Mes Abonnements</h1>
        <p>Gérez vos abonnements aux différents thèmes</p>
    </div>

    <div class="themes-grid">
        @foreach($themes as $theme)
            <div class="theme-card">
                <div class="theme-content">
                    <h3>{{ $theme->nom_theme }}</h3>
                    <p>{{ $theme->description }}</p>
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
    fetch(`/user/themes/${themeId}/subscribe`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
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

function unsubscribeFromTheme(themeId) {
    if (confirm('Êtes-vous sûr de vouloir vous désabonner de ce thème ?')) {
        fetch(`/user/themes/${themeId}/unsubscribe`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
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