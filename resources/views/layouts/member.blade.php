<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Horizons')</title>
    <link href="{{ asset('css/member/style.css') }}" rel="stylesheet">
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
                        <span>Membre</span>
                    </div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('member.dashboard') }}" class="nav-item {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('member.articles') }}" class="nav-item {{ request()->routeIs('member.articles*') ? 'active' : '' }}">
                    <span class="nav-icon">📚</span>
                    Articles
                </a>
                <a href="{{ route('member.submissions') }}" class="nav-item {{ request()->routeIs('member.submissions*') ? 'active' : '' }}">
                    <span class="nav-icon">📝</span>
                    Mes Soumissions
                </a>
                <a href="{{ route('member.memberships') }}" class="nav-item {{ request()->routeIs('member.memberships*') ? 'active' : '' }}">
                    <span class="nav-icon">🔔</span>
                    Abonnements
                </a>
                <a href="{{ route('member.history') }}" class="nav-item {{ request()->routeIs('member.history*') ? 'active' : '' }}">
                    <span class="nav-icon">📖</span>
                    Historique
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