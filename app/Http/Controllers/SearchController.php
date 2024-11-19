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
    //
    public function index($type)
    {
        if (strtoupper($type)) {
            return view('auth.search.index', [
                'type' => strtoupper($type),
            ]);
        }
        else {
            abort(404);
        }
    }


    public function indexPreReg()
    {
        // $list = PreRegisteredPatient::latest()->get();

        // return view('auth.search.index', [
        //     'list' => $list
        // ]);

        // return view('auth.search.index');

        return view('auth.search.index');
    }


    public function getPreReg()
    {
        $users = PreRegisteredPatient::query(); // Start with the User query

        return DataTables::of($users)
            ->addColumn('actions', function ($user) {
                return '<a href="' . route('/api/users', $user->id) . '" class="btn btn-sm btn-primary">Edit</a>';
            })
            ->rawColumns(['actions']) // Mark columns with raw HTML
            ->make(true);
    }






    public function show(Request $request)
    {
        $account_type = $request->input('account_type');
        $name = $request->input('name');

        switch ($account_type) {
            case 'PRE-REGISTERED':
                $data = PreRegisteredPatient::when($name, function ($query, $name) {
                    return $query->where('first_name', 'like', "%$name%")
                        ->orWhere('middle_name', 'like', "%$name%")
                        ->orWhere('last_name', 'like', "%$name%");
                })->latest()->paginate(1); // <-- Make sure paginate() is used here
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

        // Return the table body partial view with pagination data
        return response()->view('auth.search.partials.table-body', [
            'data' => $data,
            'account_type' => $account_type,
            'name' => $name,
        ]);
    }
}


