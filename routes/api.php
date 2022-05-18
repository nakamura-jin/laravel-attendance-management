<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\WorkController;

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

/**
 * ログイン関連
 */
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('user', [AuthController::class, 'me']);
Route::post('logout', [AuthController::class, 'logout']);

/**
 * ユーザー関連
 */
Route::post('register', [UserController::class, 'register']);
Route::get('admin/worker', [UserController::class, 'show']);
Route::put('admin/worker/{id}', [UserController::class, 'update']);


/**
 * 月別リスト
 */
Route::get('holiday', [AttendanceController::class, 'check_holiday']);
Route::get('attendance', [AttendanceController::class, 'my_attendance']);
Route::post('work_start/{id}', [AttendanceController::class, 'start']);
Route::put('work/{id}', [AttendanceController::class, 'edit']);

/**
 * 社員関連
 */
Route::get('admin/workers', [WorkController::class, 'index']);
Route::get('admin/worker_list', [WorkController::class, 'worker_attendance_list']);
Route::get('admin/worker_list/{id}', [WorkController::class, 'worker_attendance']);
Route::put('admin/worker_list/{id}', [WorkController::class, 'worker_attendance_update']);
