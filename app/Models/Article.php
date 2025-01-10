<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'titre',
        'contenu',
        'statut',
        'date_proposition',
        'date_publication',
        'image_couverture',
        'temps_lecture',
        'vues',
        'theme_id',
        'user_id'
    ];

    // Article belongs to a theme
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    // Article belongs to a user (author)
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Article's notes
    public function notes(): HasMany
    {
        return $this->hasMany(ArticleNote::class);
    }

    // Article's conversations
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    // Article's navigation history
    public function navigationHistory(): HasMany
    {
        return $this->hasMany(NavigationHistory::class);
    }

    // Article's tags
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // Article's numero
    public function numero(): BelongsTo
    {
        return $this->belongsTo(Numero::class);
    }

    // Méthode pour calculer la note moyenne
    public function averageRating()
    {
        return $this->notes()->avg('note');
    }
}
