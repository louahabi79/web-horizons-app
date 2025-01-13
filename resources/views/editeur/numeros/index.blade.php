@extends('layouts.app')

@section('title', 'Gestion des Numéros')

@section('styles')
<style>
.numeros-container {
    padding: 2rem;
}

.actions-header {
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.numero-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.numero-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.numero-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.numero-content {
    padding: 1.5rem;
}

.numero-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.numero-meta {
    font-size: 0.875rem;
    color: #666;
    margin-bottom: 1rem;
}

.numero-description {
    margin-bottom: 1rem;
    color: #444;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.status-brouillon { background: #FEF3C7; color: #92400E; }
.status-publie { background: #DEF7EC; color: #03543F; }
.status-desactive { background: #FDE8E8; color: #9B1C1C; }

.visibility-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-left: 0.5rem;
}

.visibility-public { background: #E1EFFE; color: #1E429F; }
.visibility-prive { background: #F3E8FF; color: #5B21B6; }

.numero-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
    align-items: stretch;
}

.numero-actions form {
    display: inline-flex;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    cursor: pointer;
    border: none;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    /* min-width: 100px; */
}

.btn-primary {
    background: #3B82F6;
    color: white;
}

.btn-secondary {
    background: #6B7280;
    color: white;
    text-decoration: none;
}

.btn-secondary:hover {
    color: white;
    text-decoration: none;
    background: #6B7280;
}

.btn-success {
    background: #059669;
    color: white;
}

.btn-danger {
    background: #DC2626;
    color: white;
}

.btn-warning {
    background: #F59E0B;
    color: white;
}

.btn-public {
    background: #3B82F6;
    color: white;
    height: 100%;
}



.btn-private {
    background: #6B7280;
    color: white;
    height: 100%;
}

.status-publie { background: #DEF7EC; color: #03543F; }
.status-non-publie { background: #FEF3C7; color: #92400E; }
</style>
@endsection

@section('content')
<div class="page-container numeros-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="actions-header">
        <h1>Gestion des Numéros</h1>
        <a href="{{ route('editeur.numeros.create') }}" class="btn btn-primary">
            Créer un nouveau numéro
        </a>
    </div>

    <div class="numero-grid">
        @forelse($numeros as $numero)
            <div class="numero-card">
                @if($numero->image_couverture)
                    <img src="{{ asset('storage/' . $numero->image_couverture) }}" 
                         alt="Couverture {{ $numero->titre_numero }}"
                         class="numero-image">
                @endif
                
                <div class="numero-content">
                    <h2 class="numero-title">{{ $numero->titre_numero }}</h2>
                    
                    <div class="numero-meta">
                        <span>Édition #{{ $numero->numero_edition }}</span>
                        <span>•</span>
                        <span>{{ $numero->date_publication }}</span>
                    </div>

                    <div class="status-container">
                        <div class="publication-status">
                            <span class="status-badge {{ $numero->is_published ? 'status-publie' : 'status-non-publie' }}">
                                {{ $numero->is_published ? 'Publié' : 'Non publié' }}
                            </span>
                            <span class="visibility-badge visibility-{{ strtolower($numero->visibilite) }}">
                                {{ $numero->visibilite }}
                            </span>
                        </div>
                        
                    </div>

                    <p class="numero-description">{{ Str::limit($numero->description, 100) }}</p>

                    <div>
                        <strong>Thème central :</strong> {{ $numero->theme_central }}
                    </div>

                    <div class="numero-stats">
                        <strong>Articles :</strong> {{ $numero->totalArticles() }}
                        ({{ $numero->publishedArticles()->count() }} publiés)
                    </div>

                    <div class="numero-actions">
                        <a href="{{ route('editeur.numeros.edit', $numero) }}" 
                           class="btn btn-secondary">Modifier</a>
                        
                        <form action="{{ $numero->is_published ? route('editeur.numeros.unpublish', $numero) : route('editeur.numeros.publish', $numero) }}" 
                              method="POST" 
                              style="display: inline;">
                            @csrf
                            <button type="submit" class="btn {{ $numero->is_published ? 'btn-warning' : 'btn-success' }}">
                                {{ $numero->is_published ? 'Dépublier' : 'Publier' }}
                            </button>
                        </form>

                        <form action="{{ route('editeur.numeros.toggleVisibility', $numero) }}" 
                              method="POST" 
                              style="display: inline;">
                            @csrf
                            <button type="submit" class="btn {{ $numero->visibilite === 'Public' ? 'btn-private' : 'btn-public' }}">
                                {{ $numero->visibilite === 'Public' ? 'Rendre Privé' : 'Rendre Public' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Aucun numéro disponible.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $numeros->links() }}
    </div>
</div>
@endsection 