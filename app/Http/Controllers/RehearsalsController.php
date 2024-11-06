<?php

namespace App\Http\Controllers;

use App\Models\Rehearsal;


// ensayos
class RehearsalsController extends Controller
{
    public function index()
    {
        $rehearsals = Rehearsal::all();
        return response()->json(['message' => 'Lista de ensayos recuperada correctamente', 'Ensayos' => $rehearsals], 200);
    }
}
