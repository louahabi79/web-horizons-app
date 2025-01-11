@extends('layouts.app')

@section('title', 'Gestion des Abonnements')

@section('styles')
<style>
    .subscriptions-container {
        padding: 2rem;
    }

    .subscriptions-header {
        margin-bottom: 2rem;
    }

    .subscriptions-grid {
        display: grid;
        gap: 1.5rem;
    }

    .subscription-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .subscription-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .subscriber-info {
        font-size: 1.1rem;
        color: #2d3748;
    }

    .subscription-meta {
        font-size: 0.875rem;
        color: #718096;
        margin-top: 0.5rem;
    }

    .subscription-actions {
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

    .btn:hover {
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<div class="subscriptions-container">
    <div class="subscriptions-header">
        <h1>Gestion des Abonnements</h1>
    </div>

    <div class="subscriptions-grid">
        @forelse($subscriptions as $subscriber)
            <div class="subscription-card">
                <div class="subscription-header">
                    <div>
                        <div class="subscriber-info">
                            {{ $subscriber->nom }}
                        </div>
                        <div class="subscription-meta">
                            <div>Email: {{ $subscriber->email }}</div>
                            <div>Abonné depuis: {{ $subscriber->pivot->date_abonnement }}</div>
                        </div>
                    </div>
                </div>

                <div class="subscription-actions">
                    @if($subscriber->pivot && $subscriber->pivot->id)
                        <form action="{{ route('theme.subscriptions.remove', ['subscriptionId' => $subscriber->pivot->id]) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cet abonnement ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Retirer l'abonnement
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Aucun abonnement à afficher</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $subscriptions->links() }}
    </div>
</div>
@endsection 