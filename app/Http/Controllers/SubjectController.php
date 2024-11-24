<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Instrument;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return response()->json(['subjects' => $subjects], 200);
    }


    public function instruments()
    {
        // se obtienen los instrumentos de la asignatura "Instrumentos", pero el nombre que va entre comillas es la variable que irá en ANgular
        $instruments = Instrument::all();
        return response()->json(['instruments' => $instruments], 200);
    }
}
