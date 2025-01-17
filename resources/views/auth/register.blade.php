<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription - Tech Horizons</title>
        <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <a href="/" class="logo">
                        <span class="logo-icon">⚡</span>
                        Tech Horizons
                    </a>
                    <h1>Inscription</h1>
                    <p>Rejoignez notre communauté tech</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" 
                               id="prenom" 
                               name="prenom" 
                               value="{{ old('prenom') }}" 
                               required 
                               class="form-control @error('prenom') is-invalid @enderror">
                        @error('prenom')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" 
                               id="nom" 
                               name="nom" 
                               value="{{ old('nom') }}" 
                               required 
                               class="form-control @error('nom') is-invalid @enderror">
                        @error('nom')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        S'inscrire
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
                    <p class="home-link">
                        <a href="{{ route('home') }}">
                            <span>←</span> Retour à l'accueil
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
