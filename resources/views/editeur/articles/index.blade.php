@extends('layouts.app')

@section('title', 'Gestion des Articles')

@section('styles')
<style>
.articles-container {
    padding: 2rem;
}

.status-section {
    margin-bottom: 2rem;
}

.status-header {
    background: #f3f4f6;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.article-card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.article-header {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.article-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.article-meta {
    font-size: 0.875rem;
    color: #6b7280;
}

.article-content {
    padding: 1rem;
}

.article-actions {
    padding: 1rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-propose { background: #FEF3C7; color: #92400E; }
.status-publie { background: #DEF7EC; color: #03543F; }
.status-refuse { background: #FDE8E8; color: #9B1C1C; }
.status-desactive { background: #E5E7EB; color: #374151; }

/* Styles pour les modals */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1001;
    width: 90%;
    max-width: 500px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    color: #666;
}

.modal-body {
    margin-bottom: 20px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.article-info {
    margin-bottom: 15px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
}

.article-title {
    margin: 0 0 5px 0;
    font-size: 1rem;
}

.text-muted {
    color: #6c757d;
    font-size: 0.875rem;
}
</style>
@endsection

@section('content')
<div class="articles-container">
    @foreach($articles as $statut => $articlesGroup)
        <div class="status-section">
            <div class="status-header">
                <h2>Articles {{ $statut }} ({{ $articlesGroup->count() }})</h2>
            </div>
            <div class="articles-grid">
                @foreach($articlesGroup as $article)
                    <div class="article-card">
                        <div class="article-header">
                            <span class="status-badge status-{{ strtolower($article->statut) }}">
                                {{ $article->statut }}
                            </span>
                            <h3 class="article-title">{{ $article->titre }}</h3>
                            <div class="article-meta">
                                <span>Par {{ $article->auteur->nom }}</span>
                                <span>•</span>
                                <span>{{ $article->theme->nom_theme }}</span>
                            </div>
                        </div>

                        <div class="article-content">
                            <p>{{ Str::limit($article->contenu, 150) }}</p>
                            @if($article->numero)
                                <div class="numero-info">
                                    <strong>Numéro:</strong> {{ $article->numero->titre_numero }}
                                </div>
                            @endif
                        </div>

                        <div class="article-actions">
                            @switch($article->statut)
                                @case('Retenu')
                                    @if(!$article->numero_id)
                                        <button type="button" 
                                                class="btn btn-primary"
                                                onclick="showAssignModal(
                                                    {{ $article->id }}, 
                                                    '{{ $article->titre }}', 
                                                    '{{ $article->theme->nom_theme }}'
                                                )">
                                            Affecter à un numéro
                                        </button>
                                    @endif
                                    @break

                                @case('Publié')
                                    <form action="{{ route('editeur.articles.toggle-status', $article) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Désactiver</button>
                                    </form>
                                    @break

                                @case('Désactivé')
                                    <form action="{{ route('editeur.articles.toggle-status', $article) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Activer</button>
                                    </form>
                                    @break
                            @endswitch

                            <form action="{{ route('editeur.articles.destroy', $article) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<!-- Modal Rejet -->
<div class="modal-overlay" id="rejectModalOverlay"></div>
<div class="modal" id="rejectModal">
    <div class="modal-header">
        <h5 class="modal-title">Motif du rejet</h5>
        <button type="button" class="modal-close" onclick="closeModal('rejectModal')">&times;</button>
    </div>
    <form id="rejectForm" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="motif_rejet">Motif</label>
                <textarea name="motif_rejet" id="motif_rejet" 
                        class="form-control" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('rejectModal')">Annuler</button>
            <button type="submit" class="btn btn-danger">Rejeter</button>
        </div>
    </form>
</div>

<!-- Modal Affectation -->
<div class="modal-overlay" id="assignModalOverlay"></div>
<div class="modal" id="assignModal">
    <div class="modal-header">
        <h5 class="modal-title">Publier dans un numéro</h5>
        <button type="button" class="modal-close" onclick="closeModal('assignModal')">&times;</button>
    </div>
    <form id="assignForm" method="POST">
        @csrf
        <div class="modal-body">
            <div class="article-info">
                <h6 class="article-title" id="modalArticleTitle"></h6>
                <small class="text-muted" id="modalArticleTheme"></small>
            </div>
            <p class="text-info mb-3">
                L'article sera automatiquement publié une fois affecté à un numéro.
            </p>
            <div class="form-group">
                <label for="numero_id">Choisir un numéro</label>
                <select name="numero_id" id="numero_id" class="form-control" required>
                    <option value="">Sélectionner un numéro</option>
                    @foreach($numeros as $numero)
                        <option value="{{ $numero->id }}">
                            {{ $numero->titre_numero }} 
                            ({{ $numero->articles->count() }} articles)
                        </option>
                    @endforeach
                </select>
                @if($numeros->isEmpty())
                    <small class="text-danger">
                        Aucun numéro disponible. Veuillez d'abord créer un numéro.
                    </small>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('assignModal')">Annuler</button>
            <button type="submit" class="btn btn-primary">Publier dans ce numéro</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function showModal(modalId) {
    document.getElementById(modalId + 'Overlay').style.display = 'block';
    document.getElementById(modalId).style.display = 'block';
    document.body.style.overflow = 'hidden'; // Empêcher le défilement
}

function closeModal(modalId) {
    document.getElementById(modalId + 'Overlay').style.display = 'none';
    document.getElementById(modalId).style.display = 'none';
    document.body.style.overflow = ''; // Réactiver le défilement
}

function showRejectModal(articleId) {
    const form = document.getElementById('rejectForm');
    form.action = `/editeur/articles/${articleId}/reject`;
    showModal('rejectModal');
}

function showAssignModal(articleId, titre, theme) {
    const form = document.getElementById('assignForm');
    form.action = `/editeur/articles/${articleId}/assign`;
    
    // Mettre à jour les informations de l'article dans le modal
    document.getElementById('modalArticleTitle').textContent = titre;
    document.getElementById('modalArticleTheme').textContent = theme;
    
    // Vérifier s'il y a des numéros disponibles
    const select = document.getElementById('numero_id');
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = select.options.length <= 1;
    
    showModal('assignModal');
}

// Fermer le modal en cliquant sur l'overlay
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', () => {
        const modalId = overlay.id.replace('Overlay', '');
        closeModal(modalId);
    });
});

// Empêcher la fermeture lors du clic sur le modal lui-même
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', (e) => {
        e.stopPropagation();
    });
});

// Fermer avec la touche Echap
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => {
            if (modal.style.display === 'block') {
                const modalId = modal.id;
                closeModal(modalId);
            }
        });
    }
});
</script>
@endsection 