<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Horizons - Le Magazine Tech</title>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="main-nav">
        <div class="nav-container">
            <div class="logo">
                <a href="/">Tech Horizons</a>
            </div>
            <div class="nav-menu">
                <div class="nav-links">
                    <a href="#themes">Thèmes</a>
                    <a href="#articles">Articles</a>
                    <a href="#about">À propos</a>
                </div>
                <div class="auth-buttons">
                @auth
                        <a href="{{ match(auth()->user()->role) {
                            'Éditeur' => route('admin.dashboard'),
                            'Responsable de thème' => route('theme-manager.dashboard'),
                            default => route('member.dashboard')
                        } }}" class="btn dashboard-btn">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="btn logout-btn">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-solid">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Shaping a world with <span class="highlight">reimagination.</span></h1>
            <p>Découvrez les dernières innovations et tendances du monde tech</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                <a href="#articles" class="btn btn-secondary">Learn more</a>
            </div>
        </div>
       
    </header>

    <section id="themes" class="themes-section">
        <div class="section-header">
            <h2>Explorez nos thèmes</h2>
            <p>Découvrez nos différentes catégories d'articles</p>
        </div>
        <div class="themes-grid">
            <div class="theme-card">
                <div class="theme-icon">🤖</div>
                <h3>Intelligence Artificielle</h3>
                <p>Découvrez les avancées en IA, machine learning et deep learning qui transforment notre monde.</p>
                <span class="article-count">24 articles</span>
            </div>
            
            <div class="theme-card">
                <div class="theme-icon">🌐</div>
                <h3>Internet des Objets (IoT)</h3>
                <p>Explorez l'univers connecté des objets intelligents et leurs applications innovantes.</p>
                <span class="article-count">18 articles</span>
            </div>
            
            <div class="theme-card">
                <div class="theme-icon">🔒</div>
                <h3>Cybersécurité</h3>
                <p>Restez informé sur les dernières tendances en sécurité informatique et protection des données.</p>
                <span class="article-count">15 articles</span>
            </div>
            
            <div class="theme-card">
                <div class="theme-icon">☁️</div>
                <h3>Cloud Computing</h3>
                <p>Tout sur les technologies cloud, la virtualisation et les services distribués.</p>
                <span class="article-count">20 articles</span>
            </div>
            
            <div class="theme-card">
                <div class="theme-icon">📱</div>
                <h3>Développement Mobile</h3>
                <p>Les dernières innovations en développement d'applications mobiles et technologies embarquées.</p>
                <span class="article-count">16 articles</span>
            </div>
            
            <div class="theme-card">
                <div class="theme-icon">🔗</div>
                <h3>Blockchain</h3>
                <p>Explorez les applications de la blockchain au-delà des cryptomonnaies.</p>
                <span class="article-count">12 articles</span>
            </div>
        </div>
    </section>

    <section id="articles" class="articles-section">
        <div class="section-header">
            <h2>Articles Récents</h2>
            <p>Les dernières publications de nos experts</p>
        </div>
        <div class="articles-grid">
            @foreach($latestArticles as $article)
            <div class="article-card">
                @if($article->image_couverture)
                <div class="article-image">
                    <img src="{{ asset('storage/' . $article->image_couverture) }}" 
                         alt="{{ $article->titre }}">
                </div>
                @endif
                <div class="article-content">
                    <div class="article-meta">
                        <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                        <span class="date">{{ $article->date_publication->format('d M Y') }}</span>
                    </div>
                    <h3>{{ $article->titre }}</h3>
                    <p>{{ Str::limit($article->contenu, 150) }}</p>
                    <div class="article-footer">
                        <span class="author">Par {{ $article->auteur->nom }}</span>
                        <a href="{{ route('public.articles.show', $article) }}" class="read-more">
                            Lire plus →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>



    <footer class="footer">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Tech Horizons. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>