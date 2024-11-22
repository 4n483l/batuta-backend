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
            'dni' => 'nullable|string|max:9',
            'phone' => 'required|regex:/^(\+?[0-9]{1,3})?[-. ]?\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{3,4}$/',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:5',
            'birth_date' => 'required|date',
            'email' => 'required|email',
            'subjects' => 'required|array', // Asegurarse de que es un array
            'subjects.*' => 'exists:subjects,id', // Cada subject_id debe existir en la tabla de subjects
            'instrument' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), ], 422);
        }
        $validatedData = $validator->validated();

        // TODO: revisar dni para no cambiar datos a la hora de la matricula

        // se comprueba si el DNI ya existe en la base de datos o no para saber si crear usuario nuevo o actualizar uno existente
        if ($validatedData['dni'] && ChildStudent::where('dni', $validatedData['dni'])->exists()) {
            return response()->json([
                'error' => 'Ya existe un estudiante con ese DNI en la base de datos.',
            ], 409);
        }
        // Verificar coincidencias aproximadas
        $existingStudent = ChildStudent::where('birth_date', $validatedData['birth_date'])
            ->where('user_id', $authenticatedUser->id)
            ->where(function ($query) use ($validatedData) {
                // Comprobación de coincidencia parcial en 'name' (cualquier palabra)
                $query->where(function ($subQuery) use ($validatedData) {
                    foreach (explode(' ', $validatedData['name']) as $namePart) {
                        $subQuery->orWhere('name', 'LIKE', '%' . $namePart . '%');
                    }
                });
                // Comprobación de coincidencia parcial en 'lastname'
                $query->where(function ($subQuery) use ($validatedData) {
                    foreach (explode(' ', $validatedData['lastname']) as $lastnamePart) {
                        $subQuery->where('lastname', 'LIKE', '%' . $lastnamePart . '%');
                    }
                });
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
            ], 409);
        }

        // Crear un nuevo registro de estudiante
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

        $child->subjects()->syncWithoutDetaching($validatedData['subjects']);
        $child->instruments()->syncWithoutDetaching([
            'name' => $validatedData['instrument']
        ]);

        // Recuperar las asignaturas asociadas al usuario junto con los instrumentos
        $subjects = $child->subjects()->with('instruments')->get();
        // Devolver la respuesta con las asignaturas e instrumentos
        return response()->json([
            'message' => 'Matrícula creada exitosamente.',
            'data' => [
                'child' => $child,
                'subjects' => $subjects
            ]
        ], 201);
    }

    public function show()
    {
        $user = Auth::user();
        $userFields = [
            'phone' => $user->phone,
            'address' => $user->address,
            'city' => $user->city,
            'postal_code' => $user->postal_code,
            'email' => $user->email
        ];
        // Obtener las asignaturas asociadas al usuario
        $subjects = $user->subjects()->with('instruments')->get();


        return response()->json([
            'message' => 'Usuario actual.',
            'usuario' => $userFields,
            'asignaturas' => $subjects
        ], 200);
    }
}
