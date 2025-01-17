@extends('layouts.member')

@section('title', 'Articles - Tech Magazine')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/member/submissions.css') }}">
@endsection

@section('page-title', 'Mes Soumissions')
@section('content')
<div class="submissions-container">
    <header class="submissions-header">
        <!-- <h1>Mes Soumissions</h1> -->
         <h1></h1>
        
        <div class="header-actions">
                    <a href="{{ route('member.submit') }}" class="btn-primary">
                    <span class="icon">✏️</span>
                        Soumettre un Article
                    </a>
        </div>
    </header>

    <div class="status-tabs">
        <button class="tab-btn active" data-status="all">Tous</button>
        <button class="tab-btn" data-status="En cours">En cours</button>
        <button class="tab-btn" data-status="Publié">Publiés</button>
        <button class="tab-btn" data-status="Refusé">Refusés</button>
    </div>

    <div class="submissions-grid">
        @forelse($propositions as $status => $articles)
            <div class="status-section" data-status="{{ $status }}">
                <h2>{{ $status }}</h2>
                <div class="articles-list">
                    @foreach($articles as $article)
                        <div class="article-card" data-article-id="{{ $article->id }}">
                            <div class="article-header">
                                <h3>{{ $article->titre }}</h3>
                                <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                            </div>
                            <div class="article-meta">
                                <span>Soumis le {{ $article->date_proposition->format('d/m/Y') }}</span>
                                @if($article->date_publication)
                                    <span>Publié le {{ $article->date_publication->format('d/m/Y') }}</span>
                                @endif
                            </div>
                            @if($article->motif_rejet)
                                <div class="rejection-reason">
                                    <strong>Motif du rejet:</strong>
                                    <p>{{ $article->motif_rejet }}</p>
                                </div>
                            @endif
                            <div class="article-actions">
                                <a href="{{ route('member.articles.show', $article) }}" class="btn btn-secondary">
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
            </div>
        @empty
            <div class="no-submissions">
                <p>Vous n'avez pas encore soumis d'articles.</p>
                <a href="{{ route('member.submit') }}" class="btn-primary">
                    Soumettre votre premier article
                </a>
            </div>
        @endforelse
    </div>
</div>

@endsection

@section('scripts')
<script>

    // Delete article function
    function retirerArticle(articleId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')) {
        fetch(`/member/submissions/${articleId}`, {
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







document.addEventListener('DOMContentLoaded', function() {
    // Tab switching logic
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