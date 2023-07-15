<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function getAllAppointments()
    {
        try {
            $appointments = Appointment::with([
                'patient:id,firstName,lastName',
                'treatment:id,treatmentName,description',
                'doctor:id,firstName,lastName'
            ])->get();

            if ($appointments->isEmpty()) {
                return response()->json([
                    'message' => 'No appointments found',
                    'success' => true
                ], Response::HTTP_OK);
            }

            return response()->json([
                'message' => 'Appointments retrieved',
                'data' => $appointments,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error retrieving appointments: ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving appointments',
                'success' => false
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMyAppointment($id)
    {
        try {
            $appointment = Appointment::with([
                'patient:id,firstName,lastName',
                'treatment:id,treatmentName,description',
                'doctor:id,firstName,lastName'
            ])->get();

            if ($appointment->isEmpty()) {
                return response()->json([
                    'message' => 'No appointments found',
                    'success' => true
                ], Response::HTTP_OK);
            }



            return response()->json([
                'message' => 'Appointment retrieved',
                'data' => $appointment,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting appointment' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving appointment',
                'error' => $th->getMessage(),
                'success' => false
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // public function getDoctorAppointments($id)
    // {
    //     try {
    //         $appointment = Appointment::with([
    //             'patient:id,firstName,lastName',
    //             'treatment:id,treatmentName,description',
    //             'doctor:id,firstName,lastName'
    //         ])->get();

    //         if ($appointment->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'No appointments found',
    //                 'success' => true
    //             ], Response::HTTP_OK);
    //         }

    //         return response()->json([
    //             'message' => 'Appointment retrieved',
    //             'data' => $appointment,
    //             'success' => true
    //         ], Response::HTTP_OK);
    //     } catch (\Throwable $th) {
    //         Log::error('Error getting appointment' . $th->getMessage());

    //         return response()->json([
    //             'message' => 'Error retrieving appointment',
    //             'error' => $th->getMessage(),
    //             'success' => false
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    public function createAppointment(Request $request)
    {
        try {
            $userId = auth()->user()->id;

            $validator = Validator::make($request->all(), [
                'doctor_id' => 'required|integer',
                'treatment_id' => 'required|integer',
                'date' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };

            $validData = $validator->validated();

            // se comprueba el id del doctor
            $doctorId = $validData['doctor_id'];
            $doctorRole = User::where('id', $doctorId)->first(['role_id'])->role_id;

            if ($doctorRole !== 3) {
                return response()->json([
                    'message' => 'Choosen doctor does not exist'
                ], Response::HTTP_OK);
            }

            $appointment = Appointment::create([
                'patient_id' => $userId,
                'doctor_id' => $validData['doctor_id'],
                'treatment_id' => $validData['treatment_id'],
                'date' => $validData['date'],
                'created_at' => date_create(),
                'updated_at' => date_create()
            ]);
            // dd($appointment);
            $appointment->load('patient:id,firstName,lastName', 'doctor:id,firstName,lastName', 'treatment:id,treatmentName,description');
            return response()->json([
                'message' => 'Appointment retrieved',
                'data' => $appointment,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error creating Appointment' . $th->getMessage());
            dd($th->getMessage());

            return response()->json([
                'message' => 'Error creating appointment'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateAppointment(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'doctor_id' => 'integer',
                'treatment_id' => 'integer',
                'date' => 'date'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };

            $validData = $validator->validated();

            //validación si existe la cita
            $appointment = Appointment::find($id, 'id');

            if (!$appointment) {
                return response()->json([
                    'message' => 'Appointment not found'
                ], Response::HTTP_OK);
            }

            //validación de la cita y el usuario
            $userTokenId = auth()->user()->id;
            $userId = Appointment::where('id', $id)->first(['patient_id'])->patient_id;

            if ($userTokenId !== $userId) {
                return response()->json([
                    'message' => 'Appointment error'
                ], Response::HTTP_OK);
            }

            //validación del doctor_id
            $doctorId = $validData['doctor_id'];
            $doctorRole = User::where('id', $doctorId)->first(['role_id'])->role_id;

            if ($doctorRole !== 3) {
                return response()->json([
                    'message' => 'Incorrect doctor'
                ], Response::HTTP_OK);
            }

            //actualizamos la cita
            if (isset($validData['doctor_id'])) {
                $appointment->doctor_id = $validData['doctor_id'];
            }

            if (isset($validData['treatment_id'])) {
                $appointment->treatment_id = $validData['treatment_id'];
            }

            if (isset($validData['date'])) {
                $appointment->date = $validData['date'];
            }

            $appointment->save();

            return response()->json([
                'message' => 'Appointment updated successfully',
                'data' => $appointment
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error updating appointment' . $th->getMessage());

            return response()->json([
                'message' => 'Error updating appointment',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteAppointment($id)
    {
        try {

            //validación de cita -> usuario
            $userTokenId = auth()->user()->id;
            $userId = Appointment::where('id', $id)->first(['patient_id'])->patient_id;

            if ($userTokenId !== $userId) {
                return response()->json([
                    'message' => 'Appointment error'
                ], Response::HTTP_OK);
            }

            Appointment::destroy($id);

            return response()->json([
                'message' => 'Appointment deleted succesfully',
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error deleting appointment' . $th->getMessage());

            return response()->json([
                'message' => 'Error deleting appointment'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
