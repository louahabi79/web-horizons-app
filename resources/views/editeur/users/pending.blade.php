@extends('layouts.app')

@section('title', 'Demandes d\'inscription en attente')

@section('styles')
<style>
.pending-container {
    padding: 2rem;
}

.pending-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.pending-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

.user-info {
    margin-bottom: 1.5rem;
}

.user-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1F2937;
}

.user-email {
    color: #6B7280;
    margin-top: 0.25rem;
}

.request-date {
    font-size: 0.875rem;
    color: #6B7280;
    margin-top: 0.5rem;
}

.card-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn {
    flex: 1;
    padding: 0.5rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    border: none;
    text-align: center;
}

.btn-approve { background: #10B981; color: white; }
.btn-reject { background: #DC2626; color: white; }
</style>
@endsection

@section('content')
<div class="pending-container">
    <div class="header-actions">
        <h1>Demandes d'inscription en attente</h1>
        <a href="{{ route('editeur.users.index') }}" class="btn btn-primary">
            Retour à la liste des utilisateurs
        </a>
    </div>

    <div class="pending-grid">
        @forelse($users as $user)
            <div class="pending-card">
                <div class="user-info">
                    <div class="user-name">{{ $user->nom }}</div>
                    <div class="user-email">{{ $user->email }}</div>
                    <div class="request-date">
                        Demande reçue le {{ $user->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>

                <div class="card-actions">
                    <form action="{{ route('editeur.users.approve', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-approve">Approuver</button>
                    </form>

                    <form action="{{ route('editeur.users.reject', $user) }}" method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir rejeter cette demande ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-reject">Rejeter</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Aucune demande d'inscription en attente.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection 