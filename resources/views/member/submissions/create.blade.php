@extends('layouts.member')

@section('title', 'Soumettre un Article - Tech Magazine')

@section('page-title', 'Soumettre un Article')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/member/submissions.css') }}">
@endsection

@section('content')
<div class="submission-container">
    <header class="submission-header">
        <!-- <h1>Soumettre un Article</h1> -->
        <p class="subtitle">Partagez vos connaissances avec la communauté</p>
    </header>

    <form action="{{ route('member.submit.store') }}" method="POST" enctype="multipart/form-data" class="submission-form">
        @csrf
        <a href="{{ route('member.submissions') }}" class="back-link" style="margin-bottom: 10px;">
            <span class="icon">←</span>
            Retour aux soumissions
        </a>
        
        
        <div class="form-group" style="margin-top: 20px;">
            <label for="titre">Titre de l'article</label>
            <input type="text" 
                   id="titre" 
                   name="titre" 
                   value="{{ old('titre') }}" 
                   required 
                   class="form-control @error('titre') is-invalid @enderror">
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="theme_id">Thème</label>
            <select id="theme_id" 
                    name="theme_id" 
                    required 
                    class="form-control @error('theme_id') is-invalid @enderror">
                <option value="">Sélectionnez un thème</option>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}" {{ old('theme_id') == $theme->id ? 'selected' : '' }}>
                        {{ $theme->nom_theme }}
                    </option>
                @endforeach
            </select>
            @error('theme_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="contenu">Contenu</label>
            <textarea id="contenu" 
                      name="contenu" 
                      rows="10" 
                      required 
                      class="form-control @error('contenu') is-invalid @enderror">{{ old('contenu') }}</textarea>
            @error('contenu')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="temps_lecture">Temps de lecture estimé (en minutes)</label>
            <input type="number" 
                   id="temps_lecture" 
                   name="temps_lecture" 
                   value="{{ old('temps_lecture') }}" 
                   min="1" 
                   required 
                   class="form-control @error('temps_lecture') is-invalid @enderror">
            @error('temps_lecture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_couverture">Image de couverture</label>
            <input type="file" 
                   id="image_couverture" 
                   name="image_couverture" 
                   accept="image/*" 
                   onchange="previewImage(this)"
                   class="form-control @error('image_couverture') is-invalid @enderror">
            @error('image_couverture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="image-preview" class="mt-2"></div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Soumettre l'article</button>
            <a href="{{ route('member.submissions') }}" class="btn-cancel">Annuler</a>
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
            img.classList.add('preview-image');
            preview.appendChild(img);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection 