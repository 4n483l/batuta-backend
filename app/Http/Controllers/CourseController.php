<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['subject', 'instrument', 'user'])->get();
        return response()->json(['message' => 'Lista de clases recuperada correctamente', 'Courses' => $courses], 200);
}


    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'subject_id' => 'nullable|exists:subjects,id',
            'instrument_id' => 'nullable|exists:instruments,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'hour' => 'required|string',
            'classroom' => 'nullable|string|max:255',
        ]);

        // Validar la restricción: al menos uno entre subject_id o instrument_id debe estar presente
        if (is_null($validated['subject_id']) && is_null($validated['instrument_id'])) {
            return response()->json([
                'message' => 'Debe proporcionar subject_id o instrument_id, pero no ambos a la vez.'
            ], 422);
        }

        if (!is_null($validated['subject_id']) && !is_null($validated['instrument_id'])) {
            return response()->json([
                'message' => 'Debe proporcionar subject_id o instrument_id, pero no ambos a la vez.'
            ], 422);
        }

        // Crear el curso
        $course = Course::create($validated);

        return response()->json([
            'message' => 'Clase creada exitosamente.',
            'course' => $course
        ], 201);
    }
}


