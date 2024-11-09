<?php

namespace App\Http\Controllers;


use App\Models\Course;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return response()->json(['message' => 'Lista de clases recuperada correctamente', 'Courses' => $courses], 200);
    }
}
