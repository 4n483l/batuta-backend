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
