<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Subject;
use Barryvdh\DomPDF\Facade as PDF;

class NoteController extends Controller
{

    public function index()
    {
        $notes = Note::all();
        return response()->json(['message' => 'Lista de notas recuperada correctamente', 'Notes' => $notes], 200);
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

        if($request->input('subject_id') && $request->input('instrument_id')){
            return response()->json(['message' => 'No se puede asignar un apunte a una asignatura e instrumento al mismo tiempo.'], 400);
        }

        if ($request->hasFile('pdf')){
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

    /*  public function generatePdf(Request $request)
    {
        $note = Note::find($request->id);
        if (!$note) {
            return response()->json(['message' => 'Apunte no encontrado.'], 404);
        }

        $pdf = PDF::loadView('pdf_template', compact('note'));

        $fileName = 'note_' . $note->id . '.pdf';
        $path = storage_path('app/public/notes/' . $fileName);
        $pdf->save($path);

        return response()->json(['pdf_url' => asset('storage/notes/' . $fileName)]);
    }
 */

}
