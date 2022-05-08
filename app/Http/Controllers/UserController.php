<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function register(UserRequest $request)
    {
        $input = $request->validated();

        $lastUser = User::orderBy('worker_id', 'desc')->first();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'role' => $input['role'],
            'worker_id' => $lastUser['worker_id'] + 1,
            'password' => $input['password'],
        ]);

        return response()->json(['data' => $user], 201);
    }
}
