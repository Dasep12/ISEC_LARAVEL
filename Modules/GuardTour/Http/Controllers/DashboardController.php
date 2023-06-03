<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Dashboard;
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

        $pl = Plants::all();
        $tar_arr = array();
        foreach ($pl as $key => $tar) {
            $tar_arr[] = $tar->plant_name;
        }

        $opt_mon = array();
        for ($i = 1; $i <= 12; $i++) {
            $opt_mon[$i] = date("F", mktime(0, 0, 0, $i, 10));
        }



        return view('guardtour::dashboard/index', [
            'uri'   => \Request::segment(2),
            'bulan' => $month,
            'plant' => Plants::all(),
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
            $plant = Dashboard::getPlant();
        } else {
            $plant = Dashboard::getPerPlant($pl);
        }
        foreach ($plant as $pl) {
            $data =
                array(
                    'plant' => $pl->plant_name,
                    'data'  => Dashboard::trenPatroliBulanan($year,  $pl->plant_name)
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
            'data'      => Dashboard::trenPatroliBulanan($year,  $plant)
        ]);
        echo json_encode($data, true);
    }

    public function trendPatrolHarian(Request $req)
    {
        $year = $req->tahun;
        $month = $req->bulan;
        $pl   = $req->plant_id;
        if ($pl == 0) {
            $plant = Dashboard::getPlant();
        } else {
            $plant = Dashboard::getPerPlant($pl);
        }
        $par = array();
        foreach ($plant as $pl) {
            $data = array(
                'name'      => $pl->plant_name,
                'data'      => Dashboard::getTrendPatroliHarian($year, $month, $pl->plant_name)
            );
            array_push($par, $data);
        }

        echo json_encode($par, true);
    }



    // performance
    public function perforamancePatrolAllPlant(Request $req)
    {
        $year = $req->tahun;
        $par = array();
        $pl   = $req->plant_id;
        if ($pl == 0) {
            $plant = Dashboard::getPlant();
        } else {
            $plant = Dashboard::getPerPlant($pl);
        }
        foreach ($plant as $pl) {
            $data =
                array(
                    'plant' => $pl->plant_name,
                    'data'  => Dashboard::performancePatroliPerPlant($year,  $pl->plant_name)
                );
            array_push($par, $data);
        }
        echo json_encode($par, true);
    }

    public function perforamancePatrolBulananPerPlant(Request $req)
    {

        $plant = $req->plant_id;
        $year = $req->tahun;
        if ($plant == "") {
            $data = array([
                'name'      => 'Performance',
                'data'      => Dashboard::performancePatroliAllPlant($year, $plant)
            ]);
        } else {
            $data = array([
                'name'      => 'Performance',
                'data'      => Dashboard::performancePatroliPerPlant($year, $plant)
            ]);
        }
        echo json_encode($data, true);
    }

    public function perFormancePatrolHarian(Request $req)
    {
        $year = $req->tahun;
        $month = $req->bulan;
        $pl   = $req->plant_id;
        $par = array();

        if ($pl == 0) {
            $plant = Dashboard::getPlant();
        } else {
            $plant = Dashboard::getPerPlant($pl);
        }
        foreach ($plant as $pl) {
            $data = array(
                'name'      => $pl->plant_name,
                'data'      => Dashboard::getPerformancePatroliHarianAllPlant($year, $month, $pl->plant_name)
            );
            array_push($par, $data);
        }

        echo json_encode($par, true);
    }


    // temuan
    public function temuanPatrolAllPlant(Request $req)
    {
        $year = $req->tahun;
        $res = Dashboard::getTemuanPatroliAll($year);
        echo json_encode($res, true);
    }


    // temuan per tindakan
    public function temuanPerReguPlant(Request $req)
    {
        $year = $req->tahun;
        $month = $req->bulan;
        $res = Dashboard::queryTemuanRegu($year, $month, "REGU_A");
        $plant = array();
        foreach ($res as $q) {
            $plant[] = $q->plant_name;
        }
        $data = array(
            array(
                Dashboard::getTemuanPerRegu($year, $month, 'REGU_A'),
                Dashboard::getTemuanPerRegu($year, $month, 'REGU_B'),
                Dashboard::getTemuanPerRegu($year, $month, 'REGU_C'),
                Dashboard::getTemuanPerRegu($year, $month, 'REGU_D'),
            ),
            array(
                $plant
            )
        );
        echo json_encode($data, true);
        // echo "<pre>";
        // var_dump($query);
    }
}
