<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserController;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH CONTROLLER
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// USERS CONTROLLER
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/patients', [UserController::class, 'getAllPatients']);
Route::get('/doctors', [UserController::class, 'getAllDoctors']);
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:sanctum');

Route::post('/user', [UserController::class, 'createUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
// No puedo borrar users creados con FACTORY ????????????????

// TREATMENTS CONTROLLER
Route::get('/treatments', [TreatmentController::class, 'getAllTreatments']);
Route::post('/treatment', [TreatmentController::class, 'createTreatment']);
Route::put('/treatments/{id}', [TreatmentController::class, 'updateTreatment']);
Route::delete('/treatments/{id}', [TreatmentController::class, 'deleteTreatment']);

// APPOINTMENT CONTROLLER
Route::get('/appointments', [AppointmentController::class, 'getAllAppointments']);
Route::get('/appointments/{id}', [AppointmentController::class, 'getMyAppointment']);




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
