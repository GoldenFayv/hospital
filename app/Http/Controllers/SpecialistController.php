<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    // ... Previous code ...

    /**
     * Hand over a patient to the pharmacy.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handoverToPharmacy(Request $request)
    {
        $specialist = auth()->user();

        $request->validate([
            // 'appointment_id' => 'required|exists:appointments,id',
            'pharmacist_user_id' =>'required'
        ]);

        $refer = Referral::where("specialist_user_id", $specialist->id)->get();

        // $refer->update([
        //     "pharmacist_user_id" => $request->input('pharmacist_user_id')
        // ]);
        
        foreach ($refer as $refer) {
            $refer->pharmacist_user_id = $request->input('pharmacist_user_id');
            $refer->save();
        }

        // Add logic to validate and hand over the patient to the pharmacy.

        return response()->json(['message' => 'Patient handed over to the pharmacy successfully']);
    }
}
