<?php

namespace App\Http\Controllers;

use App\Models\Concerts;

class ConcertsController extends Controller
{
    public function index()

    {
        $concerts = Concerts::all();
        return response()->json(['message' => 'Lista de conciertos recuperada correctamente', 'Conciertos' => $concerts], 200);
    }
}
