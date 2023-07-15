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
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// USERS CONTROLLER
Route::get('/users', [UserController::class, 'getAllUsers'])->middleware('auth:sanctum', 'isAdmin');
Route::get('/patients', [UserController::class, 'getAllPatients']);
Route::get('/doctors', [UserController::class, 'getAllDoctors']);
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:sanctum');
Route::post('/user', [UserController::class, 'createUser'])->middleware('auth:sanctum');
Route::put('/users/{id}', [UserController::class, 'updateUser'])->middleware('auth:sanctum', 'isAdmin');
Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->middleware('auth:sanctum', 'isAdmin');

// TREATMENTS CONTROLLER
Route::get('/treatments', [TreatmentController::class, 'getAllTreatments']);
Route::post('/treatment', [TreatmentController::class, 'createTreatment'])->middleware('auth:sanctum');
Route::put('/treatments/{id}', [TreatmentController::class, 'updateTreatment'])->middleware('auth:sanctum');
Route::delete('/treatments/{id}', [TreatmentController::class, 'deleteTreatment'])->middleware('auth:sanctum', 'isAdmin');

// APPOINTMENT CONTROLLER
Route::get('/appointments', [AppointmentController::class, 'getAllAppointments'])->middleware('auth:sanctum', 'isAdmin');
Route::get('/appointments/{id}', [AppointmentController::class, 'getMyAppointment'])->middleware('auth:sanctum');
Route::post('/appointment', [AppointmentController::class, 'createAppointment'])->middleware('auth:sanctum');
Route::put('/appointments/{id}', [AppointmentController::class, 'updateAppointment'])->middleware('auth:sanctum');
Route::delete('/appointments/{id}', [AppointmentController::class, 'deleteAppointment'])->middleware('auth:sanctum');



