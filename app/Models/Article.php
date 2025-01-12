<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'statut',
        'user_id',
        'theme_id',
        'numero_id',
        'date_proposition',
        'date_proposition_editeur'
    ];

    protected $dates = [
        'date_proposition',
        'date_proposition_editeur',
        'created_at',
        'updated_at'
    ];

    // Relations
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function numero(): BelongsTo
    {
        return $this->belongsTo(Numero::class, 'numero_id', 'Id_numero');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function lecteurs(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'navigation_history')
            ->withPivot('date_consultation')
            ->withTimestamps();
    }

    // Méthode pour calculer la note moyenne
    public function averageRating()
    {
        return $this->notes()->avg('note');
    }
}
