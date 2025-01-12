@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('styles')
<style>
.users-container {
    padding: 2rem;
}

.header-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.pending-requests {
    background: #FEF3C7;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.pending-requests span {
    font-weight: 600;
    color: #92400E;
}

.users-table {
    width: 100%;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.users-table th,
.users-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #E5E7EB;
}

.users-table th {
    background: #F3F4F6;
    font-weight: 600;
    color: #374151;
}

.user-status {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-actif { background: #DEF7EC; color: #03543F; }
.status-inactif { background: #FDE8E8; color: #9B1C1C; }
.status-en_attente { background: #FEF3C7; color: #92400E; }

.role-select {
    padding: 0.375rem;
    border: 1px solid #D1D5DB;
    border-radius: 0.375rem;
    background: white;
}

.actions-cell {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    border: none;
}

.btn-primary { background: #3B82F6; color: white; }
.btn-danger { background: #DC2626; color: white; }
.btn-warning { background: #F59E0B; color: white; }
.btn-success { background: #10B981; color: white; }

.pagination {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}
</style>
@endsection

@section('content')

<div class="users-container">
    <div class="header-actions">
        <h1>Gestion des Utilisateurs</h1>
        @if($pendingUsers > 0)
            <a href="{{ route('editeur.users.pending') }}" class="pending-requests">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <span>{{ $pendingUsers }} demandes en attente</span>
            </a>
        @endif
    </div>

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
                    <form action="{{ route('editeur.users.updateRole', $user) }}" method="POST" class="inline">
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
                        {{ ucfirst($user->statut) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="actions-cell">
                    @if($user->statut === 'Actif')
                        <form action="{{ route('editeur.users.block', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">Bloquer</button>
                        </form>
                    @else
                        <form action="{{ route('editeur.users.unblock', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Débloquer</button>
                        </form>
                    @endif
                    
                    <form action="{{ route('editeur.users.destroy', $user) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection 