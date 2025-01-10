<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
                <ul class="nav-links">
                    <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('user.articles') }}" class="{{ request()->routeIs('user.articles') ? 'active' : '' }}">Articles</a></li>
                    <li><a href="{{ route('user.subscriptions') }}" class="{{ request()->routeIs('user.subscriptions') ? 'active' : '' }}">Abonnements</a></li>
                    <li><a href="{{ route('user.history') }}" class="{{ request()->routeIs('user.history') ? 'active' : '' }}">Historique</a></li>
                </ul>

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