<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;


class ConcertController extends Controller
{
    // get
    public function index()
    {
        $concerts = Concert::all();
        return response()->json(['message' => 'Lista de conciertos recuperada correctamente', 'Concerts' => $concerts], 200);
    }

    // post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'hour' => 'required|date_format:H:i',
        ]);

        $concert = Concert::create($validated);

        return response()->json([
            'message' => 'Concierto creado correctamente.',
            'Concert' => $concert,
        ], 201);
    }

    // get para update
    public function show($id)
    {
        // Muestra un concierto específico
        return Concert::findOrFail($id);
    }

    // put
    public function update(Request $request, $id)
    {
        // Actualiza un concierto existente
        $concert = Concert::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'hour' => 'required|date_format:H:i',
        ]);

        $concert->update($validated);
        return $concert;
    }

    // delete
    public function destroy($id)
    {
        $concert = Concert::findOrFail($id);
        $concert->delete();

        return response()->json(['message' => 'Concierto eliminado correctamente']);
    }
}
