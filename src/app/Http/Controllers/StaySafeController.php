<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaySafeController extends Controller
{
    /**
     * Show the stay safe page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('stay-safe');
    }
}
