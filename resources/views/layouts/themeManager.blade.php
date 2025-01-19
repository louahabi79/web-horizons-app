<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Horizons')</title>
    <link href="{{ asset('css/themeManager/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->prenom, 0, 1) }}{{ substr(Auth::user()->nom, 0, 1) }}
                    </div>
                    <div class="user-info">
                        <h3>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h3>
                        <span>Gestionnaire de Thème</span>
                    </div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('theme-manager.dashboard') }}" class="nav-item {{ request()->routeIs('theme-manager.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('theme-manager.content.index') }}" class="nav-item {{ request()->routeIs('theme-manager.content*') ? 'active' : '' }}">
                    <span class="nav-icon">📝</span>
                    Articles à Modérer
                </a>
                <a href="{{ route('theme-manager.members.index') }}" class="nav-item {{ request()->routeIs('theme-manager.members*') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span>
                    Abonnés
                </a>
                <a href="{{ route('theme-manager.moderation.index') }}" class="nav-item {{ request()->routeIs('theme-manager.moderation*') ? 'active' : '' }}">
                    <span class="nav-icon">👮</span>
                    Modérateurs
                </a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <span class="nav-icon">🚪</span>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="content-header">
                <h1>@yield('page-title')</h1>
                @yield('header-actions')
            </header>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html> 