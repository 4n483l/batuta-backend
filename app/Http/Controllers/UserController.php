<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;

class UserController extends Controller
{
    public function getNavbar()
    {
        return auth()->user();
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // El admin tiene acceso a todos los usuarios
            $users = User::all();
            return response()->json(['message' => 'Lista de usuarios recuperada correctamente', 'Users' => $users], 200);
        } elseif ($user->user_type === 'teacher') {
            $students = $user->students;
            return response()->json(['message' => 'Estudiantes del profesor recuperados correctamente', 'Students' => $students], 200);
        }elseif ($user->user_type === 'musician'){
            return response()->json([
                'message' => 'Información del usuario autenticado',
                'User' => $user
            ], 200);
        } else {
            return response()->json(['message' => 'El usuario no tiene permiso para ver esta información.'], 403);
        }
    }

    public function show($id)
    {
        // Verifica si el usuario existe
        $user = User::find($id);

        if ($user) {
            return response()->json(['message' => 'Usuario recuperado correctamente', 'User' => $user], 200);
        }

        return response()->json(['message' => 'Usuario no encontrado (show)'], 404);
    }


    public function store(Request $request)
    {
        // Valida los datos que llegan en la solicitud
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Crea el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        // Validar solo los campos que pueden ser modificados
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'dni' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'user_type' => 'nullable|string|in:musician,member,teacher',
        ]);

        // Buscar el usuario a actualizar
        $user = User::find($id);

        if ($user) {
            // Actualizar los campos solo si se enviaron
            $user->update($validated);

            return response()->json([
                'message' => 'Usuario actualizado correctamente',
                'User' => $user
            ], 200);
        }

        return response()->json(['message' => 'Usuario no encontrado'], 404);
}






    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();

            return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
        }

        return response()->json(['message' => 'Usuario no encontrado (destroy)'], 404);
    }

    /* ******    PROFESORES   ******** */

    public function indexTeachers()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $teachers = User::where('user_type', 'teacher')->get();
            return response()->json([
                'message' => 'Lista de profesores recuperada correctamente',
                'Teachers' => $teachers
            ], 200);
        } else {
            return response()->json([
                'message' => 'No tienes permisos para acceder a esta información.'
            ], 403);
    }
}



    /* ******    ESTUDIANTES   ******** */

    public function indexStudents()
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            $students = Student::with('user')->get();
            return response()->json([
                'message' => 'Lista de estudiantes recuperada correctamente',
                'Students' => $students
            ], 200);
        } else {
            return response()->json([
                'message' => 'No tienes permisos para acceder a esta información.'
            ], 403);
        }
    }

    public function showStudent($id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'message' => 'Estudiante recuperado correctamente',
                'Student' => $student
            ], 200);
        }

        return response()->json(['message' => 'Estudiante no encontrado'],404);
    }

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dni' => 'nullable|string|max:20',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255',
            'user_id' => 'required|exists:users,id',
    ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Estudiante creado correctamente',
            'Student' => $student
        ],
        201);
    }

    public function updateStudent(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'dni' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'email' => 'nullable|string|email|max:255,' . $id,
            'user_id' => 'nullable|exists:users,id',
    ]);
        $student = Student::find($id);

        if ($student) {
            $student->update($validated);

            return response()->json([
                'message' => 'Estudiante actualizado correctamente',
                'Student' => $student
            ], 200);
        }

        return response()->json(['message' => 'Estudiante no encontrado'],404);
    }

    public function destroyStudent($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->delete();

            return response()->json([
                'message' => 'Estudiante eliminado correctamente'
            ], 200);
        }

        return response()->json(['message' => 'Estudiante no encontrado'], 404);
}
    // Obtiene los estudiantes asociados al usuario autenticado
    public function getStudentsAssociate(Request $request)
    {
        return $request->user()->students;
    }

}
