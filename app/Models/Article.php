<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // Define the relationship with the Theme model
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}
