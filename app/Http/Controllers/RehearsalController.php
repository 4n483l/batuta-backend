<?php

namespace App\Http\Controllers;

use App\Models\Rehearsal;
use Illuminate\Http\Request;


class RehearsalController extends Controller
{
    public function index()
    {
        $rehearsals = Rehearsal::all();
        return response()->json(['message' => 'Lista de ensayos recuperada correctamente', 'Rehearsals' => $rehearsals], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'hour' => 'required|date_format:H:i',
        ]);

        $rehearsal = Rehearsal::create($validated);

        return response()->json([
            'message' => 'Ensayo creado correctamente.',
            'Rehearsal' => $rehearsal,
        ], 201);
    }

    public function show($id)
    {
        return Rehearsal::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $rehearsal = Rehearsal::findOrFail($id);

        $validated = $request->validate([
            
            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'hour' => 'required|date_format:H:i',
        ]);

        $rehearsal->update($validated);
        return $rehearsal;
    }

    public function destroy($id)
    {
        $rehearsal = Rehearsal::findOrFail($id);
        $rehearsal->delete();
        return response()->json(['message' => 'Ensayo eliminado correctamente'], 200);
    }


}
