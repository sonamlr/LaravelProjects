<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController; 
use App\Http\Controllers\UserController; 


Route::post('/signup', [UserController::class, 'signup']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
Route::get('/student', [StudentController::class, 'index']);
Route::get('/student/{id}', [StudentController::class, 'get_student']);
Route::post('/student', [StudentController::class, 'student_save']);
Route::put('/student/{id}', [StudentController::class, 'update_student']);
Route::delete('/student/{id}', [StudentController::class, 'delete_student']);
Route::get('/student/search/{city}', [StudentController::class, 'search']);

//logout route

Route::post('/logout', [UserController::class, 'logout']);
});