<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $user): array
    {
        $user = User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);
        $token = Auth::login($user);
        return [$user, $token];
    }

    public function attemp(array $credentials): string
    {
        return Auth::attempt($credentials);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function refresh(): string
    {
        return Auth::refresh();
    }

    public function user(): Authenticatable|null
    {
        return Auth::user();
    }
}
