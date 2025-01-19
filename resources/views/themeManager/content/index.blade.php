@extends('layouts.themeManager')

@section('title', 'Articles à Modérer - Theme Manager')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/themeManager/content.css') }}">
@endsection

@section('page-title', 'Articles à Modérer')

@section('content')
<div class="content-container">
    <div class="filters-section">
        <form action="{{ route('theme-manager.content.index') }}" method="GET" class="filters-form">
            <div class="filter-group">
                <label for="status">Statut</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Tous les statuts</option>
                    <option value="En cours" {{ request('status') == 'En cours' ? 'selected' : '' }}>En attente</option>
                    <option value="Publié" {{ request('status') == 'Publié' ? 'selected' : '' }}>Publié</option>
                    <option value="Refusé" {{ request('status') == 'Refusé' ? 'selected' : '' }}>Refusé</option>
                    <option value="Retenu" {{ request('status') == 'Retenu' ? 'selected' : '' }}>Retenu</option>
                </select>
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

            <div class="filter-actions">
                <button type="submit" class="btn-filter">Filtrer</button>
                <a href="{{ route('theme-manager.content.index') }}" class="btn-reset">Réinitialiser</a>
            </div>
        </form>
    </div>

    <div class="articles-grid">
        @forelse($articles as $article)
            <div class="article-card">
                @if($article->image_couverture)
                    <div class="article-image">
                        <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="{{ $article->titre }}" >
                    </div>
                @endif
                
                <div class="article-content">
                    <div class="article-header">
                        <h3>{{ $article->titre }}</h3>
                        <span class="status-badge {{ $article->statut }}">{{ $article->statut }}</span>
                    </div>
                    
                    <div class="article-meta">
                        <span>Par {{ $article->auteur->nom }}</span>
                        <span>Soumis le {{ $article->created_at->format('d/m/Y') }}</span>
                    </div>
                    
                    <p class="article-excerpt">
                        {{ Str::limit($article->contenu, 20) }}
                    </p>

                    <div class="article-actions">
                        <a href="{{ route('theme-manager.content.show', $article) }}" class="btn-review">
                            Examiner
                        </a>
                        @if($article->statut === 'Publié')
                            <form action="{{ route('theme-manager.content.propose', $article) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-propose">Proposer à l'éditeur</button>
                            </form>
                        @endif
                        @if($article->statut === 'En cours')
                            <div class="quick-actions">
                                <form action="{{ route('theme-manager.content.accept', $article) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-approve">Approuver</button>
                                </form>
                                <button type="button" class="btn-reject" onclick="showRejectModal('{{ $article->id }}')">
                                    Refuser
                                </button>
                            </div>
                            <form action="{{ route('theme-manager.content.propose', $article) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-propose">Proposer à l'éditeur</button>
                            </form>
                        @endif
                        
                    </div>
                </div>
            </div>
        @empty
            <div class="no-articles">
                <p>Aucun article trouvé</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $articles->links('vendor.pagination.custom') }}
    </div>
</div>

<!-- Modal de rejet -->
<div id="rejectModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Motif du rejet</h2>
        <form id="rejectForm" action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="motif_rejet">Expliquez pourquoi l'article est refusé :</label>
                <textarea name="motif_rejet" id="motif_rejet" rows="4" required></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" onclick="hideRejectModal()" class="btn-cancel">Annuler</button>
                <button type="submit" class="btn-confirm">Confirmer le rejet</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showRejectModal(articleId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `{{ route('theme-manager.content.reject', '') }}/${articleId}`;
    modal.style.display = 'flex';
}

function hideRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
</script>
@endsection 