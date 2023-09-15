<?php

namespace Modules\Soa\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use Exception;
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
        $save = SoaModel::saveSoa($req);
        if ($save == 1) {
            return back()->with('success', 'Insert data successfully!');
        } else if ($save == 2) {
            return back()->with('failed', 'Plant ' . $req->input("area") . ' sudah insert tanggal ' . $req->input("report_date") . ' shift ' . $req->input("shift"));
        }
        return back()->with('failed', 'Failed insert data !');
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
            'area'  => SoaModel::listShiftDetail($req),
            'date'  => $req->input("tanggal")
        ]);
    }


    public function deleteData(Request $req)
    {

        $area  = $req->input("area");
        $date = $req->input("date");
        DB::connection('soabi')->beginTransaction();
        try {

            DB::connection('soabi')->update("UPDATE admisecdrep_transaction set status = 0 , disable = 1  WHERE area_id = " . $area . " and report_date = '" . $date . "'  ");

            DB::connection('soabi')->commit();
            echo 1;
        } catch (\Exception $e) {
            DB::connection('soabi')->rollback();
            // echo "00";
            dd($e);
        }
    }

    public function  formEdit(Request $req)
    {
        $event = new SoaModel();
        return view('soa::form/form_edit_soa', [
            'uri'   => \Request::segment(2),
            'plant' => $event->getPerPlant(),
            'transHeader' => SoaModel::detailHeaderSoa($req)
        ]);
    }

    public function updateSoa(Request $req)
    {
        $updateData = SoaModel::updateHeaderTrans($req);
        if ($updateData == 1) {
            $replace = SoaModel::updateDetailTransSoa($req);
            if ($replace == 1) {
                return back()->with('success', 'Update data successfully!');
            } else {
                return back()->with('failed', 'Update data failed !');
            }
        } else if ($updateData == 2) {
            return back()->with('failed', 'Update data failed !');
        }
    }
}
