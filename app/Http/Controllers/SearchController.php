<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Livewire\PreRegTable;
use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
use App\Models\PreRegisteredPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;

class SearchController extends Controller
{
    public function index($type)
    {
        if (strtoupper($type)) {
            return view('auth.search.index', [
                'type' => strtoupper($type),
            ]);
        } else {
            abort(404);
        }
    }


    public function indexPreReg()
    {
        return view('auth.search.index');
    }

    public function show(Request $request)
    {
        $role = $request->input('role');
        $name = $request->input('name');

        switch ($role) {
            case 'PRE-REGISTERED':
                $data = PreRegisteredPatient::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%")
                        ->orWhere('last_name', 'like', "%$name%");
                })->latest()->paginate(1);
                break;

            case 'REGISTERED':
                $data = Patient::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%")
                        ->orWhere('last_name', 'like', "%$name%");
                })->latest()->paginate(1);
                break;

            case 'DOCTOR':
                $data = Doctor::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%");
                })->latest()->paginate(1);
                break;

            case 'OPD':
                $data = Opd::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%");
                })->latest()->paginate(1);
                break;

            default:
                break;
        }

        return response()->view('auth.search.partials.table-body', [
            'data' => $data,
            'role' => $role,
            'name' => $name,
        ]);
    }
}
