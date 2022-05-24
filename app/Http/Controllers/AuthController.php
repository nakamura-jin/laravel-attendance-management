<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('jwt', ['except' => 'login']);
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    public function login(LoginRequest $request)
    {
        $input = $request->validated();

        $credentials = [
            'worker_id' => $input['worker_id'],
            'password' => $input['password']
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['success' => false], 401);
        }

        $token = auth()->setTTL(1)->attempt($credentials);

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $token_period = auth()->setTTL(60);
        return $this->respondWithToken(auth()->refresh($token_period));
    }

    protected function respondWithToken($token)
    {
        $user = auth()->user();
        $payload = auth()->payload();
        $token_period = $payload['exp'];
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'expires_in' => $token_period,
            'payload' => $payload,
            'user' => $user,
            // 'payload' => $token_period
        ]);
    }
}
