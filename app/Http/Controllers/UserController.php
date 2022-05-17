<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
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

    public function start(AttendanceRequest $request)
    {
        $input = $request->validated();

        $start = [
            'year' => $input['year'],
            'month' => $input['month'],
            'date' => $input['date'],
            'start_time' => $input['start_time'],
            'user_id' => $input['user_id']
        ];

        $attendance = Attendance::create($start);

        if (!$attendance) {
            return response()->json(['message' => 'error'], 404);
        }

        return response()->json(['message' => 'successfully'], 200);
    }

    public function edit(Request $request)
    {
        $data = [
            'end_time' => $request->end_time,
            'breake_time' => $request->breake_time,
            'remarks' => $request->remarks,
        ];

        $attendance = Attendance::where('id', $request->id)->update($data);

        if (!$attendance) {
            return response()->json([$attendance], 404);
        }

        return response()->json(['message' => 'successfully'], 200);
    }
}
