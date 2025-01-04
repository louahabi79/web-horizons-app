<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    protected $fillable = [
        'message',
        'date_message',
        'article_id',
        'user_id'
    ];

    // Conversation belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Conversation belongs to an article
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
