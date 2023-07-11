<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/patients', [UserController::class, 'getAllPatients']);
Route::get('/doctors', [UserController::class, 'getAllDoctors']);

Route::get('/user/{id}', function($id){
    $user = User::find($id);
    // $user = User::where('id', $id)->first();
    return $user;
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
