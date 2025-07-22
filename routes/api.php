<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['log.execution'])->group(function(){
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');
Route::middleware(['auth:sanctum'])->group(function () {
Route::post('/tasks', [TaskController::class, 'store']);            // Create task
Route::put('/tasks/{id}/assign', [TaskController::class, 'assign']); // Assign task  
});
Route::put('/tasks/{id}/complete', [TaskController::class, 'complete']); // Complete task
Route::get('/tasks', [TaskController::class, 'index']);             // List tasks
});