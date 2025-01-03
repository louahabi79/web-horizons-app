<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In</title>
        <link rel="stylesheet" href="{{ asset('css/LoginUp.css') }}">
    </head>
    <body>
        <div class="container">
            <h1>Sign In</h1>
                @if ($errors->any())
                <div style="color: red;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form id="SignInForm" method="POST" action="{{route('login.submit')}}">
                @csrf
                <div class="InputPassGroup">
                    <label for="">Email or Username</label>
                    <input type="text" id="email" placeholder="Enter your email" name="email" required>
                </div>
                <div class="InputPassGroup">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Enter your password" name="password" required>
                </div>
                <button type="submit" class="btn">Sign In</button>
                <p>Don't have an account ? <a href="{{route("register")}}">Sign Up</a></p>
            </form>
        </div>
    </body>
</html>
