<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuition;

class TuitionsController extends Controller
{
    public function store(Request $request)
    {
        // Validamos los datos del formulario
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:tuitions,email',
            'phone_number' => 'required|string|max:20',
            'subjects' => 'required|array', // Validamos que sea un array
            'subjects.*' => 'string', // Cada asignatura debe ser una cadena de texto
        ]);

        // Creamos un nuevo registro en la tabla `tuitions`
        Tuition::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'birth_date' => $validatedData['birth_date'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'subjects' => json_encode($validatedData['subjects']), // Convertimos el array a JSON
        ]);

        return response()->json(['message' => 'Matrícula creada exitosamente.']);
    }
}
