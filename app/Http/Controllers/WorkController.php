<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\Http\Controllers\AttendanceController;

class WorkController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function show(Request $request)
    {
        $attendance = app()->make(AttendanceController::class);
        $attendance->my_attendance($request);
    }
}
