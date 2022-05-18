<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yasumi\Yasumi;
use App\Models\Attendance;
use App\Http\Requests\AttendanceRequest;

class AttendanceController extends Controller
{
    public function check_holiday()
    {
        $now = now();
        $holidays = Yasumi::create('Japan', $now->year);
        $judge = $now->isWeekend() || $holidays->isHoliday($now);
        return response()->json(['holiday' => $judge]);
    }

    public function my_attendance(Request $request)
    {
        $id = $request->id;
        $year = $request->year;
        $month = $request->month;
        $attendance = Attendance::where('user_id', $id)
                                ->where('year', $year)
                                ->where('month', $month)
                                ->orderBy('date', 'asc')->get();
        foreach ($attendance as $item) {
            $item->start_time = Carbon::parse($item->start_time)->format('H:i');
            if($item->end_time !== null) {
                $item->end_time = Carbon::parse($item->end_time)->format('H:i');
            }
            if($item->breake_time !== null) {
                $item->breake_time = Carbon::parse($item->breake_time)->format('H:i');
            }
        }
        return response()->json(['attendance' => $attendance]);
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
