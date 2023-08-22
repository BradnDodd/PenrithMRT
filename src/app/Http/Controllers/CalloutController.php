<?php

namespace App\Http\Controllers;

use App\Models\Callout;
use Illuminate\Http\Request;

class CalloutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $callouts = Callout::orderBy('created_at','desc')->paginate(10);

        return view('callout.index')->with('callouts', $callouts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Callout  $callout
     * @return \Illuminate\Http\Response
     */
    public function show(Callout $callout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Callout  $callout
     * @return \Illuminate\Http\Response
     */
    public function edit(Callout $callout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Callout  $callout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Callout $callout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Callout  $callout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Callout $callout)
    {
        //
    }
}
