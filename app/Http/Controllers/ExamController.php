<?php

namespace App\Http\Controllers;

use App\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::all();
        return response()->json(['message' => 'Lista de exámenes recuperada correctamente', 'Exams' => $exams], 200);
    }
}
