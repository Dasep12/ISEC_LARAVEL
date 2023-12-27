<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Dashboard;
use Modules\GuardTour\Entities\DashboardModels;
use Modules\GuardTour\Entities\Plants;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */



    public function index()
    {
        $month = array(["1", "JANUARI"], ["2", "FEBRUARI"], ["3", "MARET"], ["4", "APRIL"], ["5", "MEI"], ["6", "JUNI"], ["7", "JULI"], ["8", "AGUSTUS"], ["9", "SEPTEMBER"], ["10", "OKTOBER"], ["11", "NOVEMBER"], ["12", "DESEMBER"]);
        $totalHari = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $ttlHari = array();
        for ($h = 1; $h <= $totalHari; $h++) {
            $ttlHari[] = $h;
        }

        $pl =  Session('role') == 'SUPERADMIN' ? Plants::where('status', 1)->orderBy('plant_name', 'ASC')->get() : Plants::where([
            ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
            ['status', '=', 1],
        ])->orderBy('plant_name', 'ASC')->get();

        $tar_arr = array();
        foreach ($pl as $key => $tar) {
            $tar_arr[] = $tar->plant_name;
        }


        $opt_mon = array();
        for ($i = 1; $i <= 12; $i++) {
            $opt_mon[$i] = date("F", mktime(0, 0, 0, $i, 10));
        }




        return view('guardtour::dashboard/index', [
            'uri'          => \Request::segment(2),
            'bulan'       => $month,
            'plant'       => $pl,
            'jmlHari'     => json_encode($ttlHari, true),
            'ttlHari'     => $totalHari,
            'plants'      => json_encode($tar_arr, true),
            'select_month_filter' =>  $opt_mon,
        ]);
    }


    // trend patroli
    public function trendPatrolAllPlant(Request $req)
    {
        // $year = date('Y');
        $year = $req->tahun;
        $pl   = $req->plant_id;
        $par = array();

        if ($pl == 0) {
            // $plant = DashboardModels::getPlant();
            $plant =  Session('role') == 'SUPERADMIN' ? Plants::where('status', 1)->get() : Plants::where([
                ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
                ['status', '=', 1],
            ])->orderBy('plant_name', 'ASC')->get();
        } else {
            $plant = DashboardModels::getPerPlant($pl);
        }
        foreach ($plant as $pl) {
            $data =
                array(
                    'plant' => $pl->plant_name,
                    'data'  => DashboardModels::trenPatroliBulanan($year,  $pl->plant_name)
                );
            array_push($par, $data);
        }
        echo json_encode($par, true);
    }

    public function trendPatrolBulananPerPlant(Request $req)
    {

        $plant = $req->plant_id;
        $year = $req->tahun;
        $data = array([
            'name'      => 'Total',
            'data'      => DashboardModels::trenPatroliBulanan($year,  $plant)
        ]);
        // echo json_encode($data, true);
        return response()->json($data);
    }

    public function trendPatrolHarian(Request $req)
    {
        $year = $req->tahun;
        $month = $req->bulan;
        $pl   = $req->plant_id;
        if ($pl == 0) {
            // $plant = DashboardModels::getPlant();
            $plant =  Session('role') == 'SUPERADMIN' ? Plants::all() : Plants::where('admisecsgp_mstsite_site_id', Session('site_id'))->get();
        } else {
            $plant = DashboardModels::getPerPlant($pl);
        }
        $par = array();
        foreach ($plant as $pl) {
            $data = array(
                'name'      => $pl->plant_name,
                'data'      => DashboardModels::getTrendPatroliHarian($year, $month, $pl->plant_name)
            );
            array_push($par, $data);
        }
        return response()->json($par);
        // echo json_encode($par, true);
    }



    // performance
    public function perforamancePatrolAllPlant(Request $req)
    {
        $year = $req->tahun;
        $par = array();
        $pl   = $req->plant_id;
        if ($pl == 0) {
            $plant =  Session('role') == 'SUPERADMIN' ? Plants::where('status', 1)->get() : Plants::where([
                ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
                ['status', '=', 1],
            ])->get();
        } else {
            $plant = DashboardModels::getPerPlant($pl);
        }
        foreach ($plant as $pl) {
            $data =
                array(
                    'plant' => $pl->plant_name,
                    'data'  => DashboardModels::performancePatroliPerPlant($year,  $pl->plant_name)
                );
            array_push($par, $data);
        }
        // echo json_encode($par, true);
        return response()->json($par);
    }

    public function perforamancePatrolBulananPerPlant(Request $req)
    {

        $plant = $req->plant_id;
        $year = $req->tahun;
        if ($plant == "") {
            $data = array([
                'name'      => 'Performance',
                'data'      => DashboardModels::performancePatroliAllPlant($year, $plant)
            ]);
        } else {
            $data = array([
                'name'      => 'Performance',
                'data'      => DashboardModels::performancePatroliPerPlant($year, $plant)
            ]);
        }
        // echo json_encode($data, true);
        return response()->json($data);
    }

    public function perFormancePatrolHarian(Request $req)
    {
        $year = $req->tahun;
        $month = $req->bulan;
        $pl   = $req->plant_id;
        $par = array();

        if ($pl == 0) {
            // $plant = DashboardModels::getPlant();
            $plant =  Session('role') == 'SUPERADMIN' ? Plants::all() : Plants::where('admisecsgp_mstsite_site_id', Session('site_id'))->get();
        } else {
            $plant = DashboardModels::getPerPlant($pl);
        }
        foreach ($plant as $pl) {
            $data = array(
                'name'      => $pl->plant_name,
                'data'      => DashboardModels::getPerformancePatroliHarianAllPlant($year, $month, $pl->plant_name)
            );
            array_push($par, $data);
        }

        return response()->json($par);
    }


    // temuan
    public function temuanPatrolAllPlant(Request $req)
    {
        $year = $req->tahun;
        $res = DashboardModels::getTemuanPatroliAll($year);
        return response()->json($res);
    }


    // temuan per tindakan
    public function temuanPerReguPlant(Request $req)
    {
        $year = $req->tahun;
        $month = $req->bulan;
        $plant = Session('role') == 'SUPERADMIN' ? Plants::where('status', 1)->orderBy('plant_name', 'ASC')->get() : Plants::where([
            ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
            ['status', '=', 1],
        ])->orderBy('plant_name', 'ASC')->get();

        $data = array();
        $regu = ['REGU_A', 'REGU_B', 'REGU_C', 'REGU_D'];
        for ($r = 0; $r < count($regu); $r++) {
            $counting = DashboardModels::getTemuanPerRegu($year, $month, $regu[$r]);
            $data[] = [$counting];
        }
        return response()->json($data);
    }
}
