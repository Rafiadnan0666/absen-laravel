<?php

use App\Http\Controllers\Api\V1\AttendanceController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PayrollCalculationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public API authentication
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    // Employee endpoints - only own data
    Route::prefix('employee')->name('api.employee.')->group(function () {
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('/attendances/check-in', [AttendanceController::class, 'checkIn'])->name('attendances.checkIn');
        Route::post('/attendances/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.checkOut');
        Route::get('/attendances/{attendance}', [AttendanceController::class, 'show'])->name('attendances.show');

        Route::get('/payrolls', [PayrollCalculationController::class, 'myPayrolls'])->name('payrolls.index');
        Route::get('/payrolls/calculate', [PayrollCalculationController::class, 'calculateMyPayroll'])->name('payrolls.calculate');
    });

    // Admin/HR endpoints - full access
    Route::middleware('role:admin,hr')->prefix('admin')->name('api.admin.')->group(function () {
        Route::apiResource('attendances', AttendanceController::class)->except(['create', 'edit']);
        Route::get('attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');

        Route::post('/payrolls/calculate', [PayrollCalculationController::class, 'calculate'])->name('payrolls.calculate');
        Route::post('/payrolls/bulk-calculate', [PayrollCalculationController::class, 'bulkCalculate'])->name('payrolls.bulkCalculate');
        Route::post('/payrolls/generate-from-calculation', [PayrollCalculationController::class, 'generateFromCalculation'])->name('payrolls.generateFromCalculation');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('role');
});
