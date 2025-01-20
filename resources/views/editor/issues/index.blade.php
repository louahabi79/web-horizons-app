@extends('layouts.editor')

@section('title', 'Gestion des Numéros - Éditeur')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/editor/issues.css') }}">
@endsection

@section('page-title', 'Gestion des Numéros')

@section('header-actions')
<a href="{{ route('editor.issues.create') }}" class="btn-create">
    <span class="icon">➕</span>
    Nouveau Numéro
</a>
@endsection

@section('content')
<div class="issues-container">
    <div class="issues-grid">
        @forelse($numeros as $numero)
            <div class="issue-card">
                <div class="issue-image">
                    @if($numero->image_couverture)
                        <img src="{{ asset('storage/' . $numero->image_couverture) }}" alt="{{ $numero->titre_numero }}">
                    @else
                        <div class="placeholder-image">
                            <span>{{ $numero->numero_edition }}</span>
                        </div>
                    @endif
                    <div class="issue-status {{ $numero->is_published ? 'published' : '' }}">
                        {{ $numero->is_published ? 'Publié' : 'Non publié' }}
                    </div>
                </div>

                <div class="issue-content">
                    <div class="issue-header">
                        <h3>{{ $numero->titre_numero }}</h3>
                        <span class="edition-number">N°{{ $numero->numero_edition }}</span>
                    </div>

                    <div class="issue-meta">
                        <div class="meta-item">
                            <span class="label">Articles</span>
                            <span class="value">{{ $numero->articles->count() }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="label">Date de publication</span>
                            <span class="value">{{ $numero->date_publication->format('d/m/Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="label">Visibilité</span>
                            <span class="value">{{ $numero->visibilite }}</span>
                        </div>
                    </div>

                    <div class="issue-actions">
                        <div class="primary-actions">
                            <a href="{{ route('editor.issues.edit', $numero) }}" class="btn-edit">
                                Modifier
                            </a>
                            @if(!$numero->is_published)
                                <form action="{{ route('editor.issues.publish', $numero) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-publish">Publier</button>
                                </form>
                            @else
                                <form action="{{ route('editor.issues.unpublish', $numero) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-unpublish">Dépublier</button>
                                </form>
                            @endif
                        </div>

                        <div class="secondary-actions">
                            <form action="{{ route('editor.issues.toggle-visibility', $numero) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-visibility">
                                    {{ $numero->visibilite === 'Public' ? 'Rendre privé' : 'Rendre public' }}
                                </button>
                            </form>

                            @if($numero->articles->isEmpty())
                                <form action="{{ route('editor.issues.destroy', $numero) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce numéro ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-issues">
                <p>Aucun numéro trouvé</p>
                <a href="{{ route('editor.issues.create') }}" class="btn-create">Créer un numéro</a>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $numeros->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 