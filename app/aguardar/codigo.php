<?php

class BaseController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario está autenticado
        if (!$user) {
            return response()->json([
                'message' => 'No se encontró un usuario autenticado.'
            ], 401);
        }

        // Diferenciar por tipo de usuario
        switch ($user->user_type) {
            case 'teacher':
                return $this->getTeacherNotes($user);

                /* case 'member':
                return $this->getMemberNotes($user); */

            default:
                return response()->json([
                    'message' => 'El usuario no tiene permiso para ver notas.'
                ], 403);
        }
    }


    public function otroIndex()
    {

        $user = auth()->user();
        dd(auth()->user()->load(['subjects', 'instruments']));

        if ($user->user_type === 'member') {

            $students = $user->students;
            $apuntesAsignaturas = [];
            $apuntesInstrumentos = [];

            // Traer apuntes asociados a las asignaturas e instrumentos de los estudiantes
            foreach ($students as $student) {
                $subjectIds = $student->subjects->pluck('id')->toArray();
                $instrumentIds = $student->instruments->pluck('id')->toArray();

                if (!empty($subjectIds)) {
                    $apuntes = Note::whereIn('subject_id', $subjectIds)->get();
                    $apuntesAsignaturas[$student->id] = $apuntes;
                }

                if (!empty($instrumentIds)) {
                    $apuntes = Note::whereIn('instrument_id', $instrumentIds)->get();
                    $apuntesInstrumentos[$student->id] = $apuntes;
                }
            }
            return response()->json([
                'message' => 'Lista de asignaturas y apuntes recuperada correctamente.',

                'apuntesAsignaturas' => $apuntesAsignaturas,
                'apuntesInstrumentos' => $apuntesInstrumentos
            ], 200);
        } else {
            return response()->json([
                'message' => 'El usuario no tiene permiso para ver apuntes.'
            ], 403);
        }
    }
}
