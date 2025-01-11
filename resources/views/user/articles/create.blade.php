@extends('layouts.app')

@section('title', 'Proposer un Article - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/create-article.css') }}">
@endsection

@section('content')
<div class="create-article-wrapper">
    <div class="create-article-header">
        <h1>Proposer un Article</h1>
        <p class="subtitle">Partagez vos connaissances avec la communauté</p>
    </div>

    <form action="{{ route('user.createPoste.submit') }}" method="POST" enctype="multipart/form-data" class="create-article-form">
        @csrf
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="titre">Titre de l'article *</label>
            <input type="text" 
                   id="titre" 
                   name="titre" 
                   value="{{ old('titre') }}" 
                   class="form-control @error('titre') is-invalid @enderror"
                   required>
            @error('titre')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="theme_id">Thème *</label>
            <select id="theme_id" 
                    name="theme_id" 
                    class="form-control @error('theme_id') is-invalid @enderror"
                    required>
                <option value="">Sélectionnez un thème</option>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}" {{ old('theme_id') == $theme->id ? 'selected' : '' }}>
                        {{ $theme->nom_theme }}
                    </option>
                @endforeach
            </select>
            @error('theme_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_couverture">Image de couverture</label>
            <div class="image-upload-container">
                <input type="file" 
                       id="image_couverture" 
                       name="image_couverture" 
                       class="form-control-file @error('image_couverture') is-invalid @enderror"
                       accept="image/*"
                       onchange="previewImage(this)">
                <div id="image-preview" class="image-preview"></div>
            </div>
            <small class="form-text text-muted">Format recommandé : JPG, PNG. Taille max : 2MB</small>
            @error('image_couverture')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="temps_lecture">Temps de lecture estimé (en minutes) *</label>
            <input type="number" 
                   id="temps_lecture" 
                   name="temps_lecture" 
                   value="{{ old('temps_lecture') }}" 
                   class="form-control @error('temps_lecture') is-invalid @enderror"
                   min="1"
                   required>
            @error('temps_lecture')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="contenu">Contenu de l'article *</label>
            <textarea id="contenu" 
                      name="contenu" 
                      class="form-control @error('contenu') is-invalid @enderror"
                      rows="15"
                      required>{{ old('contenu') }}</textarea>
            @error('contenu')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Soumettre l'article</button>
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('preview-img');
            preview.appendChild(img);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection 