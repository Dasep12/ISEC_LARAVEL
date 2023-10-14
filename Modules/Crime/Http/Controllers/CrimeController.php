<?php

namespace Modules\Crime\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CrimeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('crime::dashboard/index', [
            'uri'   => \Request::segment(2),
        ]);
    }

    private function crimeSetahun($year, $kota, $kat)
    {
        $grap_trans_area  = $this->model->crimeKategoriSetahun($year, $kota, $kat)->result();
        $tar_arr = array();
        foreach ($grap_trans_area as $key => $tar) {
            $tar_arr[] = $tar->total;
        }
        return $tar_arr;
    }
}
