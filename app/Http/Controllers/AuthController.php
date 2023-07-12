<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => ['required', Password::min(8)->mixedCase()->numbers()],
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'document' => 'required|string',
                'dateOfBirth' => 'required|string',
                'address' => 'required|string',
                'telefonNumber' => 'required|string',
                'collegialNumber' => 'required|integer',

            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $validData = $validator->validated();
            $newUser = User::create([
                'email' => $validData['email'],
                'password' => bcrypt($validData['password']),
                'firstName' => $validData['firstName'],
                'lastName' => $validData['lastName'],
                'document' => $validData['document'],
                'dateOfBirth' => $validData['dateOfBirth'],
                'address' => $validData['address'],
                'telefonNumber' => $validData['telefonNumber'],
                'collegialNumber' => $validData['collegialNumber'],
                'role_id' => 2
            ]);
            $token = $newUser->createToken('apiToken')->plainTextToken;

            return response()->json([
                'message' => 'User registered',
                'date' => $newUser,
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            Log::error('Error creating user' . $th->getMessage());

            return response()->json([
                'message' => 'Error creating user'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email' => 'Email or password are invalid',
                'password' => 'Email or password are invalid'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $validData = $validator->validated();
            $user = User::where('email', $validData['email'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Email or password are invalid'
                ], Response::HTTP_FORBIDDEN);
            }

            if (!Hash::check($validData['password'], $user->password)) {
                return response()->json([
                    'message' => 'Email or password are invalid'
                ], Response::HTTP_FORBIDDEN);
            }

            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json([
                'message' => 'User logged',
                'date' => $user,
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            Log::error('Error getting user' . $th->getMessage());

            return response()->json([
                'message' => 'Error creating user'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request)
    {
        try {
            $headerToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($headerToken);
            $token->delete();

            return response()->json([
                'message' => 'User logged out'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting profile' . $th->getMessage());

            return response()->json([
                'message' => 'Error getting profile'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
