<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CoursesController extends Controller
{
    public function index()
    {
        $classes = Course::all();
        return response()->json(['message' => 'Lista de clases recuperada correctamente', 'Clases' => $classes], 200);
    }
}
