<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\PreRegisteredPatient;
use Illuminate\Http\Request;

class PreRegTrackingController extends Controller
{
    public function index()
    {
        return view('pre-register.tracking.search');
    }

    public function show(Request $request)
    {
        $id = $request->query('code');

        $patient = PreRegisteredPatient::where('pre_registration_code', $id)->first();

        if (!$patient) {
            return redirect()->route('pre-reg.tracking.search')->with('error', 'Invalid pre-registration code.');
        }

        return view('pre-register.tracking.show', [
            'patient' => $patient
        ]);
    }
}
