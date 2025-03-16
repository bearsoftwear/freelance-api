<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::apiResource('projects', \App\Http\Controllers\ProjectController::class);
    Route::apiResource('tasks', \App\Http\Controllers\TaskController::class);
    Route::apiResource('clients', \App\Http\Controllers\ClientController::class);
    Route::get('invoice/projects/{project}', [\App\Http\Controllers\InvoiceController::class, 'generate']);
    /*other*/
});
