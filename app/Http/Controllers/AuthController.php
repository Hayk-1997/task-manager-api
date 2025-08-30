<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();

        if (!$user->roles()->where('name', RoleEnum::ADMIN->value)->count()) {
            throw ValidationException::withMessages([
                'message' => ['Something went wrong.'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        $cookie = cookie(
            'auth_token',
            $token,
            60*24,
            null,
            null,
            true,
            true
        );

        return response()->json('Successfully logged in')->cookie($cookie);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $cookie = Cookie::forget('auth_token');

        return response()->json(['message' => 'Logged out'])->withCookie($cookie);
    }

    public function getAuthenticatedUser(Request $request)
    {
        return response()->json($request->user());
    }
}
