<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Metodo para registrar un usuario
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|string|max:200',
            'password' => 'required|string|max:300',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return response()->json(['message' => 'Usuario creado con exito'], 201);
    }

    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:200',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // ! <-- negacion
        // || <-- or

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Las credenciales no coinciden'], 401);
        }

        return response()->json(['message' => 'Inicio de sesión exitoso', 'user' => $user]);
    }

    public function logout(Request $request)
    {
        return response()->json(['message' => 'La sesion a sidom cerrada correctamente']);
    }
}
