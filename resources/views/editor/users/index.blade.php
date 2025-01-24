@extends('layouts.editor')

@section('title', 'Gestion des Utilisateurs - Éditeur')

@section('styles')
<link href="{{ asset('css/editor/users.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="users-container">
    <div class="users-header">
        <h1>Gestion des Utilisateurs</h1>
        <div class="header-actions">
            <a href="{{ route('editor.users.pending') }}" class="btn-warning">
                <i class="fas fa-clock"></i>
                Demandes en attente
                @if($pendingUsers > 0)
                    <span class="badge">{{ $pendingUsers }}</span>
                @endif
            </a>
        </div>
    </div>

    <div class="filters-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher un utilisateur..." value="{{ request('search') }}">
        </div>
        <div class="filters">
            <select class="filter-select" name="role">
                <option value="">Tous les rôles</option>
                <option value="Abonné" {{ request('role') == 'Abonné' ? 'selected' : '' }}>Abonnés</option>
                <option value="Responsable de thème" {{ request('role') == 'Responsable de thème' ? 'selected' : '' }}>Responsables de thème</option>
                <option value="Éditeur" {{ request('role') == 'Éditeur' ? 'selected' : '' }}>Éditeurs</option>
            </select>
            <select class="filter-select" name="status">
                <option value="">Tous les statuts</option>
                <option value="actif" {{ request('status') == 'actif' ? 'selected' : '' }}>Actifs</option>
                <option value="bloqué" {{ request('status') == 'bloqué' ? 'selected' : '' }}>Bloqués</option>
            </select>
        </div>
    </div>

    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date d'inscription</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                                </div>
                                <div class="user-details">
                                    <span class="user-name">{{ $user->nom }} {{ $user->prenom }}</span>
                                    <span class="user-username">@{{ $user->username }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge role-{{ strtolower(str_replace(' ', '-', $user->role)) }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ $user->status }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                @if($user->role !== 'Éditeur')
                                    <div class="dropdown">
                                        <button class="btn-icon" title="Changer le rôle">
                                            <i class="fas fa-user-cog"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <form action="{{ route('editor.users.update-role', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit" name="role" value="Abonné" class="dropdown-item">
                                                    Abonné
                                                </button>
                                                <button type="submit" name="role" value="Responsable de thème" class="dropdown-item">
                                                    Responsable de thème
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    @if($user->status === 'actif')
                                        <form action="{{ route('editor.users.block', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-icon text-danger" title="Bloquer" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir bloquer cet utilisateur ?')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('editor.users.unblock', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-icon text-success" title="Débloquer">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('editor.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon text-danger" title="Supprimer" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h3>Aucun utilisateur trouvé</h3>
                                <p>Aucun utilisateur ne correspond aux critères de recherche.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $users->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 