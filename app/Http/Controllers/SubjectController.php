<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Instrument;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return response()->json(['subjects' => $subjects], 200);
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'level' => 'required',
        ]);

        $subject = Subject::create($data);
        return response()->json(['subject' => $subject], 201);
    }

    public function show($id)
    {
        $subject = Subject::findOrFail($id);
        return response()->json(['subject' => $subject], 200);
    }

    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required',
            'level' => 'required',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($data);
        return response()->json(['subject' => $subject], 200);
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return response()->json(['message' => 'Subject deleted successfully'], 200);
    }

    public function getTeacherSubjects()
    {
        $user = auth()->user();
        if($user->user_type == 'teacher' || $user->user_type == 'admin') {
            $subjects = $user->subjects;
            return response()->json(['subjects' => $subjects], 200);
        }
        return response()->json(['message' => 'No tienes permiso para acceder a esta ruta.'], 403);
    }


}
