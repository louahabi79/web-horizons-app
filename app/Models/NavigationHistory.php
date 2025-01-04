<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavigationHistory extends Model
{
    protected $fillable = [
        'date_consultation',
        'user_id',
        'article_id'
    ];

    // Navigation history belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Navigation history belongs to an article
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
