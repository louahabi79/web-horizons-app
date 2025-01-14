@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('styles')
<style>
.users-container {
    /* Autres styles spécifiques */
}

.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.pending-notification {
    background: #FEF3C7;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    transition: all 0.2s;
}

.pending-notification:hover {
    background: #FDE68A;
    text-decoration: none;
}

.pending-icon {
    color: #92400E;
    font-size: 1.25rem;
}

.pending-text {
    color: #92400E;
    font-weight: 500;
}

.users-table-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.users-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.users-table th {
    background: #F3F4F6;
    padding: 1rem;
    font-weight: 600;
    color: #374151;
    text-align: left;
    border-bottom: 2px solid #E5E7EB;
}

.users-table td {
    padding: 1rem;
    border-bottom: 1px solid #E5E7EB;
    vertical-align: middle;
}

.user-status {
    display: inline-flex;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
    align-items: center;
    gap: 0.5rem;
}

.status-actif { background: #DEF7EC; color: #03543F; }
.status-inactif { background: #FDE8E8; color: #9B1C1C; }
.status-en_attente { background: #FEF3C7; color: #92400E; }

.role-select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #D1D5DB;
    border-radius: 0.375rem;
    background: white;
    color: #374151;
    font-size: 0.875rem;
}

.actions-cell {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-block { background: #EF4444; color: white; }
.btn-unblock { background: #10B981; color: white; }
.btn-delete { background: #DC2626; color: white; }

.btn:hover {
    opacity: 0.9;
}

.pagination {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .users-table-container {
        overflow-x: auto;
    }
    
    .users-table {
        min-width: 800px;
    }
}
</style>
@endsection

@section('content')
<div class="users-container">
    <div class="header-section">
        <h1>Gestion des Utilisateurs</h1>
        @if($pendingUsers > 0)
            <a href="{{ route('editeur.users.pending') }}" class="pending-notification">
                <i class="fas fa-bell pending-icon"></i>
                <span class="pending-text">{{ $pendingUsers }} demande(s) en attente</span>
            </a>
        @endif
    </div>

    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->nom }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('editeur.users.updateRole', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="role" class="role-select" onchange="this.form.submit()">
                                <option value="Abonné" {{ $user->role === 'Abonné' ? 'selected' : '' }}>Abonné</option>
                                <option value="Responsable de thème" {{ $user->role === 'Responsable de thème' ? 'selected' : '' }}>Responsable de thème</option>
                                <option value="Éditeur" {{ $user->role === 'Éditeur' ? 'selected' : '' }}>Éditeur</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <span class="user-status status-{{ $user->statut }}">
                            <i class="fas fa-circle" style="font-size: 0.5rem"></i>
                            {{ ucfirst($user->statut) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="actions-cell">
                        @if($user->statut === 'Actif')
                            <form action="{{ route('editeur.users.block', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-block">Bloquer</button>
                            </form>
                        @else
                            <form action="{{ route('editeur.users.unblock', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-unblock">Débloquer</button>
                            </form>
                        @endif
                        
                        <form action="{{ route('editeur.users.destroy', $user) }}" method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection 