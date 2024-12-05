<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Subject;
use App\Models\Instrument;

class NoteController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->user_type === 'teacher') {

            // Obtener asignaturas e instrumentos asociados al profesor
            $subjectIds = $user->subjects()->pluck('subjects.id');
            $instrumentIds = $user->instruments()->pluck('instruments.id');

            // Traer apuntes asociados a las asignaturas e instrumentos
            $notes = Note::where(function ($query) use ($subjectIds, $instrumentIds) {
                $query->whereIn('subject_id', $subjectIds)
                    ->orWhereIn('instrument_id', $instrumentIds);
            })->get();

            return response()->json([
                'message' => 'Lista de apuntes recuperada correctamente.',
                'Notes' => $notes
            ], 200);
        } elseif ($user->user_type === 'member') {

            $students = $user->students;
            $apuntesAsignaturas = [];
            $apuntesInstrumentos = [];

            foreach ($students as $student) {

                $subjectIds = $student->subjects->pluck('id')->toArray();
                $instrumentIds = $student->instruments->pluck('id')->toArray();

                if (!empty($subjectIds)) {
                    $asignaturas[$student->id] = $subjectIds;
                    $apuntes = Note::whereIn('subject_id', $subjectIds)->get();
                    $apuntesAsignaturas[$student->id] = $apuntes;
                }

                if (!empty($instrumentIds)) {
                    $instrumentos[$student->id] = $instrumentIds;
                    $apuntes = Note::whereIn('instrument_id', $instrumentIds)->get();
                    $apuntesInstrumentos[$student->id] = $apuntes;
                }
            }

            return response()->json([
                'message' => 'Lista de asignaturas y apuntes recuperada correctamente.',

                'ApuntesAsignaturas' => $apuntesAsignaturas,
                'ApuntesInstrumentos' => $apuntesInstrumentos
            ], 200);


        } else {
            return response()->json([
                'message' => 'El usuario no tiene permiso para ver apuntes.'
            ], 403);
        }
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
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

        if ($request->hasFile('pdf')) {
            // Generar un nombre personalizado para el archivo PDF
            $fileName = time() . $validated['title'] . '-' .  '.pdf';
            $path = $request->file('pdf')->storeAs('notes', $fileName, 'public');
        }

        // Crear el apunte en la base de datos
        $note = Note::create([
            'user_id' => auth()->id(), // Asegúrate de que el usuario esté autenticado
            'title' => $validated['title'],
            'topic' => $validated['topic'],
            'content' => $validated['content'],
            'subject_id' => $validated['subject_id'] ?? null,
            'instrument_id' => $validated['instrument_id'] ?? null,
            'pdf' => $path ?? null
        ]);

        // ** Devueve una respuesta al cliente (Angular) **
        return response()->json([
            'message' => 'Apunte creado exitosamente. Edite antes de guardar como PDF.',
            'note' => $note
        ], 201);
    }


    public function getNotesForAdmin()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $notes = Note::all();

            return response()->json([
                'message' => 'Lista de apuntes recuperada correctamente.',
                'notes' => $notes
            ], 200);
        }

        return response()->json(['message' => 'El usuario no tiene permiso para ver esta información.'], 403);
    }

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
    }
}
