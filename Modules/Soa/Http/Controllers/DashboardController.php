<?php

namespace Modules\Soa\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Soa\Entities\DashboardModel as Dashboard;
use Illuminate\Support\Facades\DB;
use AuthHelper;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        // FILTER BULAN
        $opt_mon = array();
        for ($i = 1; $i <= 12; $i++) {
            $opt_mon[$i] = date("F", mktime(0, 0, 0, $i, 10));
        }

        $event = new Dashboard();
        return view('soa::dashboard/dashboard', [
            'uri'   => \Request::segment(2),
            'plant' => $event->getPerPlant(),
            'month' => $opt_mon
        ]);
    }


    public function peopleAll(Request $req)
    {
        $data = Dashboard::peopleAll($req);
        return response()->json($data);
    }

    public function vehicleAll(Request $req)
    {
        $data = Dashboard::vehicleAll($req);
        return response()->json($data);
    }

    public function documentAll(Request $req)
    {
        $document = Dashboard::documentAll($req);
        $dataPkb = Dashboard::documentPKBAll($req);

        $data = array_merge($document, $dataPkb);

        $sum = 0;
        for ($i = 0; $i < count($data); $i++) {
            $sum += (int) $data[$i]->total;
        }
        $result = array(['total' => $sum]);
        return response()->json($result);
    }


    public function peopleDays(Request $req)
    {
        $data = Dashboard::peopleDays($req);
        $people_item = array();
        $num = 1;

        $categ = array();
        $key = 'title';
        $data = array_map(function ($value) {
            return (array)$value;
        }, $data);
        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $categ[$val[$key]][] = $val;
            } else {
                $categ[""][] = $val;
            }
        }
        foreach ($categ as $key => $pcd) {
            foreach ($pcd as $i => $sva) {
                $people_item[$i] = (int) $sva['total'];
            }
            $people[] = array(
                'label' => $key,
                'data' =>  $people_item,
            );
            $num++;
        }

        return response()->json($people);
    }

    public function vehicleDays(Request $req)
    {
        $data = Dashboard::vehicleDays($req);
        $item = array();
        $num = 1;

        $categ = array();
        $key = 'title';
        $data = array_map(function ($value) {
            return (array)$value;
        }, $data);
        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $categ[$val[$key]][] = $val;
            } else {
                $categ[""][] = $val;
            }
        }
        foreach ($categ as $key => $pcd) {
            foreach ($pcd as $i => $sva) {
                $item[$i] = (int) $sva['total'];
            }
            $people[] = array(
                'label' => $key,
                'data' =>  $item,
            );
            $num++;
        }

        return response()->json($people);
    }

    public function documentDays(Request $req)
    {
        $data = Dashboard::documentDays($req);
        $item = array();
        $num = 1;

        $categ = array();
        $key = 'title';
        $data = array_map(function ($value) {
            return (array)$value;
        }, $data);
        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $categ[$val[$key]][] = $val;
            } else {
                $categ[""][] = $val;
            }
        }
        foreach ($categ as $key => $pcd) {
            foreach ($pcd as $i => $sva) {
                $item[$i] = (int) $sva['total'];
            }
            $people[] = array(
                'label' => $key,
                'data' =>  $item,
            );
            $num++;
        }

        return response()->json($people);
    }

    public function vehicleCategory(Request $req)
    {
        $vehicle = "SELECT  s.title , s.id from admisecdrep_sub  s
        where s.categ_id  = 1 and s.disable  = 0  and  id in(1,2,3,1037) ";
        $res = DB::connection('soabi')->select($vehicle);
        $result = array();
        foreach ($res as $v) {
            $res = array(
                'label' => $v->title,
                'total' => Dashboard::vehicleCategory($req, $v->id)
            );
            array_push($result, $res);
        }
        return response()->json($result);
    }

    public function peopleCategory(Request $req)
    {
        $data = Dashboard::peopleCategory($req);
        return response()->json($data);
    }


    public function documentCategory(Request $req)
    {
        $PKB = Dashboard::documentPKB($req);
        $document = Dashboard::documentCategory($req);

        $data = array_merge($PKB, $document);
        return response()->json($data);
    }

    public function grapichSetahun(Request $req)
    {
        $people = Dashboard::peopleSetahun($req);
        $vehicle = Dashboard::vehicleSetahun($req);
        $document = Dashboard::pkbSetahun($req);
        $result = array(
            array('label' => 'People', 'data' => $people),
            array('label' => 'Vehicle', 'data' => $vehicle),
            array('label' => 'Document', 'data' => $document),
        );
        return response()->json($result);
    }
}
