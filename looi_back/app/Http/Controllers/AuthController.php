<?php

namespace App\Http\Controllers;

use App\Helpers\JsonHelper;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(public readonly AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->attemp($request->only('email', 'password'));
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
        return JsonHelper::success([
            'user' => $this->authService->user(),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                ]
            ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        list($user, $token) = $this->authService->register($request->validated());
        return JsonHelper::success([
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                ]
            ], Response::HTTP_OK);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return JsonHelper::success(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        return JsonHelper::success([
            'user' => $this->authService->user(),
            'authorisation' => [
                'token' => $this->authService->refresh(),
                'type' => 'bearer',
            ]]);
    }
}
