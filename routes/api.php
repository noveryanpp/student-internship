<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('industries', Api\IndustryController::class);
Route::apiResource('students', Api\StudentController::class);
Route::apiResource('teachers', Api\TeacherController::class);
Route::apiResource('internships', Api\InternshipController::class);
Route::apiResource('internship-requests', Api\InternshipRequestController::class);
