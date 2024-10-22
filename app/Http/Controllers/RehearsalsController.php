<?php

namespace App\Http\Controllers;

use App\Models\Rehearsals;


// ensayos
class RehearsalsController extends Controller
{
    public function index()
    {
        $rehearsals = Rehearsals::all();
        return response()->json(['message' => 'Lista de ensayos recuperada correctamente', 'Ensayos' => $rehearsals], 200);
    }
}
