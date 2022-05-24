<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register']]);
    }

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

    public function show(Request $request)
    {
        $id = $request->id;
        $worker = User::where('id', $id)->get();

        if (!$worker) {
            return response()->json(['message' => 'No such worker'], 404);
        }

        return response()->json(['worker' => $worker], 200);
    }

    public function update(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ];

        $user = User::where('id', $request->id)->update($data);

        if(!$user) {
            return response()->json(['message' => 'update error']);
        }

        return response()->json(['message' => 'successfully']);

    }

    public function destroy(Request $request)
    {
        User::where('id', $request->id)->delete();

        return response()->json(['message' => 'delete successfully'], 200);
    }

}
