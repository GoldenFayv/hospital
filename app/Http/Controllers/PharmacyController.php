<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    // ... Previous code ...

    /**
     * Hand over a patient to the pharmacy.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handoverToBilling(Request $request)
    {
        $pharmacist = auth()->user();

        $request->validate([
            // 'appointment_id' => 'required|exists:appointments,id',
            'biller_user_id' =>'required'
        ]);

        $refer = Referral::where("pharmacist_user_id", $pharmacist->id)->get();
        foreach($refer as $refer){
            $refer->update([
                "billing_user_id" => $request->input('biller_user_id')
            ]);
        }

        // Add logic to validate and hand over the patient to the pharmacy.

        return response()->json(['message' => 'Patient handed over to the billing successfully']);
    }
}
