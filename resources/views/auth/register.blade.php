<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sign Up</title>
        <link rel="stylesheet" href="{{ asset('css/LoginUp.css') }}">
    </head>
    <body>
        <div class="container">
            <h1>Sign Up</h1>
            @if ($errors->any())
                <div style="color: red;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form id="SignUpForm" method="POST" action="{{route("register.submit")}}">
                @csrf
                <div class="InputPassGroup">
                    <label for="">First name</label>
                    <input type="text" id="FN" placeholder="Enter your first name" required name="first_name">
                </div>
                <div class="InputPassGroup">
                    <label for="">Last name</label>
                    <input type="text" id="LN" placeholder="Enter your Last name" name="last_name" required>
                </div>
                <div class="InputPassGroup">
                    <label for="">Date of birth</label>
                    <input type="date" id="date" required>
                </div>
                <div class="InputPassGroup">
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="InputPassGroup">
                    <label for="password">Add a new Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <div class="InputPassGroup">
                    <label for="password">Confirm your Password</label>
                    <input type="password"  id="Confpassword" name="password_confirmation" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn">Sign Up</button>
                <p>Already have an account ? <a href="{{route("login.form")}}">Sign In</a></p>
            </form>
        </div>
    </body>
</html>
