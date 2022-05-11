<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('user', [AuthController::class, 'me']);
Route::post('logout', [AuthController::class, 'logout']);

Route::post('register', [UserController::class, 'register']);

Route::get('holiday', [AttendanceController::class, 'check_holiday']);
Route::get('attendance', [AttendanceController::class, 'my_attendance']);

