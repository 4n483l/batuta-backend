<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dni' => 'required|string|max:255|unique:users',
            'phone' => 'required|regex:/^(\+?[0-9]{1,3})?[-. ]?\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{3,4}$/', // Formato de teléfono internacional flexible
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'string|in:admin,user',
            'user_type' => 'string|in:student,teacher,musician,member',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Creación del nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'dni' => $request->dni,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
            'user_type' => $request->user_type ?? 'student',
        ]);

        return response()->json(['message' => 'Usuario registrado satisfactoriamente!', 'user' => $user], 201);
    }
}
