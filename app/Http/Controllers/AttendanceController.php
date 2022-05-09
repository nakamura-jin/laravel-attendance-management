<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yasumi\Yasumi;

class AttendanceController extends Controller
{
    public function check_holiday()
    {
        $now = now();
        $holidays = Yasumi::create('Japan', $now->year);
        $judge = $now->isWeekend() || $holidays->isHoliday($now);
        return response()->json(['holiday' => $judge]);
    }
}
