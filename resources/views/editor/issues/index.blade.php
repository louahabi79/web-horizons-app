@extends('layouts.editor')

@section('title', 'Gestion des Numéros - Éditeur')

@section('styles')
<link href="{{ asset('css/editor/issues.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="issues-container">
    <div class="issues-header">
        <h1>Gestion des Numéros</h1>
        <div class="header-actions">
            <a href="{{ route('editor.issues.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i>
                Nouveau numéro
            </a>
        </div>
    </div>

    <div class="issues-grid">
        @forelse($numeros as $numero)
            <div class="issue-card">
                <div class="issue-cover">
                    @if($numero->image_couverture)
                        <img src="{{ asset('storage/' . $numero->image_couverture) }}" alt="Couverture {{ $numero->titre_numero }}">
                    @else
                        <div class="placeholder-cover">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                    <div class="issue-status">
                        <span class="status-badge {{ $numero->is_published ? 'status-published' : 'status-draft' }}">
                            {{ $numero->is_published ? 'Publié' : 'Brouillon' }}
                        </span>
                        <span class="visibility-badge {{ $numero->visibilite === 'Public' ? 'visibility-public' : 'visibility-private' }}">
                            <i class="fas {{ $numero->visibilite === 'Public' ? 'fa-globe' : 'fa-lock' }}"></i>
                            {{ $numero->visibilite }}
                        </span>
                    </div>
                </div>

                <div class="issue-content">
                    <div class="issue-header">
                        <h3 class="issue-title">{{ $numero->titre_numero }}</h3>
                        <span class="issue-number">#{{ $numero->numero_edition }}</span>
                    </div>
                    
                    <p class="issue-description">{{ Str::limit($numero->description, 120) }}</p>
                    
                    <div class="issue-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $numero->date_publication->format('d/m/Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-newspaper"></i>
                            <span>{{ $numero->articles->count() }} articles</span>
                        </div>
                    </div>
                </div>

                <div class="issue-actions">
                    <a href="{{ route('editor.issues.edit', $numero) }}" class="btn-action">
                        <i class="fas fa-edit"></i>
                        Modifier
                    </a>
                    
                    @if(!$numero->is_published)
                        <form action="{{ route('editor.issues.publish', $numero) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn-action btn-success">
                                <i class="fas fa-check"></i>
                                Publier
                            </button>
                        </form>
                    @else
                        <form action="{{ route('editor.issues.unpublish', $numero) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn-action btn-warning">
                                <i class="fas fa-times"></i>
                                Dépublier
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('editor.issues.toggle-visibility', $numero) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-action btn-secondary">
                            <i class="fas {{ $numero->visibilite === 'Public' ? 'fa-lock' : 'fa-globe' }}"></i>
                            {{ $numero->visibilite === 'Public' ? 'Rendre privé' : 'Rendre public' }}
                        </button>
                    </form>

                    @if($numero->articles->isEmpty())
                        <form action="{{ route('editor.issues.destroy', $numero) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce numéro ?')">
                                <i class="fas fa-trash"></i>
                                Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-book"></i>
                <h3>Aucun numéro</h3>
                <p>Commencez par créer votre premier numéro</p>
                <a href="{{ route('editor.issues.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Créer un numéro
                </a>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $numeros->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 