<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Plants;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::laporan_patroli/form_laporan', [
            'uri'        => $uri,
            'plant'      => Plants::all()
        ]);
    }

    public function list_patroli(Type $var = null)
    {
        # code...
    }
}
