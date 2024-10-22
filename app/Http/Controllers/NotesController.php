<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notes;

class NotesController extends Controller
{

    public function index()
    {
        $notes = Notes::all();
        return response()->json(['message' => 'Lista de notas recuperada correctamente', 'Notas' => $notes], 200);
    }
}
