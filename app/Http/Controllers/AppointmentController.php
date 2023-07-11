<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    // public function getAllAppointments(){
    //     try {
    //         $appointments = Appointment::with(['patient', 'treatment', 'doctor'])->get();

    //         return response()->json([
    //             'message' => 'Appointments retrieved',
    //             'data' => $appointments,
    //             'success' => true
    //         ], Response::HTTP_OK);
    //     } catch (\Throwable $th) {
    //         Log::error('Error getting appointments' . $th->getMessage());

    //         return response()->json([
    //             'message' => 'Error retrieving appointments'
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }
    public function getAllAppointments()
    {
        try {
            // function ($query) es una función anónima en PHP. restricción/persionalización
            // de las relaciones. Puedo definir instrucciones adicionales utilizando select
            // en conjunto con $query
            
            $appointments = Appointment::with([
                'patient' => function ($query) {
                    $query->select('id', 'firstName', 'lastName');
                },
                'treatment' => function ($query) {
                    $query->select('id', 'treatmentName', 'description');
                },
                'doctor' => function ($query) {
                    $query->select('id', 'firstName', 'lastName');
                }
            ])->get();

            if ($appointments->isEmpty()) {
                return response()->json([
                    'message' => 'No appointments found',
                    'success' => true
                ], Response::HTTP_OK);
            }
            // se utiliza método 'getAttribute()' que nos permite acceder a los valores
            //  de los atributos específicos de las relaciones
            // accedemos a la primera cita médica en la respuesta JSON utilizando el índice
            $appointment = $appointments[0];
            $patientFirstName = $appointment->patient->getAttribute('firstName');
            $patientLastName = $appointment->patient->getAttribute('lastName');
            $treatmentName = $appointment->treatment->getAttribute('treatmentName');
            $treatmentDescription = $appointment->treatment->getAttribute('description');
            $doctorFirstName = $appointment->doctor->getAttribute('firstName');
            $doctorLastName = $appointment->doctor->getAttribute('lastName');

            return response()->json([
                'message' => 'Appointment retrieved',
                'patientFirstName' => $patientFirstName,
                'patientLastName' => $patientLastName,
                'treatmentName' => $treatmentName,
                'treatmentDescription' => $treatmentDescription,
                'doctorFirstName' => $doctorFirstName,
                'doctorLastName' => $doctorLastName,
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
}
