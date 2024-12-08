<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // El admin tiene acceso a todos los cursos
            $courses = Course::with(['subject', 'instrument', 'user'])->get();
            return response()->json(['message' => 'Lista de clases recuperada correctamente', 'Courses' => $courses], 200);
        } elseif ($user->user_type === 'teacher') {
            // El profesor tiene acceso a los cursos en los que imparte clases
            $courses = Course::where('user_id', $user->id)
                ->with(['subject', 'instrument'])
                ->get();
            return response()->json(['message' => 'Cursos del profesor recuperados correctamente', 'Courses' => $courses], 200);
        } elseif ($user->user_type === 'member') {
            $students = $user->students;

            // $courses = collect();
            $coursesByStudent = [];

            foreach ($students as $student) {

                $studentCourses = Course::whereHas('subject', function ($query) use ($student) {
                    $query->whereHas('students', function ($query) use ($student) {
                        $query->where('student_id', $student->id);
                    });
                })
                    ->orWhereHas('instrument', function ($query) use ($student) {
                        $query->whereHas('students', function ($query) use ($student) {
                            $query->where('student_id', $student->id);
                        });
                    })
                    ->with(['subject', 'instrument'])
                    ->get();

                $coursesByStudent[$student->id] = $studentCourses;
                //$courses = $courses->merge($studentCourses);
            }

            return response()->json(['message' => 'Cursos por estudiante recuperados correctamente', 'Courses' => $coursesByStudent], 200);
        } else {
            return response()->json(['message' => 'El usuario no tiene permiso para ver esta información.'], 403);
        }
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
        $course = Course::create($validated);

        return response()->json([
            'message' => 'Clase creada exitosamente.',
            'course' => $course
        ], 201);
    }

    public function show($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Clase no encontrada.'], 404);
        }
        return response()->json(['message' => 'Clase recuperada correctamente', 'course' => $course], 200);
    }

    public function update(Request $request, $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Clase no encontrada.'], 404);
        }

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

        $course->update($validated);

        return response()->json([
            'message' => 'Clase actualizada exitosamente.',
            'course' => $course
        ], 200);
    }

    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Clase no encontrada.'], 404);
        }
        $course->delete();
        return response()->json(['message' => 'Clase eliminada correctamente'], 200);
    }
}
