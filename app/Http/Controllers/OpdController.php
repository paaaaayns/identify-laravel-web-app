<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('auth.users.opd.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('register.opd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);

        $user = Opd::where('user_id', $id)->firstOrFail();
        $user->delete();
        // dd($user);

        // Return a JSON response to inform the frontend that the deletion was successful
        return response()->json([
            'success' => true,
            'message' => 'Pre-registered patient deleted successfully.'
        ], 200);
    }
}
