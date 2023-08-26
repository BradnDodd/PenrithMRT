<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class GetInvolvedController extends Controller
{
    /**
     * Show the get involved page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('get-involved');
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getApplicationPackRequest()
    {
        $fileName = 'Penrith+Mountain+Rescue+Team+Application.zip';
        return response()->download(
            storage_path('/app/public/' . $fileName),
            $fileName,
            []
        );
    }
}
