<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function getAllUsers(){
        try {
            $users = User::get();
            return response() ->json([
                'message' => 'Users retrieved',
                'data' => $users,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting tasks' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving tasks'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllPatients(){
        try {
            $patientId = User::where('role_id', 2)->get();
            return response()->json([
                'message' => 'Users retrieved',
                'data' => $patientId,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error getting tasks' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving tasks'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllDoctors(){
        try {
            $doctorId = User::where('role_id', 3)->get();
            return response()->json([
                'message' => 'Users retrieved',
                'data' => $doctorId,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error getting tasks' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving tasks'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserProfile($id){
        try {
            $user = User::where('user_id', $id)->get();
            return response()->json([
                'message' => 'Tasks retrieved',
                'data' => $user,
                'success' => true
,
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error getting tasks' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving tasks'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
