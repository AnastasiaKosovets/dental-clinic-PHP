<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TreatmentController extends Controller
{
    public function getAllTreatments()
    {
        try {
            $treatments = Treatment::get();
            return response()->json([
                'message' => 'Treatments retrieved',
                'data' => $treatments,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting tasks' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving tasks'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createTreatment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'treatmentName' => 'required|string',
                'description' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };
            $validData = $validator->validated();

            $treatment = Treatment::create([
                'treatmentName' => $validData['treatmentName'],
                'description' => $validData['description']
            ]);
            return response()->json([
                'message' => 'Tasks retrieved',
                'data' => $treatment,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting tasks' . $th->getMessage());
            dd($th->getMessage());

            return response()->json([
                'message' => 'Error retrieving treatment'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
