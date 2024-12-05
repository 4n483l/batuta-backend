<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instrument;

class InstrumentController extends Controller
{
    public function index()
    {
        $instruments = Instrument::all();
        return response()->json(['instruments' => $instruments], 200);
    }

    public function store(Request $request)
    {
        $validated  = $request->validate([
            'name' => 'required',
            'level' => 'nullable',
        ]);
        $instrument = Instrument::create($validated);

        return response()->json([
            'message' => 'Instrumento creado correctamente.',
            'instrument' => $instrument
            ], 201);
    }

    public function show($id)
    {
        return Instrument::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $instrument = Instrument::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'level' => 'nullable',
        ]);
        $instrument->update($validated);

        // return response()->json(['instrument' => $instrument], 200);

        return $instrument;
    }

    public function destroy($id)
    {
        $instrument = Instrument::findOrFail($id);
        $instrument->delete();
        return response()->json(['message' => 'Instrument deleted successfully'], 200);
    }

    public function getTeacherInstruments()
    {
        $user = auth()->user();
        if ($user->user_type == 'teacher' || $user->user_type == 'admin') {
            $instruments = $user->instruments;
            return response()->json(['instruments' => $instruments], 200);
        }
        return response()->json(['message' => 'No tienes permiso para acceder a esta ruta.'], 403);
    }





}
