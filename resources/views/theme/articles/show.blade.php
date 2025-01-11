@extends('layouts.app')

@section('title', $article->titre)

@section('styles')
<style>
    .article-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .article-header {
        margin-bottom: 2rem;
    }

    .article-title {
        font-size: 2rem;
        color: #1a202c;
        margin-bottom: 1rem;
    }

    .article-meta {
        display: flex;
        gap: 1rem;
        color: #718096;
        font-size: 0.875rem;
    }

    .article-status {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .article-content {
        line-height: 1.8;
        color: #2d3748;
    }

    .article-actions {
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        height: 38px;
        line-height: 1.2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-success {
        background: #059669;
        color: white;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .article-actions form {
        display: inline-flex;
        margin: 0;
    }

    .comments-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .comments-header {
        margin-bottom: 1.5rem;
    }

    .comment-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }

    .comment-author {
        font-weight: 500;
        color: #2d3748;
    }

    .comment-date {
        font-size: 0.875rem;
        color: #718096;
    }

    .comment-content {
        color: #4a5568;
        margin-bottom: 1rem;
    }

    .comment-actions {
        display: flex;
        justify-content: flex-end;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .btn-delete:hover {
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<div class="article-container">
    <form id="token-form">
        @csrf
    </form>
    <div class="article-header">
        <span class="article-status status-{{ $article->statut }}">
            {{ $article->statut }}
        </span>
        <h1 class="article-title">{{ $article->titre }}</h1>
        <div class="article-meta">
            <span>Par {{ $article->auteur->nom }}</span>
            <span>•</span>
            <span>{{ $article->created_at->format('d/m/Y') }}</span>
            <span>•</span>
            <span>{{ $article->temps_lecture }} min de lecture</span>
        </div>
    </div>

    <div class="article-content">
        {!! nl2br(e($article->contenu)) !!}
    </div>

    @if($article->statut === 'En cours')
        <div class="article-actions">
            <form action="{{ route('theme.articles.accept', $article) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success"
                    onclick="return confirm('Voulez-vous vraiment accepter cet article ?')">
                    Accepter
                </button>
            </form>

            <form action="{{ route('theme.articles.reject', $article) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="motif_rejet" id="motif_rejet">
                <button type="button" class="btn btn-danger" onclick="rejectArticle()">
                    Rejeter
                </button>
            </form>
        </div>
    @endif

    @if($article->statut === 'En cours' || $article->statut === 'Publié')
        <div class="article-actions">
            <form action="{{ route('theme.articles.propose', $article) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary"
                    onclick="return confirm('Voulez-vous vraiment proposer cet article à l\'éditeur ?')">
                    Proposer à l'éditeur
                </button>
            </form>
        </div>
    @endif

    <div class="comments-section">
        <div class="comments-header">
            <h2>Commentaires ({{ $article->conversations->count() }})</h2>
        </div>

        @forelse($article->conversations as $comment)
            <div class="comment-card">
                <div class="comment-header">
                    <span class="comment-author">{{ $comment->user->nom }}</span>
                    <span class="comment-date">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="comment-content">
                    {{ $comment->message }}
                </div>
                <div class="comment-actions">
                    <form action="{{ route('theme.moderation.delete', $comment) }}" 
                          method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p>Aucun commentaire pour cet article.</p>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
function rejectArticle() {
    const motif = prompt('Motif du rejet :');
    if (motif) {
        document.getElementById('motif_rejet').value = motif;
        document.getElementById('motif_rejet').closest('form').submit();
    }
}
</script>
@endsection 