<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_theme',
        'description',
        'responsable_id'
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function abonnes()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'theme_id', 'user_id')
            ->withTimestamps()
            ->withPivot('date_abonnement');
    }
    
}
