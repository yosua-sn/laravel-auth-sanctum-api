<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $validations = $request->validated();

        $user = User::create($validations);

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'message' => 'Register successfully',
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request){
        $validations = $request->validated();

        $user = User::where('email', $validations['email'])->first();

        if (!$user || !Hash::check($validations['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'message' => 'Login successfully',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successfully'
        ], 200);
    }


}
