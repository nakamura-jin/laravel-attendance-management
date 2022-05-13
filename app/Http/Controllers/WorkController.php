<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Http\Requests\WorkRequest;

class WorkController extends Controller
{
    public function start(WorkRequest $request)
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

        if(!$attendance) {
            return response()->json(['message' => 'error'], 404);
        }

        return response()->json(['message' => 'successfully'], 200);
    }

}