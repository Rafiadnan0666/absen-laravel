<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\AttendanceController as ApiAttendanceController;
use App\Http\Controllers\Api\LeaveController as ApiLeaveController;
use App\Http\Controllers\Api\PayrollController as ApiPayrollController;
use App\Http\Controllers\Api\ReimbursementController as ApiReimbursementController;
use App\Http\Controllers\Api\DepartmentController as ApiDepartmentController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $r) => $r->user()->load('role', 'department', 'jobTitle'));
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('users', ApiUserController::class);
    Route::apiResource('attendances', ApiAttendanceController::class);
    Route::apiResource('leaves', ApiLeaveController::class);
    Route::apiResource('payrolls', ApiPayrollController::class)->only(['index', 'show']);
    Route::apiResource('reimbursements', ApiReimbursementController::class);
    Route::apiResource('departments', ApiDepartmentController::class)->only(['index', 'show']);
});
