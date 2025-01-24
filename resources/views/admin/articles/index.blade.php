@extends('layouts.editor')

@section('title', 'Gestion des Articles - Éditeur')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/editor/articles.css') }}">
@endsection

@section('page-title', 'Gestion des Articles')

@section('content')
<div class="articles-container">
    <div class="articles-sections">
        <!-- Articles publiés -->
        @if($articles['Publié'] ?? null)
        <section class="articles-section">
            <h2>Articles publiés</h2>
            <br>
            <div class="articles-grid">
                @foreach($articles['Publié'] as $article)
                    <div class="article-card">
                        @if($article->image_couverture)
                            <div class="article-image">
                                <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="{{ $article->titre }}"
                                style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                        @endif
                        <div class="article-content">
                            <div class="article-header">
                                <h3>{{ $article->titre }}</h3>
                                <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                            </div>
                            <div class="article-meta">
                                <span>Par {{ $article->auteur->nom }}</span>
                                <span>{{ $article->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="article-actions">
                                <a href="{{ route('editor.articles.show', $article) }}" class="btn-examine">
                                    <span class="icon">👁️</span>
                                    Examiner l'article
                                </a>
                                <div class="action-group">
                                    <form action="{{ route('editor.articles.toggle-status', $article) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-toggle">Désactiver</button>
                                    </form>
                                </div>
                                
                                @if(!$article->numero_id)
                                <div class="action-group">
                                    <form action="{{ route('editor.articles.assign-to-numero', $article) }}" method="POST">
                                        @csrf
                                        <select name="numero_id" required class="form-control">
                                            <option value="">Assigner à un numéro</option>
                                            @foreach($numeros as $numero)
                                                <option value="{{ $numero->Id_numero }}">
                                                    N°{{ $numero->numero_edition }} - {{ $numero->titre_numero }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn-assign">Assigner</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Articles désactivés -->
        @if($articles['Désactivé'] ?? null)
        <section class="articles-section">

            <h2>Articles désactivés</h2>
            <br>
            <div class="articles-grid">
                @foreach($articles['Désactivé'] as $article)
                    <div class="article-card disabled">
                        @if($article->image_couverture)
                            <div class="article-image">
                                <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="{{ $article->titre }}">
                            </div>
                        @endif
                        <div class="article-content">
                            <div class="article-header">
                                <h3>{{ $article->titre }}</h3>
                                <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                            </div>
                            <div class="article-meta">
                                <span>Par {{ $article->auteur->nom }}</span>
                                <span>{{ $article->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="article-actions">
                                <a href="{{ route('editor.articles.show', $article) }}" class="btn-examine">
                                    <span class="icon">👁️</span>
                                    Examiner l'article
                                </a>
                                <form action="{{ route('editor.articles.toggle-status', $article) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-toggle">Activer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection 