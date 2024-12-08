<?php

namespace App\Http\Controllers;

use App\Models\Rehearsal;
use Illuminate\Http\Request;


class RehearsalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->user_type === 'teacher' || $user->user_type === 'member' || $user->user_type === 'musician' || $user->role === 'admin') {
            $rehearsals = Rehearsal::all();
            return response()->json(['message' => 'Lista de ensayos recuperada correctamente', 'Rehearsals' => $rehearsals], 200);
        } else {
            return response()->json(['message' => 'El usuario no tiene permiso para ver esta información.'], 403);
        }
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
            'rehearsal' => $rehearsal,
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
