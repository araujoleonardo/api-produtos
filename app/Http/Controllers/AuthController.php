<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ]);
    }

    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
                'message' => 'Usuário ou senha incorretos.',
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ]);
    }

    public function auth()
    {
        if (auth('sanctum')->check()) {
            return response()->json([
                'message' => 'Usuário está logado.',
                'user' => auth('sanctum')->user(),
            ]);
        } else {
            return response()->json([
                'message' => 'Usuário não logado.',
            ], 401);
        }
    }

    public function logout(Request $request){
        $user = User::findOrFail($request->user_id);

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logged out.',
        ]);
    }
}
