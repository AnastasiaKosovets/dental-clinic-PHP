<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response as FacadesResponse;
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
            Log::error('Error getting treatments' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving treatments'
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
                'message' => 'Treatments retrieved',
                'data' => $treatment,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting treatments' . $th->getMessage());
            dd($th->getMessage());

            return response()->json([
                'message' => 'Error retrieving treatments'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateTreatment(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'treatmentName' => 'required|string',
                'description' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }
            $validData = $validator->validated();
            $treatment = Treatment::find($id);
            if (!$treatment) {
                return response()->json(['message' => "Treatment with id {$id} not found"], Response::HTTP_NOT_FOUND);
            }

            $treatment->update([
                'treatmentName' => $validData['treatmentName'],
                'description' => $validData['description']
            ]);
            return response()->json([
                'message' => 'Treatment updated successfully',
                'data' => $treatment,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error updating treatments: ' . $th->getMessage());

            return response()->json([
                'message' => 'Error updating treatments'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteTreatment($id)
    {
        try {
            $treatment = Treatment::find($id);

            if (!$treatment) {
                return response()->json([
                    'message' => "Treatment with id {$id} not found"
                ], Response::HTTP_NOT_IMPLEMENTED);
            }
            $treatment->delete();
            return response()->json([
                'message' => "Treatment deleted successfully",
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error deleting treatments: ' . $th->getMessage());

            return response()->json([
                'message' => 'Error deleting treatments'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
