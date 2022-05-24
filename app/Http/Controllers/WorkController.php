<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\Http\Controllers\AttendanceController;
use App\Models\Attendance;
use Carbon\Carbon;

class WorkController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function worker_attendance_list(Request $request)
    {
        $attendance = app()->make(AttendanceController::class);
        $attendance->my_attendance($request);
    }

    public function worker_attendance(Request $request)
    {
        $id = $request->id;
        $year = $request->year;
        $month = $request->month;
        $date = $request->date;

        $attendance = Attendance::where('user_id', $id)
                                ->where('year', $year)
                                ->where('month', $month)
                                ->where('date', $date)->get();

        foreach ($attendance as $item) {
            $item->start_time = Carbon::parse($item->start_time)->format('H:i');
            if ($item->end_time !== null) {
                $item->end_time = Carbon::parse($item->end_time)->format('H:i');
            }
            if ($item->breake_time !== null
            ) {
                $item->breake_time = Carbon::parse($item->breake_time)->format('H:i');
            }
        }

        return response()->json(['attendance' => $attendance], 200);
    }

    public function worker_attendance_update(Request $request)
    {
        $id = $request->id;
        $year = $request->year;
        $month = $request->month;
        $date = $request->date;

        $data = [
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'breake_time' => $request->breake_time,
            'remarks' => $request->remarks
        ];

        $attendance = Attendance::where('user_id', $id)
                                ->where('year', $year)
                                ->where('month', $month)
                                ->where('date', $date)->update($data);
        if(!$attendance) {
            return reponse()->json(['message' => 'update error'], 404);
        }

        return response()->json(['message' => 'successfully'], 200);
    }
}
