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
            // Obtener el usuario autenticado
            $user = Auth::user();
            // Generar un token para el usuario si estás usando Sanctum
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json(['message' => 'Login correcto!', 'token' => $token], 200);
        }

        return response()->json(['message' => 'Las credenciales no son válidas'], 401);
    }
}
