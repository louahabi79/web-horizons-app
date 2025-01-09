<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Horizons</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpeg') }}">
    <link rel="stylesheet" href="{{asset("css/home.css")}}">
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="#">Tech Horizons</a>
        </div>
        <div class="rightside">
            <nav class="nav-links">
                <ul>
                    <li><a href="#">Topics</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="{{route("login")}}" class="login-btn">Sign In</a></li>
                </ul>
            </nav>
            <div class="search-login">
                <a href="{{route("register")}}" class="btn signup-btn">Get started</a>
            </div>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
        </div>
    </header>
    <div class="bodyPage">
        <div id="backgim">
            <div class="bodyContent">
                <div class="TitlePage">
                    <p>Technologie</p>
                    <p>Stories & Ideas</p>
                </div>
            <p id="parag">A place to read, write, and deepen your understanding</p>
            <a href="{{route("register")}}" class="secbtn signup-btn">Start Reading</a>
        </div>
    </div>
    <footer>
        <ul class="listFooter">
            <li><a href="">Help</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Team</a></li>
            <li><a href="#">Github</a></li>
        </ul>
    </footer>
    </div>
    <script src="{{asset("js/Edit.js")}}"></script>
</body>
</html>
