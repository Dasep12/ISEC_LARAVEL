<?php

namespace Modules\Soa\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use Modules\Soa\Entities\UploadModel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class UploadEgateController extends Controller
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

        // $event = new Dashboard();
        return view('soa::egate/upload', [
            'uri'   => \Request::segment(2),
            'plant' => UploadModel::getPerPlant(),
        ]);
    }

    public function uploads(Request $req)
    {
        if ($req->file('file')) {
            $file = $req->file('file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('assets/upload_egate/'), $filename);
            $path_xlsx        = "assets/upload_egate/" . $filename;
            $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet      = $reader->load($path_xlsx);
            $dataEgate       = $spreadsheet->getSheet(0)->toArray();
            unset($dataEgate[0]);
            $eGate = [];


            DB::connection('egate')->beginTransaction();
            try {
                foreach ($dataEgate as $s) {

                    $data = array(
                        'PKBNo'          => $s[0],
                        'PKBCode '       => $s[1],
                        'PKBDate'        => $s[2],
                        'IDDiv'          => $s[3],
                        'DivisionName'   => $s[4],
                        'IDDept'         => $s[5],
                        'DeptName'       => $s[6],
                        'IDLevel'        => $s[7],
                        'LevelName'      => $s[8],
                        'IDLocation'     => $s[9],
                        'LocationName'   => $s[10],
                        'Creator'        => $s[11],
                        'Carrier '       => $s[12],
                        'CategoryCode'   => $s[13],
                        'FlagAssets'     => $s[14],
                        'Receiver'       => $s[15],
                        'Destination'    => $s[16],
                        'PlantCode'      => $s[17],
                        'PlantName'      => $s[18],
                        'RecDivision'    => $s[19],
                        'RecDepartement' => $s[20],
                        'Address'        => $s[21],
                        'DateFrom'       => $s[22],
                        'DateTo '        => $s[23],
                        'Remark'         => $s[24],
                        'FlagEksternal'  => $s[25],
                        'FlagActive'     => $s[26],
                        'FlagPeriodic'   => $s[27],
                        'TicketStatus'   => $s[28],
                        'CurrentLevel'   => $s[29],
                        'ScanDate'       => $s[30],
                        'EntryDate '     => $s[31],
                        'EntryUser'       => $s[32],
                        'UpdateDate'     => $s[33],
                        'UpdateUser'      => $s[34],
                        'uploadAt'       => date('Y-m-d H:i:s')
                    );

                    $cariData =  DB::connection('egate')->select("SELECT COUNT(PKBNo) as hasil from T_PKB WHERE PKBNo = '$s[0]' ");
                    if ((int)$cariData[0]->hasil > 0) {
                        return back()->with('failed', 'Updload data failed NO PKB ' . $s[0] . ' has been insert');
                    }

                    DB::connection('egate')->table('T_PKB')->insert($data);
                    // dd((int)$cariData[0]->hasil);
                }

                DB::connection('egate')->commit();
                return back()->with('success', 'Upload data successfully!');
            } catch (\Exception $e) {
                DB::connection('egate')->rollback();
                return back()->with('failed', 'Update data failed !');
                // dd($e);
            }
            return back()->with('success', 'Update data success !');
            // dd($eGate);
        }
    }
}
