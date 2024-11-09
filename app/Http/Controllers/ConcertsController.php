<?php

namespace App\Http\Controllers;

use App\Models\Concert;

class ConcertsController extends Controller
{
    public function index()
    {
        $concerts = Concert::all();
        return response()->json(['message' => 'Lista de conciertos recuperada correctamente', 'Concerts' => $concerts], 200);
    }
}
