<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Str;

class ManageTokenController extends Controller
{
    public function login(LoginRequest $request)
    {
        // Check email
        $user = User::where('document', $request->document)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $token = $user->createToken(Str::random(20))->plainTextToken;
        $permissions = collect($user->roles()->pluck('name'))
            ->merge($user->permissions()->pluck('name'));

        return response()->json([
            'user' => $user->toJson(),
            'token' => $token,
            'permissions' => $permissions->toJson()
        ], 201);
    }

    public function revoke(Request $request)
    {
        $user = $request->user();
        // Revoke token
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logged out!'
        ], 200);
    }
}
