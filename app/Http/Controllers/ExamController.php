<?php

namespace App\Http\Controllers;

use App\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['subject', 'instrument', 'user'])->get();
        return response()->json(['message' => 'Lista de exámenes recuperada correctamente', 'Exams' => $exams], 200);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'date' => 'required|date',
            'hour' => 'required|string',
            'classroom' => 'nullable|string|max:255',
            'subject_id' => 'nullable|exists:subjects,id',
            'instrument_id' => 'nullable|exists:instruments,id',
            'user_id' => 'required|exists:users,id',
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

        // Crear el examen
        $exam = Exam::create($validated);

        return response()->json([
            'message' => 'Examen creado exitosamente.',
            'exam' => $exam
        ], 201);
    }
}
