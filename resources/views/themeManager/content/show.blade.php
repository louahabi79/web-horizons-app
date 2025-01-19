@extends('layouts.themeManager')

@section('title', $article->titre . ' - Theme Manager')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/themeManager/content-detail.css') }}">
@endsection

@section('page-title', 'Détail de l\'article')

@section('content')
<div class="article-detail-container">
    <div class="article-actions-header">
        <a href="{{ route('theme-manager.content.index') }}" class="btn-back">
            <span class="icon">←</span>
            Retour à la liste
        </a>

        <div class="action-buttons">
            @if($article->statut === 'En cours')
                <form action="{{ route('theme-manager.content.accept', $article) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-approve">Approuver</button>
                </form>
                <button type="button" class="btn-reject" onclick="showRejectModal()">
                    Refuser
                </button>
                <form action="{{ route('theme-manager.content.propose', $article) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-approve">Proposer à l'éditeur</button>
                </form>
            @endif
            @if($article->statut === 'Publié')
                <form action="{{ route('theme-manager.content.propose', $article) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-approve">Proposer à l'éditeur</button>
                </form>
            @endif
           
        </div>
    </div>

    <div class="article-detail">
        <div class="article-header">
            <div class="article-meta">
                <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                <span class="status-badge {{ $article->statut }}">{{ $article->statut }}</span>
               
            </div>
            <h1>{{ $article->titre }}</h1>
            <div class="author-info">
                <div class="author">
                    <span class="label">Auteur</span>
                    <span class="value">{{ $article->auteur->nom }}</span>
                </div>
                <div class="submission-date">
                    <span class="label">Soumis le</span>
                    <span class="value">{{ $article->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="views">
                    <span class="label">Vues</span>
                    <span class="value">{{ $article->vues }}</span>
                </div>
            </div>
        </div>

        @if($article->image_couverture)
            <div class="article-cover">
                <img src="{{ asset('storage/' . $article->image_couverture) }}" 
                     alt="Image de couverture"
                     style="width: 100%; height: auto;">
            </div>
        @endif

        <div class="article-content">
            {!! nl2br(e($article->contenu)) !!}
        </div>

        @if($article->statut === 'Refusé')
            <div class="rejection-info">
                <h3>Motif du rejet</h3>
                <p>{{ $article->motif_rejet }}</p>
                <div class="rejection-meta">
                    <span>Refusé le {{ $article->date_rejet->format('d/m/Y') }}</span>
                </div>
            </div>
        @endif
    </div>

    <div class="conversations-section">
       <h2>Conversations</h2>
       
       <form action="{{ route('theme-manager.moderation.comment', $article) }}" method="POST" class="comment-form">
           @csrf
           <div class="form-group">
               <label for="message">Votre commentaire</label>
               <textarea name="message" id="message" rows="3" required class="form-control"></textarea>
           </div>
           <button type="submit" class="btn-submit">Envoyer</button>
       </form>

       <div class="conversations-list">
           @forelse($article->conversations as $message)
               <div class="conversation-item">
                   <div class="message-header">
                       <div class="message-info">
                           <span class="author">{{ $message->user->nom }}</span>
                           <span class="date">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                       </div>
                       @if(Auth::user()->role === 'Responsable de thème')
                           <form action="{{ route('theme-manager.moderation.delete-message', $message) }}" 
                                 method="POST" 
                                 class="delete-form"
                                 onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn-delete">
                                   <span class="icon">🗑️</span>
                               </button>
                           </form>
                       @endif
                   </div>
                   <div class="message-content">
                       {{ $message->message }}
                   </div>
               </div>
           @empty
               <p class="no-conversations">Aucune conversation pour le moment</p>
           @endforelse
       </div>
   </div>
</div>

<!-- Modal de rejet -->
<div id="rejectModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Motif du rejet</h2>
        <form action="{{ route('theme-manager.content.reject', $article) }}" method="POST">
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
function showRejectModal() {
    document.getElementById('rejectModal').style.display = 'flex';
}

function hideRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
</script>
@endsection 