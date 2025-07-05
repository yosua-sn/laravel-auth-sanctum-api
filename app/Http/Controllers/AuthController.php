<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $validations = $request->validated();

        $user = User::create($validations);

        $user->sendEmailVerification();

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'message' => 'Registration successful. Please check your email for verification',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function verifyemail($id, $hash){
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'message' => 'Invalid verification link.'
            ], 403);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'message' => 'Email verified successfully.'
        ], 200);
    }

    public function resendverifyemail(Request $request){
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified.'
            ], 400);
        }

        $request->user()->sendEmailVerification();

        return response()->json([
            'message' => 'Verification link has been resent.'
        ]);
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

    public function sendresetpassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email.'])
            : response()->json(['error' => __($status)], 400);
    }

    public function resetpassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password has been reset.'])
            : response()->json(['message' => __($status)], 400);
    }
}
