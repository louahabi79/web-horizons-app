@extends('layouts.app')

@section('title', 'Mes Articles Proposés - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/propositions.css') }}">
@endsection

@section('content')
<div class="propositions-wrapper">
    <div class="propositions-header">
        <h1>Mes Articles Proposés</h1>
        <a href="{{ route('user.createPoste') }}" class="btn btn-primary">
            <span class="icon">✏️</span>
            Proposer un nouvel article
        </a>
    </div>

    <div class="status-tabs">
        <button class="tab-btn active" data-status="all">Tous</button>
        <button class="tab-btn" data-status="En cours">En cours</button>
        <button class="tab-btn" data-status="Retenu">Retenus</button>
        <button class="tab-btn" data-status="Refusé">Refusés</button>
        <button class="tab-btn" data-status="Publié">Publiés</button>
    </div>

    <div class="propositions-grid">
        @forelse($propositions as $statut => $articles)
            <div class="status-section" data-status="{{ $statut }}">
                @foreach($articles as $article)
                    <div class="proposition-card" data-article-id="{{ $article->id }}">
                        <div class="proposition-header">
                            <h3>{{ $article->titre }}</h3>
                            <span class="status-badge status-{{ strtolower($article->statut) }}">
                                {{ $article->statut }}
                            </span>
                        </div>
                        
                        <div class="proposition-meta">
                            <span>Thème: {{ $article->theme->nom_theme }}</span>
                            <span>Proposé le: {{ $article->date_proposition->format('d/m/Y') }}</span>
                        </div>

                        @if($article->feedback)
                            <div class="feedback-section">
                                <h4>Retour de l'éditeur:</h4>
                                <p>{{ $article->feedback }}</p>
                            </div>
                        @endif

                        <div class="proposition-actions">
                            <a href="{{ route('user.articles.show', $article) }}" class="btn btn-secondary">
                                Voir l'article
                            </a>
                            @if($article->user_id === Auth::id())
                                <button class="btn btn-danger" onclick="retirerArticle({{ $article->id }})">
                                    Supprimer
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="no-propositions">
                <p>Vous n'avez pas encore proposé d'articles.</p>
                <a href="{{ route('user.createPoste.form') }}" class="btn btn-primary">
                    Proposer votre premier article
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
function retirerArticle(articleId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')) {
        fetch(`/user/propositions/${articleId}`, {
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
                // Supprimer la carte de l'article du DOM
                document.querySelector(`[data-article-id="${articleId}"]`).remove();
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la suppression de l\'article');
        });
    }
}

// Gestion des onglets
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-btn');
    const sections = document.querySelectorAll('.status-section');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const status = tab.dataset.status;
            
            // Activer/désactiver les onglets
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            // Afficher/masquer les sections
            sections.forEach(section => {
                if (status === 'all' || section.dataset.status === status) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection