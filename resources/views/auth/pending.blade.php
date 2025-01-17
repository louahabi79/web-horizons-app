<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En attente de validation - Tech Horizons</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card pending-card">
            <div class="auth-header">
                <a href="/" class="logo">
                    <span class="logo-icon">⚡</span>
                    Tech Horizons
                </a>
                <div class="pending-icon">⏳</div>
                <h1>Compte en attente</h1>
                <p>Votre compte est en cours de validation par nos équipes</p>
            </div>

            <div class="pending-content">
                <div class="info-box">
                    <h3>Que se passe-t-il ensuite ?</h3>
                    <ul>
                        <li>Notre équipe examine votre demande</li>
                        <li>Vous recevrez un email de confirmation</li>
                        <li>Vous pourrez alors accéder à votre espace membre</li>
                    </ul>
                </div>

                <div class="contact-info">
                    <p>Des questions ? Contactez-nous à <a href="mailto:support@techhorizons.com">support@techhorizons.com</a></p>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-outline">Se déconnecter</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 