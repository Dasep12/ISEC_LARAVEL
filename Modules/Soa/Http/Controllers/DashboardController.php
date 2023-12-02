<?php

namespace Modules\Soa\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Soa\Entities\DashboardModel as Dashboard;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

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
        $result = array(['total' => number_format($sum, 0, ",", ",")]);
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
        $pkb = Dashboard::pkbDays($req);
        $item = array();
        $itemPKB = array();
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
            $document[] = array(
                'label' => $key,
                'data' =>  $item,
            );
            $num++;
        }


        foreach ($pkb as $pk) {
            $itemPKB[] = (int) $pk->total;
        }
        $resultPKB[] = array(
            'label' => 'PKB',
            'data'  => $itemPKB
        );

        $response = array_merge($document, $resultPKB);

        return response()->json($response);
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
        $document = Dashboard::documentSetahun($req);
        $pkb = Dashboard::pkbSetahun($req);
        $dataDocument = array();
        for ($i = 0; $i < count($document); $i++) {
            $dataDocument[] = $document[$i] + $pkb[$i];
        }

        // return response()->json([
        //     'doc' => $document,
        //     'pkb' => $pkb,
        //     'res' => $data
        // ]);
        $result = array(
            array('label' => 'People', 'data' => $people),
            array('label' => 'Vehicle', 'data' => $vehicle),
            array('label' => 'Document', 'data' => $dataDocument),
        );
        return response()->json($result);
    }



    // modal pop up pkb
    public static function pkbAllPlants(Request $req)
    {
        $data = Dashboard::pkbAllPlant($req);
        return response()->json($data);
    }

    public static function pkbPlantSetahun(Request $req)
    {
        $data = Dashboard::pkbPlantSetahun($req);
        $item = array();
        // $num = 1;

        $categ = array();
        $key = 'plantss';
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
            $document[] = array(
                'label' => $key,
                'data' =>  $item,
            );
            // $num++;
        }
        return response()->json($document);
    }

    public function pkbByDepartement(Request $req)
    {
        $data = Dashboard::pkbByDepartement($req, 'top');
        return response()->json($data);
    }

    public function pkbByDepartementAll(Request $req)
    {
        $data = Dashboard::pkbByDepartement($req, 'all');
        return response()->json($data);
    }

    public function pkbByUser(Request $req)
    {
        $data = Dashboard::pkbByUser($req, 'top');
        return response()->json($data);
    }

    public function pkbByUserAll(Request $req)
    {
        $data = Dashboard::pkbByUser($req, 'all');
        return response()->json($data);
    }


    public function pkbKategoriBarang(Request $req)
    {
        $data = Dashboard::pkbKategoriBarang($req);
        return response()->json($data);
    }

    public function pkbStatus(Request $req)
    {
        $data = Dashboard::pkbStatus($req);
        return response()->json($data);
    }
    // 

    public function tester(Request $req)
    {
        $data = Dashboard::peopleAll($req);
        return response()->json($data);
    }


    // data scatter pkb barang 
    public function scaterBarang(Request $req)
    {

        $var = array();
        $year = 2023;
        // $year = $req->input('year_fil');
        $month = empty($req->input('month_fil')) ? date('m') : $req->input('month_fil');
        // for ($i = 1; $i <= 1; $i++) {
        //     // $i = $i <= 9 ? '0' . $i : $i;
        //     $m = $month <= 9 ? '0' . $month : $month;
        //     $years = $year . '-' . $m;
        //     $params =  Dashboard::scaterBarang($req, $years);
        //     foreach ($params as $par) {
        //         $var[] = array("x" => (int)$par->keys, "y" => (int) $par->totals, "z" => $par->remarks);
        //     }
        // }

        $datas = Dashboard::scaterBarang($req, $month);

        $results = array(
            '0' => [],
            '1' => [],
            '2' => [],
            '3' => [],
            '4' => [],
            '5' => [],
            '6' => [],
            '7' => [],
            '8' => [],
            '9' => [],
            '10' => [],
            '11' => []
        );
        foreach ($datas as $v => $val) {
            if (array_key_exists($val['x'], $results)) {
                $results[$val['x']][] = array('x' => $val['x'], 'y' => $val['y'], 'z' => $val['z']);
            }
        }

        return response()->json($results);
    }

    public function floterBarang(Request $req)
    {
        $data = Dashboard::floterBarang($req);
        return response()->json($data);
    }
}
