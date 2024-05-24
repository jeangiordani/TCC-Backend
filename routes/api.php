<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MockExamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->prefix('auth')->group(
    function () {
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:api');
        Route::post('refresh', 'refresh')->middleware('auth:api');
        Route::post('me', 'me')->middleware('auth:api');
    }
);

Route::controller(MockExamController::class)->group(function () {
    // Route::get('mock-exams', 'index');
    // Route::get('mock-exams/{id}', 'show');
    Route::post('mock-exams', 'store');
    // Route::put('mock-exams/{id}', 'update');
    // Route::delete('mock-exams/{id}', 'destroy');
});
