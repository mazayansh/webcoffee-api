<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\UserServiceInterface;

class AuthController extends Controller
{
    public function __construct(public UserServiceInterface $userService)
    {

    }

    public function register(RegisterRequest $request)
    {
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $this->userService->register($request->validated())
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        return $this->userService->login($request->validated());
    }

    public function logout() {
        try {
            auth()->logout();

            return response()->json([
                'message' => 'User successfully signed out'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "You're already signed out"
            ], 401);
        }
    }

    public function refresh() {
        return $this->userService->refreshToken();
    }

    public function userProfile() {
        $user = auth()->user();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json([
                'message' => 'User unauthenticated'
            ], 401);
        }
    }
}
