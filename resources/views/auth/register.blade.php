<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up - Tech Horizons</title>
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
        <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpeg') }}">
    </head>
    <body>
        <div class="auth-container">
            
            
            <div class="auth-right">
                <div class="auth-form-container">
                    <h1>Create Account</h1>
                    <p class="auth-subtitle">Join our community of tech enthusiasts</p>

                    @if ($errors->any())
                        <div class="auth-errors">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form class="auth-form" method="POST" action="{{route('register.submit')}}">
                        @csrf
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" required 
                                   placeholder="Enter your first name"
                                   value="{{ old('first_name') }}">
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" required 
                                   placeholder="Enter your last name"
                                   value="{{ old('last_name') }}">
                        </div>

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
                                       placeholder="Create a password">
                                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                    <span class="eye-icon">👁️</span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="password-input">
                                <input type="password" id="password_confirmation" 
                                       name="password_confirmation" required
                                       placeholder="Confirm your password">
                                <button type="button" class="toggle-password" 
                                        onclick="togglePassword('password_confirmation')">
                                    <span class="eye-icon">👁️</span>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="auth-button">Create Account</button>
                    </form>

                    <p class="auth-redirect">
                        Already have an account? 
                        <a href="{{route('login')}}">Sign In</a>
                    </p>
                    <p class="auth-redirect">
                         
                        <a href="{{route('home')}}">return to home page</a>
                    </p>
                </div>
            </div>
        </div>

        <script>
            function togglePassword(inputId) {
                const passwordInput = document.getElementById(inputId);
                const eyeIcon = passwordInput.nextElementSibling.querySelector('.eye-icon');
                
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
