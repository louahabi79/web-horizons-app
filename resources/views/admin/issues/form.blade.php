@extends('layouts.editor')

@section('title', isset($numero) ? 'Modifier le numéro' : 'Nouveau numéro')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/editor/issues-form.css') }}">
@endsection

@section('page-title', isset($numero) ? 'Modifier le numéro' : 'Nouveau numéro')

@section('content')
<div class="form-container">
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
                    <label for="numero_edition">Numéro d'édition</label>
                    <input type="number" 
                           id="numero_edition" 
                           name="numero_edition" 
                           value="{{ old('numero_edition', $numero->numero_edition ?? '') }}"
                           required
                           class="form-control">
                    @error('numero_edition')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="titre_numero">Titre du numéro</label>
                    <input type="text" 
                           id="titre_numero" 
                           name="titre_numero" 
                           value="{{ old('titre_numero', $numero->titre_numero ?? '') }}"
                           required
                           class="form-control">
                    @error('titre_numero')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="theme_central">Thème central</label>
                    <input type="text" 
                           id="theme_central" 
                           name="theme_central" 
                           value="{{ old('theme_central', $numero->theme_central ?? '') }}"
                           class="form-control">
                    @error('theme_central')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="form-control">{{ old('description', $numero->description ?? '') }}</textarea>
                    @error('description')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h2>Publication</h2>

                <div class="form-group">
                    <label for="date_publication">Date de publication</label>
                    <input type="date" 
                           id="date_publication" 
                           name="date_publication" 
                           value="{{ old('date_publication', isset($numero) ? $numero->date_publication->format('Y-m-d') : '') }}"
                           required
                           class="form-control">
                    @error('date_publication')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="visibilite">Visibilité</label>
                    <select id="visibilite" name="visibilite" required class="form-control">
                        <option value="Public" {{ old('visibilite', $numero->visibilite ?? '') == 'Public' ? 'selected' : '' }}>
                            Public
                        </option>
                        <option value="Privé" {{ old('visibilite', $numero->visibilite ?? '') == 'Privé' ? 'selected' : '' }}>
                            Privé
                        </option>
                    </select>
                    @error('visibilite')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image_couverture">Image de couverture</label>
                    <div class="image-upload-container">
                        @if(isset($numero) && $numero->image_couverture)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $numero->image_couverture) }}" 
                                     alt="Image de couverture actuelle">
                                <p>Image actuelle</p>
                            </div>
                        @endif
                        <input type="file" 
                               id="image_couverture" 
                               name="image_couverture" 
                               accept="image/*"
                               class="form-control-file">
                    </div>
                    @error('image_couverture')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('editor.issues.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit">
                {{ isset($numero) ? 'Mettre à jour' : 'Créer le numéro' }}
            </button>
        </div>
    </form>
</div>
@endsection 