<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    // Define the relationship with the Article model
    public function articles()
    {
        return $this->hasMany(Article::class, 'theme_id');
    }
}
