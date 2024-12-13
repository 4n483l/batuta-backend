<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->user_type === 'teacher') {
            return $this->getTeacherNotes($user);
        } elseif ($user->user_type === 'member') {
            return $this->getStudentNotes($user);
        } else {
            return response()->json(['message' => 'El usuario no tiene permiso para ver esta información.'], 403);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'content' => 'required|string',
            'subject_id' => 'nullable|exists:subjects,id',
            'instrument_id' => 'nullable|exists:instruments,id',
            'pdf' => 'nullable|file'
        ]);

        if ($request->input('subject_id') && $request->input('instrument_id')) {
            return response()->json(['message' => 'No se puede asignar un apunte a una asignatura e instrumento al mismo tiempo.'], 400);
        }

        if ($request->hasFile('pdf') && $request->file('pdf')->isValid()) {
            // Generar un nombre personalizado para el archivo PDF
            $fileName = time() . '-' . preg_replace('/[^a-zA-Z0-9]/', '-', $validated['title']) . '.pdf';

            $path = $request->file('pdf')->storeAs('notes', $fileName, 'public');

            if (!$path) {
                return response()->json(['message' => 'Error al guardar el archivo PDF.'], 500);
            }

            $note = Note::create([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'topic' => $validated['topic'],
                'content' => $validated['content'],
                'subject_id' => $validated['subject_id'] ?? null,
                'instrument_id' => $validated['instrument_id'] ?? null,
                'pdf' => $path ?? null
            ]);

            return response()->json([
                'message' => 'Apunte creado exitosamente. Edite antes de guardar como PDF.',
                'note' => $note
            ], 201);
        }
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);

        return response()->json([
            'message' => 'Apunte recuperado correctamente.',
            'note' => $note
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'content' => 'required|string',
            'subject_id' => 'nullable|exists:subjects,id',
            'instrument_id' => 'nullable|exists:instruments,id',
            'pdf' => 'nullable|file'
        ]);

        if ($request->hasFile('pdf')) {
            // Generar un nombre personalizado para el archivo PDF
            $fileName = time() .  '-' . $validated['title']  .  '.pdf';
            $path = $request->file('pdf')->storeAs('notes', $fileName, 'public');
        }

              $note->update([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'topic' => $validated['topic'],
            'content' => $validated['content'],
            'subject_id' => $validated['subject_id'] ?? null,
            'instrument_id' => $validated['instrument_id'] ?? null,
            'pdf' => $path ?? null
        ]);

       // $note->update($validated);

        return response()->json([
            'message' => 'Apunte actualizado exitosamente.',
            'note' => $note
        ], 200);
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return response()->json(['message' => 'Apunte eliminado correctamente.'], 200);
    }

    private function getTeacherNotes($user)
    {
        // Obtener IDs de asignaturas e instrumentos relacionados al teacher
        $subjectIds = $user->subjects()->pluck('subjects.id');
        $instrumentIds = $user->instruments()->pluck('instruments.id');

        if ($subjectIds->isEmpty() && $instrumentIds->isEmpty()) {
            return response()->json([
                'message' => 'El profesor no tiene asignaturas ni instrumentos asociados.',
                'NotesTeacher' => []
            ], 200);
        }
        $notes = Note::with(['subject', 'instrument']) // Carga los datos relacionados
            ->where(function ($query) use ($subjectIds, $instrumentIds) {
                $query->whereIn('subject_id', $subjectIds)
                    ->orWhereIn('instrument_id', $instrumentIds);
            })
            ->get();

        if ($notes->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron apuntes asociados a las asignaturas o instrumentos del profesor.',
                'NotesTeacher' => []
            ], 200);
        }
        return response()->json([
            'message' => 'Apuntes del profesor recuperadas correctamente.',
            'NotesTeacher' => $notes
        ], 200);
    }


    private function getStudentNotes($user)
    {
        $students = $user->students()->get();
        $studentNotes = [];

        foreach ($students as $student) {
            $subjectIds = $student->subjects()->pluck('subjects.id');
            $instrumentIds = $student->instruments()->pluck('instruments.id');

            if ($subjectIds->isEmpty() && $instrumentIds->isEmpty()) {
                continue; // si el estudiante no tiene asignaturas ni instrumentos, continuar con el siguiente estudiante
            }

            $notes = Note::with(['subject', 'instrument'])
                ->where(function ($query) use ($subjectIds, $instrumentIds) {
                    $query->whereIn('subject_id', $subjectIds)
                        ->orWhereIn('instrument_id', $instrumentIds);
                })
                ->get();

            $studentNotes[$student->id] = $notes;
        }

        if (empty($studentNotes)) {
            return response()->json([
                'message' => 'No se encontraron notas asociadas a los estudiantes del miembro.',
                'notesStudent' => []
            ], 200);
        }
        return response()->json([
            'message' => 'Notas del miembro recuperadas correctamente.',
            'notesStudent' => $studentNotes
        ], 200);
    }
/*
    public function getSubjectsAndInstruments()
    {
        $user = auth()->user();

        if ($user->user_type === 'teacher') {
            $subjects = $user->subjects()->get();
            $instruments = $user->instruments()->get();

            return response()->json([
                'message' => 'Asignaturas e instrumentos recuperados correctamente.',
                'subjects' => $subjects,
                'instruments' => $instruments,
            ], 200);
        }

        return response()->json(['message' => 'El usuario no tiene permiso para ver esta información.'], 403);
    } */
}
