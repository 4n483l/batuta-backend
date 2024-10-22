<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exams;

class ExamsController extends Controller
{
    public function index()
    {
        $exams = Exams::all();
        return response()->json(['message' => 'Lista de exámenes recuperada correctamente', 'Exámenes' => $exams], 200);
    }
}
