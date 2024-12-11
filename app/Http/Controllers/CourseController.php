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
            return $this->getCoursesForAdmin();
        } elseif ($user->user_type === 'teacher') {
            return $this->getCoursesForTeacher($user);
        } elseif ($user->user_type === 'member') {
            return $this->getCoursesForStudent($user);
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

    public function getCoursesForAdmin()
    {
        $courses = Course::with(['subject', 'instrument', 'user'])->get();
        return response()->json(['message' => 'Lista de clases recuperada correctamente', 'Courses' => $courses], 200);
    }

    private function getCoursesForTeacher($user)
    {
        $subjectIds = $user->subjects()->pluck('subjects.id');
        $instrumentIds = $user->instruments()->pluck('instruments.id');

        if ($subjectIds->isEmpty() && $instrumentIds->isEmpty()) {
            return response()->json([
                'message' => 'El profesor no tiene asignaturas ni instrumentos asociados a este curso.',
                'CoursesTeacher' => []
            ], 200);
        }

        $courses = Course::with(['subject', 'instrument', 'user'])
            ->where('user_id', $user->id)
            ->where(function ($query) use ($subjectIds, $instrumentIds) {
                $query->whereIn('subject_id', $subjectIds)
                    ->orWhereIn('instrument_id', $instrumentIds)
                    ->orWhereNull('subject_id')
                    ->orWhereNull('instrument_id');
            })
            ->get();

        if ($courses->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron cursos asociados a las asignaturas o instrumentos del profesor.',
                'CoursesTeacher' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Cursos del profesor recuperados correctamente.',
            'CoursesTeacher' => $courses
        ], 200);
    }

    private function getCoursesForStudent($user)
    {
        $students = $user->students()->get();
        $studentCourses = [];

        foreach ($students as $student) {
            $subjectIds = $student->subjects()->pluck('subjects.id');
            $instrumentIds = $student->instruments()->pluck('instruments.id');

            // Si el estudiante no tiene asignaturas ni instrumentos, continuar con el siguiente estudiante
            if ($subjectIds->isEmpty() && $instrumentIds->isEmpty()) {
                continue;
            }

            $courses = Course::with(['subject', 'instrument'])
                ->where(function ($query) use ($subjectIds, $instrumentIds) {
                    $query->whereIn('subject_id', $subjectIds)
                        ->orWhereIn('instrument_id', $instrumentIds);
                })
                ->get();

            $studentCourses[$student->id] = $courses;
        }

        if (empty($studentCourses)) {
            return response()->json([
                'message' => 'No se encontraron cursos asociados a los estudiantes del miembro.',
                'CoursesStudent' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Cursos del miembro recuperados correctamente.',
            'CoursesStudent' => $studentCourses
        ], 200);
    }
}
