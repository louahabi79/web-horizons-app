@extends('layouts.editor')

@section('title', isset($numero) ? 'Modifier le numéro - Éditeur' : 'Nouveau numéro - Éditeur')

@section('styles')
<link href="{{ asset('css/editor/issues-form.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1>{{ isset($numero) ? 'Modifier le numéro' : 'Nouveau numéro' }}</h1>
        <a href="{{ route('editor.issues.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Retour
        </a>
    </div>

    <form action="{{ isset($numero) ? route('editor.issues.update', $numero) : route('editor.issues.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="issue-form">
        @csrf
        @if(isset($numero))
            @method('PUT')
        @endif

        <div class="form-grid">
            <div class="form-section">
                <h2>Informations générales</h2>
                
                <div class="form-group">
                    <label for="titre_numero">Titre du numéro</label>
                    <input type="text" 
                           id="titre_numero" 
                           name="titre_numero" 
                           value="{{ old('titre_numero', $numero->titre_numero ?? '') }}" 
                           required>
                    @error('titre_numero')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="numero_edition">Numéro d'édition</label>
                    <input type="number" 
                           id="numero_edition" 
                           name="numero_edition" 
                           value="{{ old('numero_edition', $numero->numero_edition ?? '') }}" 
                           required>
                    @error('numero_edition')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="theme_central">Thème central</label>
                    <input type="text" 
                           id="theme_central" 
                           name="theme_central" 
                           value="{{ old('theme_central', $numero->theme_central ?? '') }}">
                    @error('theme_central')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h2>Détails et publication</h2>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" 
                              name="description" 
                              rows="4">{{ old('description', $numero->description ?? '') }}</textarea>
                    @error('description')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_publication">Date de publication</label>
                    <input type="date" 
                           id="date_publication" 
                           name="date_publication" 
                           value="{{ old('date_publication', isset($numero) ? $numero->date_publication->format('Y-m-d') : '') }}" 
                           required>
                    @error('date_publication')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="visibilite">Visibilité</label>
                    <select id="visibilite" name="visibilite" required>
                        <option value="Public" {{ old('visibilite', $numero->visibilite ?? '') == 'Public' ? 'selected' : '' }}>Public</option>
                        <option value="Privé" {{ old('visibilite', $numero->visibilite ?? '') == 'Privé' ? 'selected' : '' }}>Privé</option>
                    </select>
                    @error('visibilite')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h2>Image de couverture</h2>
                
                <div class="form-group">
                    <label for="image_couverture">Image</label>
                    <div class="image-upload-container">
                        @if(isset($numero) && $numero->image_couverture)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $numero->image_couverture) }}" alt="Couverture actuelle">
                                <span>Image actuelle</span>
                            </div>
                        @endif
                        <input type="file" 
                               id="image_couverture" 
                               name="image_couverture" 
                               accept="image/*">
                        <div class="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Glissez une image ou cliquez pour sélectionner</span>
                        </div>
                    </div>
                    @error('image_couverture')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                {{ isset($numero) ? 'Mettre à jour' : 'Créer le numéro' }}
            </button>
            <a href="{{ route('editor.issues.index') }}" class="btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection 