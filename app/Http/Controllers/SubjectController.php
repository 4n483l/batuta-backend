<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Instrument;

class SubjectController extends Controller
{
    /* --------- SUBJECTS --------------- */
    public function index()
    {
        $subjects = Subject::all();
        return response()->json(['subjects' => $subjects], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'level' => 'required',
        ]);
        $subject = Subject::create($validated);

        return response()->json([
            'message' => 'Asignatura creada correctamente.',
            'subject' => $subject
        ], 201);
    }

    public function show($id)
    {
        return Subject::findOrFail($id);
    }

    public function update( Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

         $validated  = $request->validate([
            'name' => 'required',
            'level' => 'required',
        ]);

        $subject->update($validated);
        return $subject;
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return response()->json(['message' => 'Subject deleted successfully'], 200);
    }

    /* -------------- SUBJECTS - TEACHER --------------- */

    public function getTeacherSubjects()
    {
        $user = auth()->user();
        if ($user->user_type == 'teacher' || $user->user_type == 'admin') {
            $subjects = $user->subjects;
            return response()->json(['subjects' => $subjects], 200);
        }
        return response()->json(['message' => 'No tienes permiso para acceder a esta ruta.'], 403);
    }

    public function addTeacherSubject($subjectId, $teacherId)
    {
        $subject = Subject::findOrFail($subjectId);
        $subject->users()->attach($teacherId, ['user_type' => 'teacher']); 

        return response()->json(['message' => 'Relación creada correctamente', 'subject' => $subject], 201);
    }


    public function removeTeacherSubject($subjectId, $teacherId)
    {
        $subject = Subject::findOrFail($subjectId);
        // Elimina solo la relación donde el user_type es 'teacher'
        $subject->users()->wherePivot('user_type', 'teacher')->detach($teacherId);

        return response()->json(['message' => 'Relación eliminada correctamente', 'subject' => $subject], 200);
    }
}
