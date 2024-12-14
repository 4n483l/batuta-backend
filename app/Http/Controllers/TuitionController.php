<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
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
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
            'instrument' => 'required|string|max:255',
        ]);



        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), ], 422);
        }
        $validatedData = $validator->validated();

        if ($validatedData['dni'] && Student::where('dni', $validatedData['dni'])->exists()) {
            return response()->json([
                'error' => 'Ya existe un estudiante con ese DNI en la base de datos.',
            ], 409);
        }
        // Verificar coincidencias aproximadas
        $existingStudent = Student::where('birth_date', $validatedData['birth_date'])
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
        $student = Student::create([
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

        $student->subjects()->syncWithoutDetaching($validatedData['subjects']);
        $instrumentName = strval($validatedData['instrument']);
        $student->instruments()->syncWithoutDetaching([
            'name' => $instrumentName
            //'name' => $validatedData['instrument']
        ]);

        return response()->json([
            'message' => 'Matrícula creada exitosamente.',
            'data' => [
                'student' => $student,
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

        return response()->json([
            'message' => 'Usuario actual.',
            'usuario' => $userFields,

        ], 200);
    }
}
