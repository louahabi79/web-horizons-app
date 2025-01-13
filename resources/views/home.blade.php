<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Horizons - Technology Magazine</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpeg') }}">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
    <style>
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .article-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%; /* Hauteur uniforme */
        }

        .article-image {
            height: 200px; /* Hauteur fixe pour les images */
            overflow: hidden;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1; /* Prend l'espace restant */
        }

        .article-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .theme-badge, .numero-badge {
            font-size: 0.875rem;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
        }

        .article-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .article-content p {
            flex: 1; /* Le texte prend l'espace disponible */
            margin-bottom: 1rem;
        }

        .article-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
            margin-top: auto; /* Pousse le footer en bas */
        }

        .author {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .read-more {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .read-more:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav-container">
            <div class="logo">
                <a href="/">Tech Horizons</a>
            </div>
            
            <div class="nav-menu">
                <ul class="nav-links">
                    <li><a href="#themes">Themes</a></li>
                    <li><a href="#latest">Latest Articles</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
                
                <div class="auth-buttons">
                    @auth
                        <a href="{{ match(auth()->user()->role) {
                            'Éditeur' => route('editeur.dashboard'),
                            'Responsable de thème' => route('theme.dashboard'),
                            default => route('user.dashboard')
                        } }}" class="btn dashboard-btn">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="btn logout-btn">Logout</button>
                        </form>
                    @else
                        <a href="{{route('login')}}" class="btn login-btn">Sign In</a>
                        <a href="{{route('register')}}" class="btn signup-btn">Get Started</a>
                    @endauth
                </div>
            </div>

            <button class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Discover the Future of Technology</h1>
                <p>Stay ahead with in-depth articles on AI, IoT, Cybersecurity, and more.</p>
                @guest
                    <a href="{{route('register')}}" class="cta-button">Start Reading Today</a>
                @endguest
            </div>
        </section>

        <section id="themes" class="themes-section">
            <h2>Popular Themes</h2>
            <div class="themes-grid">
                <div class="theme-card">
                    <div class="theme-icon">🤖</div>
                    <h3>Artificial Intelligence</h3>
                    <p>Explore the latest in AI and machine learning</p>
                </div>
                <div class="theme-card">
                    <div class="theme-icon">🔒</div>
                    <h3>Cybersecurity</h3>
                    <p>Stay secure in the digital age</p>
                </div>
                <div class="theme-card">
                    <div class="theme-icon">📱</div>
                    <h3>Internet of Things</h3>
                    <p>Connected devices shaping our future</p>
                </div>
                <div class="theme-card">
                    <div class="theme-icon">🥽</div>
                    <h3>Virtual Reality</h3>
                    <p>Immersive technologies and experiences</p>
                </div>
            </div>
        </section>

        <section id="latest" class="latest-articles">
            <h2>Derniers Articles</h2>
            <div class="articles-grid">
                @forelse($latestArticles as $article)
                    <article class="article-card">
                        @if($article->image_couverture)
                            <div class="article-image">
                                <img src="{{ asset('storage/' . $article->image_couverture) }}" 
                                     alt="Image de couverture de {{ $article->titre }}">
                            </div>
                        @endif
                        <div class="article-content">
                            <div class="article-meta">
                                <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                                <span class="numero-badge">{{ $article->numero->titre_numero }}</span>
                            </div>
                            <h3>{{ $article->titre }}</h3>
                            <p>{{ Str::limit($article->contenu, 150) }}</p>
                            <div class="article-footer">
                                <span class="author">Par {{ $article->auteur->nom }}</span>
                                <a href="{{ route('public.articles.show', $article) }}" class="read-more">Lire la suite →</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="no-articles">
                        <p>Aucun article publié pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <footer class="footer" id="about">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About Tech Horizons</h4>
                <p>Your source for the latest technology insights and innovations.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#themes">Themes</a></li>
                    <li><a href="#latest">Latest Articles</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <ul>
                    <li><a href="mailto:contact@techhorizons.com">Email Us</a></li>
                    <li><a href="">GitHub</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Tech Horizons. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{asset('js/home.js')}}"></script>
</body>
</html>
