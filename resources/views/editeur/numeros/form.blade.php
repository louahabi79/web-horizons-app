@extends('layouts.app')

@section('title', isset($numero) ? 'Modifier le Numéro' : 'Créer un Numéro')

@section('styles')
<style>
.form-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #D1D5DB;
    border-radius: 0.375rem;
}

.form-control:focus {
    outline: none;
    border-color: #3B82F6;
    ring: 2px #3B82F6;
}

textarea.form-control {
    min-height: 100px;
}

.image-preview {
    margin-top: 1rem;
    max-width: 300px;
}

.image-preview img {
    width: 100%;
    height: auto;
    border-radius: 4px;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>
@endsection

@section('content')
<div class="form-container">
    <h1>{{ isset($numero) ? 'Modifier le Numéro' : 'Créer un Numéro' }}</h1>

    <form action="{{ isset($numero) ? route('editeur.numeros.update', $numero) : route('editeur.numeros.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($numero))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="titre_numero">Titre du numéro</label>
            <input type="text" 
                   id="titre_numero" 
                   name="titre_numero" 
                   class="form-control @error('titre_numero') is-invalid @enderror"
                   value="{{ old('titre_numero', $numero->titre_numero ?? '') }}"
                   required>
            @error('titre_numero')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" 
                      name="description" 
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $numero->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="theme_central">Thème central</label>
            <input type="text" 
                   id="theme_central" 
                   name="theme_central" 
                   class="form-control @error('theme_central') is-invalid @enderror"
                   value="{{ old('theme_central', $numero->theme_central ?? '') }}">
            @error('theme_central')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="numero_edition">Numéro d'édition</label>
            <input type="number" 
                   id="numero_edition" 
                   name="numero_edition" 
                   class="form-control @error('numero_edition') is-invalid @enderror"
                   value="{{ old('numero_edition', $numero->numero_edition ?? '') }}"
                   required>
            @error('numero_edition')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_publication">Date de publication</label>
            <input type="date" 
                   id="date_publication" 
                   name="date_publication" 
                   class="form-control @error('date_publication') is-invalid @enderror"
                   value="{{ old('date_publication', isset($numero) ? $numero->date_publication : '') }}"
                   required>
            @error('date_publication')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="visibilite">Visibilité</label>
            <select id="visibilite" 
                    name="visibilite" 
                    class="form-control @error('visibilite') is-invalid @enderror">
                <option value="Public" {{ (old('visibilite', $numero->visibilite ?? '') == 'Public') ? 'selected' : '' }}>Public</option>
                <option value="Privé" {{ (old('visibilite', $numero->visibilite ?? '') == 'Privé') ? 'selected' : '' }}>Privé</option>
            </select>
            @error('visibilite')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_couverture">Image de couverture</label>
            <input type="file" 
                   id="image_couverture" 
                   name="image_couverture" 
                   class="form-control @error('image_couverture') is-invalid @enderror"
                   accept="image/*"
                   onchange="previewImage(this)">
            @if(isset($numero) && $numero->image_couverture)
                <div class="image-preview">
                    <img src="{{ asset('storage/' . $numero->image_couverture) }}" 
                         alt="Couverture actuelle">
                </div>
            @endif
            <div id="new-image-preview" class="image-preview"></div>
            @error('image_couverture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                {{ isset($numero) ? 'Mettre à jour' : 'Créer' }}
            </button>
            <a href="{{ route('editeur.numeros.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('new-image-preview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection 