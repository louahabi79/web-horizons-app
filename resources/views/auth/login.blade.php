<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In - Tech Horizons</title>
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
        <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpeg') }}">
    </head>
    <body>
        <div class="auth-container">
           
            
            <div class="auth-right">
                <div class="auth-form-container">
                    <h1>Welcome Back</h1>
                    <p class="auth-subtitle">Please sign in to continue</p>

                    @if ($errors->any())
                        <div class="auth-errors">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form class="auth-form" method="POST" action="{{route('login.submit')}}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required 
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="password-input">
                                <input type="password" id="password" name="password" required
                                       placeholder="Enter your password">
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <span class="eye-icon">👁️</span>
                                </button>
                            </div>
                        </div>

                        <!-- <div class="form-options">
                            <label class="remember-me">
                                <input type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>
                            <a href="#" class="forgot-password">Forgot password?</a>
                        </div> -->

                        <button type="submit" class="auth-button">Sign In</button>
                    </form>

                    <p class="auth-redirect">
                        Don't have an account? 
                        <a href="{{route('register')}}">Sign Up</a>
                    </p>
                    <p class="auth-redirect">
                         
                        <a href="{{route('home')}}">return to home page</a>
                    </p>
                </div>
            </div>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.querySelector('.eye-icon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.textContent = '👁️‍🗨️';
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.textContent = '👁️';
                }
            }
        </script>
    </body>
</html>
