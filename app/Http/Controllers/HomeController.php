<?php

namespace App\Http\Controllers;

use App\Models\Numero;
use Illuminate\Http\Request;

class HomeController
{
    public function index()
    {
        $numeros = Numero::where('visibilite', 'Public')
                        ->where('is_published', true)
                        ->orderBy('numero_edition', 'desc')
                        ->paginate(6);

        return view('home', compact('numeros'));
    }
} 