<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/student', [StudentController::class, 'index']);
Route::get('/student/{id}', [StudentController::class, 'get_student']);
Route::post('/studentCreate', [StudentController::class, 'student_save']);
Route::patch('/studentUpdate/{id}', [StudentController::class, 'update_student']);
Route::delete('/studentDelete/{id}', [StudentController::class, 'delete_student']);