<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleAllocationController extends Controller
{
     /**
     * Show the profile for a given user.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('vehicles.allocation');
    }
}
