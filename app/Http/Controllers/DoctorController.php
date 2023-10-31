<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;
use App\Models\Appointment;

class DoctorController extends Controller
{
    /**
     * List appointments for the authenticated doctor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // $doctor = auth()->user();
        // $appointments = Appointment::where('user_id', $doctor->id)->get();
        $appointments = Appointment::all();

        return response()->json(['appointments' => $appointments]);
    }

    /**
     * Mark an appointment as "seen" or "completed."
     *
     * @param  Request  $request
     * @param  Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_appointment(Request $request, Appointment $appointment)
    {
        // $doctor = auth()->user();

        // if ($appointment->user_id !== $doctor->id) {
        //     return response()->json(['message' => 'You do not have permission to update this appointment'], 403);
        // }

        $request->validate([
            'status' => 'required|in:seen,completed',
        ]);

        $appointment->status = $request->input('status');
        $appointment->save();

        return response()->json(['message' => 'Appointment status updated successfully']);
    }

        public function storeReferral(Request $request)
        {
            $doctor = auth()->user();

            $request->validate([
                'appointment_id' => 'required|exists:appointments,id',
                'specialist_user_id' => 'required|exists:users,id|different:' . $doctor->id,
                'notes' => 'string|nullable',
            ]);

            $referral = new Referral([
                'appointment_id' => $request->input('appointment_id'),
                'specialist_user_id' => $request->input('specialist_user_id'),
                'notes' => $request->input('notes'),
            ]);

            $referral->save();

            return response()->json(['message' => 'Referral created successfully'], 201);
        }

        /**
         * List referrals created by the doctor.
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function indexReferrals()
        {
            $doctor = auth()->user();
            $referrals = Referral::where('referred_by_user_id', $doctor->id)->get();

            return response()->json(['referrals' => $referrals]);
        }
}

