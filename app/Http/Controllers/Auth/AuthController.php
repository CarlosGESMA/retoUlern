<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Registro
    public function register(Request $request)
    {
        // Validación de los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'numeroTelefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // password_confirmation es necesario
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $validated['name'],
            'apellido' => $validated['apellido'],
            'numeroTelefono' => $validated['numeroTelefono'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Opcional: puedes devolver una respuesta con los datos del usuario registrado o un mensaje
        return response()->json(['message' => 'Usuario registrado correctamente', 'user' => $user], 201);
    }

    // Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            return response()->json([
                'token' => $user->createToken('YourAppName')->plainTextToken,
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // Obtener datos del usuario
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Logout
    public function logout(Request $request)
    {
        auth()->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully']);
    }
}
