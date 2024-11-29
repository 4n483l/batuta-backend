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

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'level' => 'required',
        ]);

        $instrument = Instrument::create($data);
        return response()->json(['instrument' => $instrument], 201);
    }

    public function show($id)
    {
        $instrument = Instrument::findOrFail($id);
        return response()->json(['instrument' => $instrument], 200);
    }

    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required',
            'level' => 'required',
        ]);

        $instrument = Instrument::findOrFail($id);
        $instrument->update($data);
        return response()->json(['instrument' => $instrument], 200);
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
        if($user->user_type == 'teacher' || $user->user_type == 'admin') {
            $instruments = $user->instruments;
            return response()->json(['instruments' => $instruments], 200);
        }
        return response()->json(['message' => 'No tienes permiso para acceder a esta ruta.'], 403);
    }

}
