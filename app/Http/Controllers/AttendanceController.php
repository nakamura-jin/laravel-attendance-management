<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yasumi\Yasumi;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

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
            $item->end_time = Carbon::parse($item->end_time)->format('H:i');
            $item->breake_time = Carbon::parse($item->breake_time)->format('H:i');
        }
        return response()->json(['attendance' => $attendance]);
    }
}
