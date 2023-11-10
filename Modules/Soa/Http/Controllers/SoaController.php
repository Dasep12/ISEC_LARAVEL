<?php

namespace Modules\Soa\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use Exception;
use Illuminate\Contracts\View\View;
use Modules\Soa\Entities\SoaModel;
use Modules\Soa\Entities\UploadModel;
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

    public function form_upload_visitor(): View
    {
        return view('soa::form/upload_visitor', [
            'uri'   => \Request::segment(2),
            'plant' => UploadModel::getPerPlant(),
        ]);
    }

    public function uploads_visitor(Request $req)
    {
        DB::connection('soabi')->beginTransaction();
        try {
            if ($req->file('file')) {
                $file             = $req->file('file');
                $filename         = time() . $file->getClientOriginalName();
                $file->move(public_path('assets/upload_soa/'), $filename);
                $path_xlsx        = "assets/upload_soa/" . $filename;
                $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet      = $reader->load($path_xlsx);
                $dataSoa          = $spreadsheet->getSheet(0)->toArray();
                $sheet            = $spreadsheet->getSheet(0);

                for ($r = 0; $r < 5; $r++) {
                    unset($dataSoa[$r]);
                }

                $plant  = $sheet->getCell('B1');
                $SearchPlant = UploadModel::getPerPlantId($plant);
                $transId = "";
                $uploadVisitor = array();

                if (count($SearchPlant) <= 0) {
                    return back()->with('failed', 'Plant not found');
                } else {
                    $plantId = $SearchPlant[0]->id;
                    $headerDatas = array();
                    foreach ($dataSoa as $dv) {
                        $date = $dv[0];
                        // $shift = $dv[1];

                        $cariTanggal = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction WHERE area_id = '$plantId' AND shift in (1,2,3) AND report_date ='$date' ");
                        if (count($cariTanggal) > 0) {
                            $transId = $cariTanggal[0]->id;
                        } else {
                            $headerDatas = array(
                                'created_on'        => date('Y-m-d H:i:s'),
                                'created_by'        => Session('npk'),
                                'status'            => 1,
                                'disable'           => 0,
                                'report_date'       => $date,
                                'shift'             => 1,
                                'chronology'        => '',
                                'area_id'           => $plantId
                            );
                            DB::connection('soabi')->table('admisecdrep_transaction')->insert($headerDatas);
                            $transId = DB::connection('soabi')->getPdo()->lastInsertId();
                        }

                        $visitorValue = $dv[1];
                        $visitorArray = array(
                            'people_id'     => '7',
                            'attendance'    => $visitorValue,
                            'trans_id'      => $transId,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $uploadVisitor[] = $visitorArray;
                    }
                    DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadVisitor);

                    DB::connection('soabi')->commit();
                    // echo "sukses";
                    return back()->with('success', 'Upload data successfully!');
                }
            }
        } catch (\Exception $e) {
            DB::connection('soabi')->rollback();
            // dd($e);
            return back()->with('failed', 'Upload data failed !');
        }
    }
}
