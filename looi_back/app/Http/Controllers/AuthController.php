<?php

namespace App\Http\Controllers;

use App\Helpers\JsonHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
        $user = Auth::user();
        return JsonHelper::success([
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                ]
            ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = Auth::login($user);

        return JsonHelper::success([
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                ]
            ], Response::HTTP_OK);
    }

    public function logout()
    {
        Auth::logout();
        return JsonHelper::success(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return JsonHelper::success([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]]);
    }
}
