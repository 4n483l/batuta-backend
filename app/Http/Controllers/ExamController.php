<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;


class ExamController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->user_type === 'teacher') {
            return $this->getExamsForTeacher($user);
        } elseif ($user->user_type === 'member') {
            return $this->getExamsForStudents($user);
        } else {
            return response()->json(['message' => 'El usuario no tiene permiso para ver esta información.'], 403);
        }
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
        $exam = Exam::create($validated);

        return response()->json([
            'message' => 'Examen creado exitosamente.',
            'exam' => $exam
        ], 201);
    }

    public function getExamsForTeacher($user)
    {
        $subjectIds = $user->subjects()->pluck('subjects.id');
        $instrumentIds = $user->instruments()->pluck('instruments.id');

        if ($subjectIds->isEmpty() && $instrumentIds->isEmpty()) {
            return response()->json([
                'message' => 'El profesor no tiene asignaturas ni instrumentos asociados.',
                'ExamsTeacher' => []
            ], 200);
        }

        $exams = Exam::with('subject', 'instrument', 'user')
            ->where('user_id', $user->id)
            ->where(function ($query) use ($subjectIds, $instrumentIds) {
                $query->whereIn('subject_id', $subjectIds)
                    ->orWhereIn('instrument_id', $instrumentIds)
                    ->orWhereNull('subject_id')
                    ->orWhereNull('instrument_id');
            })
            ->get();

        if ($exams->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron examenes de instrumento o asignatura del profesor.',
                'ExamsTeacherxams' => []
            ], 200);
        }
        return response()->json([
            'message' => 'Exámenes del profesor recuperadas correctamente.',
            'ExamsTeacher' => $exams
        ], 200);
    }

    public function getExamsForStudents($user)
    {
        $students = $user->students()->get();
        $studentExams = [];

        foreach ($students as $student) {
            $subjectIds = $student->subjects()->pluck('subjects.id');
            $instrumentIds = $student->instruments()->pluck('instruments.id');

            // Si el estudiante no tiene asignaturas ni instrumentos, continuar con el siguiente estudiante
            if ($subjectIds->isEmpty() && $instrumentIds->isEmpty()) {
                continue;
            }

            $exams = Exam::with(['subject', 'instrument', 'user'])
                ->where(function ($query) use ($subjectIds, $instrumentIds) {
                    $query->whereIn('subject_id', $subjectIds)
                        ->orWhereIn('instrument_id', $instrumentIds);
                })
                ->get();

            $studentExams[$student->id] = $exams;
        }

        if (empty($studentExams)) {
            return response()->json([
                'message' => 'No se encontraron exámenes asociados a los estudiantes del miembro.',
                'ExamsStudent' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Exámenes del miembro recuperados correctamente.',
            'ExamsStudent' => $studentExams
        ], 200);
    }

}
