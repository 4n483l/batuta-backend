<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            // Comprobar si el usuario tiene un estudiante asociado
            $isStudent = $user->user_type === 'member' && $user->students()->exists();

            return response()->json([
                'message' => 'Login correcto!',
                'token' => $token,
                'id' => $user->id,
                'user_type' => $user->user_type,
                'is_student' => $isStudent, // Devuelves si tiene estudiantes asociados
                'role' => $user->role,
            ], 200);
        }

        return response()->json(['message' => 'Las credenciales no son válidas'], 401);
    }
}
