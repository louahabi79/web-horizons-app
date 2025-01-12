@extends('layouts.app')

@section('styles')
<style>
.pending-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 2rem;
}

.pending-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.pending-header {
    background: #4B5563;
    color: white;
    padding: 1rem 1.5rem;
    font-size: 1.25rem;
    font-weight: 500;
}

.pending-body {
    padding: 2rem;
}

.alert-pending {
    background: #EFF6FF;
    border-left: 4px solid #3B82F6;
    color: #1E40AF;
    padding: 1rem 1.5rem;
    border-radius: 4px;
    margin-bottom: 1.5rem;
}

.pending-icon {
    font-size: 3rem;
    color: #3B82F6;
    margin-bottom: 1rem;
    text-align: center;
}

.pending-message {
    text-align: center;
    margin-bottom: 2rem;
    color: #4B5563;
    line-height: 1.6;
}

.btn-home {
    display: block;
    width: 100%;
    max-width: 200px;
    margin: 0 auto;
    padding: 0.75rem 1.5rem;
    background: #3B82F6;
    color: white;
    text-align: center;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.2s;
}

.btn-home:hover {
    background: #2563EB;
    color: white;
    text-decoration: none;
}
</style>
@endsection

@section('content')
<div class="page-container pending-container">
    <div class="pending-card">
        <div class="pending-header">
            Inscription en attente
        </div>
        
        <div class="pending-body">
            <div class="pending-icon">
                <i class="fas fa-clock"></i>
            </div>
            
            <div class="alert-pending">
                Votre demande d'inscription est en cours d'examen.
            </div>
            
            <div class="pending-message">
                <p>Vous recevrez un email dès que votre compte sera validé par notre équipe.</p>
                <p>Merci de votre patience !</p>
            </div>
            
            <a href="{{ route('home') }}" class="btn-home">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection 