<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AutenticarController extends Controller
{
    public function registro(RegistroRequest $request)
    {
        $user = new User();
        $user->name = $request->name; 
        
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'res' => true,
            'message' => 'Usuario registrado',
        ],200);
    }

    public function showUsers(PersonalAccessToken $token)
    {
        return response()->json([
            'token' => PersonalAccessToken::all(),
            'token' => $token->all(),
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas'],
            ]);
        }
       $token = $user->createToken($request->email)->plainTextToken;

       return response()->json([
            'res' => true,
            'token' => $token,
            'Usuario' => $user->name,
            'Correo' => $user->email,
            'Password' => $user->password,
       ]);
    }
    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'res' => true,
            'token' => 'Token eliminado correctamente',
        ]);
    }
}
