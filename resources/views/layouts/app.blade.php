<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Horizons')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpeg') }}">
</head>
<body>
    <header class="header">
        <nav class="nav-container">
            <div class="logo">
                <a href="/">Tech Horizons</a>
            </div>
            
            <div class="nav-menu">
                @auth
                    @if(Auth::user()->role === 'Abonné')
                    <ul class="nav-links">
                        <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="{{ route('user.articles') }}" class="{{ request()->routeIs('user.articles') ? 'active' : '' }}">Articles</a></li>
                        <li><a href="{{ route('user.propositions') }}" class="{{ request()->routeIs('user.propositions') ? 'active' : '' }}">Propositions</a></li>
                        <li><a href="{{ route('user.subscriptions') }}" class="{{ request()->routeIs('user.subscriptions') ? 'active' : '' }}">Abonnements</a></li>
                        <li><a href="{{ route('user.history') }}" class="{{ request()->routeIs('user.history') ? 'active' : '' }}">Historique</a></li>
                    </ul>
                    @elseif(Auth::user()->role === 'Responsable de thème')
                    <ul class="nav-links">
                        <li><a href="{{ route('theme.dashboard') }}" class="{{ request()->routeIs('theme.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="{{ route('theme.articles') }}" class="{{ request()->routeIs('theme.articles') ? 'active' : '' }}">Articles</a></li>
                        <li><a href="{{ route('theme.subscribers') }}" class="{{ request()->routeIs('theme.subscribers') ? 'active' : '' }}">Abonnés</a></li>
                        <li><a href="{{ route('theme.stats') }}" class="{{ request()->routeIs('theme.stats') ? 'active' : '' }}">Statistiques</a></li>
                    </ul>
                    @elseif(Auth::user()->role === 'Éditeur')
                    <ul class="nav-links">
                        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Utilisateurs</a></li>
                        <li><a href="{{ route('admin.themes') }}" class="{{ request()->routeIs('admin.themes') ? 'active' : '' }}">Thèmes</a></li>
                        <li><a href="{{ route('admin.stats') }}" class="{{ request()->routeIs('admin.stats') ? 'active' : '' }}">Statistiques</a></li>
                    </ul>
                    @endif

                    <div class="user-menu">
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()->nom }}</span>
                            <span class="user-role">{{ Auth::user()->role }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="logout-btn">Déconnexion</button>
                        </form>
                    </div>
                @endauth
            </div>

            <button class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </header>

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html> 