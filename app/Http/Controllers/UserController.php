<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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

    public function createUser(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string',
                'password' => 'required|string',
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'document' => 'required|string',
                'dateOfBirth' => 'required|string',
                'address' => 'required|string',
                'telefonNumber' => 'required|integer',
                'collegialNumber' => 'required|integer',
                'role_id' => 'required'
            ]);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            };

            $validData = $validator->validated();

            $user = User::create([
                'email' => $validData['email'],
                'password' => $validData['password'],
                'firstName' => $validData['firstName'],
                'lastName' => $validData['lastName'],
                'document' => $validData['document'],
                'dateOfBirth' => $validData['dateOfBirth'],
                'address' => $validData['address'],
                'telefonNumber' => $validData['telefonNumber'],
                'collegialNumber' => $validData['collegialNumber'],
                'role_id' => $validData['role_id']
            ]);
            return response()->json([
                'message' => 'Tasks retrieved',
                'data' => $user,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting tasks' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving tasks'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
