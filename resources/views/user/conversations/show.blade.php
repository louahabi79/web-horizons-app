@extends('layouts.app')

@section('title', 'Conversation - ' . $article->titre)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/user/conversation.css') }}">
@endsection

@section('content')
<div class="conversation-wrapper">
    <div class="conversation-header">
        <h1>Conversation sur l'article</h1>
        <div class="article-info">
            <h2>{{ $article->titre }}</h2>
            <div class="article-meta">
                <span>Par {{ $article->auteur->nom }}</span>
                <span>{{ $article->theme->nom_theme }}</span>
            </div>
        </div>

        <div class="rating-section">
            <h3>Noter cet article</h3>
            <div class="star-rating">
                @for($i = 1; $i <= 5; $i++)
                    <button class="star-btn {{ $article->notes()->where('user_id', Auth::id())->first()?->note >= $i ? 'active' : '' }}"
                            onclick="rateArticle({{ $i }})">★</button>
                @endfor
            </div>
            <span class="average-rating">
                Note moyenne : {{ number_format($article->averageRating(), 1) }}/5
            </span>
        </div>
    </div>

    <div class="messages-container">
        @forelse($messages as $message)
            <div class="message {{ $message->user_id === Auth::id() ? 'message-own' : 'message-other' }}">
                <div class="message-header">
                    <span class="message-author">{{ $message->user->nom }}</span>
                    <span class="message-time">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="message-content">
                    {{ $message->message }}
                </div>
            </div>
        @empty
            <div class="no-messages">
                <p>Aucun message dans cette conversation.</p>
                <p>Soyez le premier à commenter !</p>
            </div>
        @endforelse
    </div>

    <form class="message-form" action="{{ route('user.conversations.store', $article) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="message" 
                      class="message-input" 
                      placeholder="Votre message..."
                      required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
function rateArticle(note) {
    fetch('{{ route('user.articles.rate', $article) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ note: note })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mettre à jour l'affichage des étoiles
            document.querySelectorAll('.star-btn').forEach((btn, index) => {
                btn.classList.toggle('active', index < note);
            });
            // Mettre à jour la note moyenne
            document.querySelector('.average-rating').textContent = 
                `Note moyenne : ${parseFloat(data.newAverage).toFixed(1)}/5`;
        }
    })
    .catch(error => console.error('Erreur:', error));
}
</script>
@endsection 