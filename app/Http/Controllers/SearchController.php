<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    //
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check user role and return the appropriate view
        switch ($user->type) {
            case 'ADMIN':
                return $this->showAdmin();

            case 'OPD':
                return view('dashboard.opd');
            case 'DOCTOR':
                return view('dashboard.doctor');
            case 'PATIENT':
                return view('dashboard.patient');
                // Add more roles if necessary
            default:
                return abort(403);  // Default dashboard view
        }
    }


    public function showAdmin()
    {
        $data = PreRegisteredPatient::latest()->get();

        return view('auth.admin.search', [
            'data' => $data
        ]);
    }

    public function show(Request $request)
    {
        $account_type = request('account_type');
        $name = request('name');

        // dd(request());
        // dd($account_type);

        switch ($account_type) {
            case 'PRE-REGISTERED':
                $data = PreRegisteredPatient::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%")
                        ->orWhere('last_name', 'like', "%$name%");
                })->latest()->get();
                break;

            case 'REGISTERED':
                $data = Patient::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%")
                        ->orWhere('last_name', 'like', "%$name%");
                })->latest()->get();
                break;

            case 'DOCTOR':
                $data = Doctor::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%")
                        ->orWhere('last_name', 'like', "%$name%");
                })->latest()->get();
                break;

            case 'OPD':
                $data = Opd::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%")
                        ->orWhere('last_name', 'like', "%$name%");
                })->latest()->get();
                break;
            default:
                return abort(400, 'Invalid account type');
        }

        // dd($data);

        return view('auth.admin.search', [
            'data' => $data,
            'name' => $name,
        ]);
    }
}
