<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\PreRegisteredPatient;
use Illuminate\Http\Request;

class PreRegTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('pre-register.tracking.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // Retrieve the code from the query string
        $code = $request->query('code');

        // Find the record associated with the code
        $patient = PreRegisteredPatient::where('pre_registration_code', $code)->first();

        // If no record is found, redirect back with an error message
        if (!$patient) {
            return redirect()->route('pre-reg.tracking.index')->with('error', 'Invalid pre-registration code.');
        }

        // Pass the patient data to the view for displaying details
        return view('pre-register.tracking.show', [
            'patient' => $patient
        ]);
    }
}
