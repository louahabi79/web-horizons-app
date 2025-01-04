<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleNote extends Model
{
    protected $fillable = [
        'note',
        'date_note',
        'user_id',
        'article_id'
    ];

    // Note belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Note belongs to an article
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}

