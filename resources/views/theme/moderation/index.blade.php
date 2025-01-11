@extends('layouts.app')

@section('title', 'Modération des Conversations')

@section('styles')
<style>
    .moderation-container {
        padding: 2rem;
    }

    .moderation-header {
        margin-bottom: 2rem;
    }

    .messages-grid {
        display: grid;
        gap: 1.5rem;
    }

    .message-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .user-info {
        font-weight: 500;
        color: #2d3748;
    }

    .message-meta {
        font-size: 0.875rem;
        color: #718096;
    }

    .message-content {
        margin: 1rem 0;
        color: #4a5568;
    }

    .message-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        height: 38px;
        line-height: 1.2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<div class="moderation-container">
    <div class="moderation-header">
        <h1>Modération des Conversations</h1>
    </div>

    <div class="messages-grid">
        @forelse($conversations as $message)
            <div class="message-card">
                <div class="message-header">
                    <div>
                        <div class="user-info">
                            {{ $message->user->nom }}
                        </div>
                        <div class="message-meta">
                            <div>Article: {{ $message->article->titre }}</div>
                            <div>Posté le: {{ $message->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <div class="message-content">
                    {{ $message->contenu }}
                </div>

                <div class="message-actions">
                    <form action="{{ route('theme.moderation.delete', $message) }}" 
                          method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Supprimer
                        </button>
                    </form>

                    <form action="{{ route('theme.moderation.warn', $message) }}" 
                          method="POST" 
                          onsubmit="return confirm('Voulez-vous vraiment avertir cet utilisateur ?');">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            Avertir l'utilisateur
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Aucun message à modérer</p>
            </div>
        @endforelse
    </div>
</div>
@endsection 