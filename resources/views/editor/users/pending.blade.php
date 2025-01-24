@extends('layouts.editor')

@section('title', 'Demandes en attente - Éditeur')

@section('styles')
<link href="{{ asset('css/editor/users.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="users-container">
    <div class="users-header">
        <h1>Demandes en attente</h1>
        <a href="{{ route('editor.users.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Retour
        </a>
    </div>

    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Date de demande</th>
                    <th>Rôle demandé</th>
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
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="role-badge role-{{ strtolower(str_replace(' ', '-', $user->role_demande)) }}">
                                {{ $user->role_demande }}
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <form action="{{ route('editor.users.approve', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-icon text-success" title="Approuver">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <form action="{{ route('editor.users.reject', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-icon text-danger" title="Rejeter"
                                            onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette demande ?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-check-circle"></i>
                                <h3>Aucune demande en attente</h3>
                                <p>Toutes les demandes ont été traitées.</p>
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