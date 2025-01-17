<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion - Tech Horizons</title>
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
                    <h1>Connexion</h1>
                    <p>Bienvenue ! Connectez-vous pour continuer</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf
                    
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

                    <div class="form-group remember-me">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" id="remember">
                            <span>Se souvenir de moi</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Se connecter
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
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
