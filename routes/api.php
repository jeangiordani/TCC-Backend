<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\KnowledgeAreaController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MockExamController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(MediaController::class)->group(function () {
    Route::get('medias', 'index');
});

Route::controller(AuthController::class)->prefix('auth')->group(
    function () {
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:api');
        Route::post('refresh', 'refresh')->middleware('auth:api');
        Route::post('me', 'me')->middleware('auth:api');
        Route::post('register', 'register');
    }
);

Route::controller(MockExamController::class)->group(function () {
    Route::get('mock-exams', 'index')->middleware('auth:api');
    Route::get('mock-exams/{id}', 'show')->middleware('auth:api');
    Route::get('mock-exams/{id}/question/{questionId}', 'showByQuestion')->middleware('auth:api');
    Route::get('mock-exams/{id}/answers', 'mockExamById')->middleware('auth:api');
    Route::post('mock-exams', 'store')->middleware('auth:api');
    Route::patch('/mock-exams/answers/{answer}', 'markAnswer')->middleware('auth:api');
    // Route::delete('mock-exams/{id}', 'destroy');
});

Route::controller(KnowledgeAreaController::class)->group(function () {
    Route::get('knowledge-areas', 'index');
});

Route::controller(CommentController::class)->group(function () {
    Route::get('comments/{questionId}', 'index')->middleware('auth:api');
    Route::post('comments', 'store')->middleware('auth:api');
    // Route::delete('comments/{id}', 'destroy');
});

Route::controller(UserController::class)->group(function () {
    Route::get('users/stats', 'stats')->middleware('auth:api');

});

