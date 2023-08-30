<?php

namespace Modules\Soa\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use Modules\Soa\Entities\SoaModel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;



class SoaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $event = new SoaModel();
        return view('soa::form/form', [
            'uri'   => \Request::segment(2),
            'plant' => $event->getPerPlant(),
        ]);
    }

    public function saveSoa(Request $req)
    {
    }

    public function dataTables(Request $req)
    {
        $datas = SoaModel::getDataSoa($req);
        $draw = intval($req->input("draw"));
        $start = intval($req->input("start"));
        $length = intval($req->input("length"));
        $data = [];

        $no = 1;
        foreach ($datas as $r) {
            $data[] = array(
                $no++,
                $r->area,
                $r->tanggal,
                $r->total_vehicle,
                $r->total_people,
                $r->total_document,
                $r->area_id
            );
        }
        $result = array(
            "draw" => $draw,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        return response()->json($result);
    }

    public function detailSoa(Request $req)
    {

        return view('soa::form/detail_soa', [
            'uri'   => \Request::segment(2),
            'area' => SoaModel::getDataSoa($req),
            'date'  => $req->input("tanggal")
        ]);
    }
}
