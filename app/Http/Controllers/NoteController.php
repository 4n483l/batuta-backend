<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{

    public function index()
    {
        $notes = Note::all();
        return response()->json(['message' => 'Lista de notas recuperada correctamente', 'Notes' => $notes], 200);
    }
}
