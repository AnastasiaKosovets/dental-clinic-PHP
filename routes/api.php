<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// USERS CONTROLLER
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/patients', [UserController::class, 'getAllPatients']);
Route::get('/doctors', [UserController::class, 'getAllDoctors']);
// Route::get('/user/{id}', [UserController::class, 'getUserProfile']);  -> era por si se puede hacerlo en una línea solo

Route::get('/user/{id}', function($id){
    $user = User::find($id);
    return $user;
});

Route::post('/user', [UserController::class, 'createUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
// No puedo borrar users creados con FACTORY ????????????????


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
