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
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
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

    @if($article->statut === 'En cours' || $article->statut === 'Publié')
        <div class="article-actions">
            <button onclick="proposeToEditor()" class="btn btn-primary">
                Proposer à l'éditeur
            </button>
            @if($article->statut === 'En cours')
                <button onclick="rejectArticle()" class="btn btn-danger">
                    Rejeter l'article
                </button>
            @endif
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function proposeToEditor() {
    if (!confirm('Voulez-vous vraiment proposer cet article à l\'éditeur ?')) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ route("theme.articles.propose", $article) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue lors de la communication avec le serveur');
    });
}

function rejectArticle() {
    const motif = prompt('Motif du rejet :');
    if (!motif) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ route("theme.articles.reject", $article) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify({ motif_rejet: motif })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue lors de la communication avec le serveur');
    });
}
</script>
@endsection 