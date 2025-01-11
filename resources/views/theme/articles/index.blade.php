@extends('layouts.app')

@section('title', 'Gestion des Articles')

@section('styles')
<style>
    .articles-container {
        padding: 2rem;
    }

    .articles-header {
        margin-bottom: 2rem;
    }

    .articles-grid {
        display: grid;
        gap: 1.5rem;
    }

    .article-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .article-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .article-title {
        font-size: 1.25rem;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .article-meta {
        font-size: 0.875rem;
        color: #718096;
    }

    .article-status {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-En-cours {
        background: #fef3c7;
        color: #92400e;
    }

    .status-Publié {
        background: #dcfce7;
        color: #166534;
    }

    .status-Refusé {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-Retenu {
        background: #e9d5ff;
        color: #6b21a8;
    }

    .article-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .pagination {
        margin-top: 2rem;
    }
</style>
@endsection

@section('content')
<div class="articles-container">
    <form id="token-form">
        @csrf
    </form>
    <div class="articles-header">
        <h1>Gestion des Articles</h1>
    </div>

    <div class="articles-grid">
        @forelse($articles as $article)
            <div class="article-card">
                <div class="article-header">
                    <div>
                        <h2 class="article-title">{{ $article->titre }}</h2>
                        <div class="article-meta">
                            <span>Par {{ $article->auteur->nom }}</span>
                            <span>•</span>
                            <span>{{ $article->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <span class="article-status status-{{ $article->statut }}">
                        {{ $article->statut }}
                    </span>
                </div>

                <div class="article-actions">
                    <a href="{{ route('theme.articles.show', $article) }}" class="btn btn-primary">
                        Voir l'article
                    </a>
                    @if($article->statut === 'En cours' || $article->statut === 'Publié')
                        <button 
                            onclick="proposeToEditor({{ $article->id }})" 
                            class="btn btn-primary">
                            Proposer à l'éditeur
                        </button>
                    @endif
                    @if($article->statut === 'En cours')
                        <button 
                            onclick="rejectArticle({{ $article->id }})" 
                            class="btn btn-danger">
                            Rejeter
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Aucun article à afficher</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $articles->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
function proposeToEditor(articleId) {
    if (!confirm('Voulez-vous vraiment proposer cet article à l\'éditeur ?')) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/theme/articles/${articleId}/propose`, {
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

function rejectArticle(articleId) {
    const motif = prompt('Motif du rejet :');
    if (!motif) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/theme/articles/${articleId}/reject`, {
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