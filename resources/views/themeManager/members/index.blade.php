@extends('layouts.themeManager')

@section('title', 'Gestion des Abonnés - Theme Manager')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/themeManager/members.css') }}">
@endsection

@section('page-title', 'Gestion des Abonnés')

@section('content')
<div class="members-container">
    <div class="header-actions">
        <div class="stats">
            <div class="stat-item">
                <span class="stat-value">{{ $subscribers->total() }}</span>
                <span class="stat-label">Abonnés au total</span>
            </div>
        </div>
        <a href="{{ route('theme-manager.members.export') }}" class="btn-export">
            <span class="icon">📊</span>
            Exporter en CSV
        </a>
    </div>

    <div class="members-list">
        <div class="table-responsive">
            <table class="members-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Date d'abonnement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                        <tr>
                            <td>{{ $subscriber->nom }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->pivot->created_at->format('d/m/Y') }}</td>
                            <td>
                                <form action="{{ route('theme-manager.members.remove', $subscriber) }}" 
                                      method="POST"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cet abonné ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove">
                                        <span class="icon">🗑️</span>
                                        Retirer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">Aucun abonné trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $subscribers->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection 