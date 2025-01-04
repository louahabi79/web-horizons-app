<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theme extends Model
{
    protected $fillable = [
        'nom_theme',
        'description'
    ];

    // Theme can have many articles
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    // Theme can have many subscribers (users)
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriptions')
                    ->withPivot('date_abonnement')
                    ->withTimestamps();
    }
}
