<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function getAllAppointments()
    {
        try {
            // function ($query) es una función anónima en PHP. restricción/persionalización
            // de las relaciones. Puedo definir instrucciones adicionales utilizando select
            // en conjunto con $query

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

    public function getDoctorAppointments($id){
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
}
