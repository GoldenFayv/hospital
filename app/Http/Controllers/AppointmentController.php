<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Create a new appointment.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function make_appointment(Request $request)
    {
        $request->validate([
            'appointment_datetime' => 'required|date',
            'reason' => 'required|string',
        ]);

        $user = auth()->user();

        $appointment = new Appointment([
            'user_id' => $user->id,
            'appointment_datetime' => $request->input('appointment_datetime'),
            'reason' => $request->input('reason'),
            'status' => 'pending',
        ]);

        $appointment->save();

        return response()->json(['message' => 'Appointment created successfully'], 201);
    }

    /**
     * List appointments for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = auth()->user();
        $appointments = Appointment::where('user_id', $user->id)->get();

        return response()->json(['appointments' => $appointments]);
    }
}

