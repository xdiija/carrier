<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\StatusHelper;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        if(auth()->user()->status != StatusHelper::ACTIVE){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, $this->getUserData());
    }

    public function me(): JsonResponse
    {
        return response()->json(
            $this->getUserData()
        );
    }

    protected function getUserData(): array
    {
        $user = auth()->user();

        $userData = [
            'name' => $user->name,
            'email' => $user->email
        ];

        return $userData;
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken(string $token, array $user = []): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}