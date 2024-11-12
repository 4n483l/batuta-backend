<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ChildStudent;
use App\Models\User;

class TuitionController extends Controller
{
    public function store(Request $request)
    {
        $authenticatedUser = Auth::user();

        // Asegurarse que el usuario autenticado es de tipo 'member'
        if ($authenticatedUser->user_type !== 'member') {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        // Validar datos del formulario de matrícula
        $validator  =  Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dni' => 'nullable|string|max:9', // dni puede ser null o string
            'phone' => 'required|regex:/^(\+?[0-9]{1,3})?[-. ]?\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{3,4}$/',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:5',
            'birth_date' => 'required|date',
            'email' => 'required|email',
            'subjects' => 'required|array', // Asegurarse de que es un array
            'subjects.*' => 'exists:subjects,id', // Cada subject_id debe existir en la tabla de subjects
        ]);
        // Si la validación falla, devolver los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), ], 422);
        }
        // Obtener los datos validados
        $validatedData = $validator->validated();

        // Verificar si existe un alumno con los mismos datos dentro del contexto del padre (user_id)
        /*   $existingStudent = ChildStudent::where([
            ['name', $validatedData['name']],
            ['lastname', $validatedData['lastname']],
            ['birth_date', $validatedData['birth_date']],
            ['user_id', $authenticatedUser->id],
        ])->first();

        if ($existingStudent) {
            return response()->json(['error' => 'El alumno ya está matriculado.'], 409);
        }*/

        // Verificar coincidencias aproximadas
        $existingStudent = ChildStudent::where('birth_date', $validatedData['birth_date'])
            ->where('user_id', $authenticatedUser->id)
            ->where(function ($query) use ($validatedData) {
                $query->where('name', 'LIKE', '%' . $validatedData['name'] . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $validatedData['lastname'] . '%');
            })
            ->first();

        // Si se encuentra un estudiante coincidente, enviar mensaje al usuario
        if ($existingStudent) {
            return response()->json([
                'error' => 'Ya existe un alumno con datos similares. Póngase en contacto con la entidad para más información.',
                'existing_student' => [
                    'name' => $existingStudent->name,
                    'lastname' => $existingStudent->lastname,
                    'birth_date' => $existingStudent->birth_date,
                    'dni' => $existingStudent->dni,
                ]
            ], 409); // Código 409 para conflicto
    }

        if ($validatedData['dni']) {
            $user = User::where('dni', $validatedData['dni'])->first();
        } else {
            $user = null;
    }

        if ($user) {
            // Comprobar si los datos han cambiado
            $changes = [];
            foreach (['name', 'lastname', 'phone', 'address', 'city', 'postal_code', 'birth_date'] as $field) {
                if ($user->$field !== $validatedData[$field]) {
                    $changes[$field] = $validatedData[$field];
                }
            }

            // Si hay cambios, actualizar datos y cambiar tipo de usuario a 'student'
            if (!empty($changes)) {
                $changes['user_type'] = 'student';
                $user->update($changes);
            }
            // Agregar asignaturas al usuario
            $user->subjects()->syncWithoutDetaching($validatedData['subjects']);
        } else {
            // Crear un nuevo usuario si el DNI no existe
            $child = ChildStudent::create([
                'name' => $validatedData['name'],
                'lastname' => $validatedData['lastname'],
                'dni' => $validatedData['dni'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'postal_code' => $validatedData['postal_code'],
                'birth_date' => $validatedData['birth_date'],
                'email' => $validatedData['email'],
                'user_id' => $authenticatedUser->id, // foreign key al miembro autenticado
            ]);

            // Agregar asignaturas al nuevo usuario
            $child->subjects()->attach($validatedData['subjects']);
        }

        return response()->json(['message' => 'Matrícula creada exitosamente.',  'data' => $child], 201);
    }

    public function show()
    {
        // Obtenemos los datos del usuario actualmente autenticado
        $user = Auth::user();
        return response()->json(['message' => 'Usuario actual.', $user]);
    }
}
