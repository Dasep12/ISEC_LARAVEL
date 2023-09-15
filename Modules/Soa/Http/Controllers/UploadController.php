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

class UploadController extends Controller
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
        return view('soa::upload/upload', [
            'uri'   => \Request::segment(2),
            'plant' => UploadModel::getPerPlant(),
        ]);
    }

    public function uploads(Request $req)
    {
        if ($req->file('file')) {
            $file = $req->file('file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('assets/upload_soa/'), $filename);
            $path_xlsx        = "assets/upload_soa/" . $filename;
            $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet      = $reader->load($path_xlsx);
            $dataSoa       = $spreadsheet->getSheet(0)->toArray();
            $sheet = $spreadsheet->getSheet(0);

            for ($r = 0; $r < 5; $r++) {
                unset($dataSoa[$r]);
            }

            $plant  = $sheet->getCell('B1');


            $SearchPlant = UploadModel::getPerPlantId($plant);

            if (count($SearchPlant) <= 0) {
                return back()->with('failed', 'Plant not found');
            } else {
                $plantId = $SearchPlant[0]->id;

                $headerDatas = array();
                foreach ($dataSoa as $dv) {
                    $date = $dv[0];
                    $shift = $dv[1];

                    $cariTanggal = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction WHERE area_id = '$plantId' AND shift=$shift AND report_date ='$date' ");
                    if (count($cariTanggal) > 0) {
                        return back()->with('failed', 'Tangal ' . $date . ' ' . $SearchPlant[0]->title . ' sudah pernah upload');
                    }

                    $headerDatas[] = array(
                        'created_on'        => date('Y-m-d H:i:s'),
                        'created_by'        => Session('npk'),
                        'status'            => 1,
                        'disable'           => 0,
                        'report_date'       => $date,
                        'shift'             => $shift,
                        'chronology'        => '',
                        'area_id'           => $plantId
                    );
                }
                $dataDocument = array();
                $dataPeople   = array();
                $dataVehicle  = array();


                // 
                $uploadPKO = array();
                $uploadSj = array();
                // 

                // 
                $uploadEmploye = array();
                $uploadVisitor = array();
                $uploadbisPartner = array();
                $uploadcontractorValue = array();
                // 

                $uploadCaremploye = array();
                $uploadTruckemploye = array();
                $uploadMotoremploye = array();
                $uploadSepedaemploye = array();


                $uploadCarVisitor = array();
                $uploadTruckVisitor = array();
                $uploadMotorVisitor = array();
                $uploadSepedaVisitor = array();

                $uploadCarBp = array();
                $uploadTruckBp = array();
                $uploadMotorBp = array();
                $uploadSepedaBp = array();

                $uploadCarContractor = array();
                $uploadTruckContractor = array();
                $uploadMotorContractor = array();
                $uploadSepedaContractor = array();

                $uploadCarPool = array();
                $uploadTruckPool = array();
                $uploadMotorPool = array();
                $uploadSepedaPool = array();

                DB::connection('soabi')->beginTransaction();
                try {
                    DB::connection('soabi')->table('admisecdrep_transaction')->insert($headerDatas);

                    foreach ($dataSoa as $ds) {
                        $date = $ds[0];
                        $shift = $ds[1];

                        $headerSearch = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction WHERE report_date = '" . $date . "' AND shift = " . $shift  . " AND area_id = $plantId ");
                        $transId = $headerSearch[0]->id;
                        // document 
                        $pkoValue = $ds[2];
                        $sjValue = $ds[3];

                        $PkoArray = array(
                            'category_id'   => '1036',
                            'document_in'   => $sjValue,
                            'trans_id'      => $transId,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $sjArray = array(
                            'category_id'   => '1035',
                            'document_in'   => $pkoValue,
                            'trans_id'      => $transId,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $uploadPKO[] = $PkoArray;
                        $uploadSj[] = $sjArray;

                        // DB::connection('soabi')->table('admisecdrep_transaction_material')->insert($uploadPKO);
                        // DB::connection('soabi')->table('admisecdrep_transaction_material')->insert($uploadSj);
                        // 

                        // people data 
                        $employeValue = $ds[4];
                        $visitorValue = $ds[5];
                        $bisPartnerValue = $ds[6];
                        $contractorValue = $ds[7];

                        $employeArray = array(
                            'people_id'     => '6',
                            'attendance'    => $employeValue,
                            'trans_id'      => $transId,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $visitorArray = array(
                            'people_id'     => '7',
                            'attendance'    => $visitorValue,
                            'trans_id'      => $transId,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $bisPartnerArray = array(
                            'people_id'     => '8',
                            'attendance'    => $bisPartnerValue,
                            'trans_id'      => $transId,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $contractorArray = array(
                            'people_id'     => '9',
                            'attendance'    => $contractorValue,
                            'trans_id'      => $transId,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $uploadEmploye[] = $employeArray;
                        $uploadVisitor[] = $visitorArray;
                        $uploadbisPartner[] = $bisPartnerArray;
                        $uploadcontractorValue[] = $contractorArray;
                        // 1
                        // DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadEmploye);
                        // DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadVisitor);
                        // DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadbisPartner);
                        // DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadcontractorValue);
                        // 

                        // vehicle employee 
                        $CarEmployee = $ds[8];
                        $TruckEmployee = $ds[9];
                        $MotorEmployee = $ds[10];
                        $SepedaEmployee = $ds[11];

                        $CaremployeArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1',
                            'amount'        => $CarEmployee,
                            'people_id'     => '6',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $TruckemployeArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '3',
                            'amount'        => $TruckEmployee,
                            'people_id'     => '6',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $MotoremployeArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '2',
                            'amount'        => $MotorEmployee,
                            'people_id'     => '6',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $SepedaemployeArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1037',
                            'amount'        => $SepedaEmployee,
                            'people_id'     => '6',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $uploadCaremploye[] = $CaremployeArray;
                        $uploadTruckemploye[] = $TruckemployeArray;
                        $uploadMotoremploye[] = $MotoremployeArray;
                        $uploadSepedaemploye[] = $SepedaemployeArray;
                        //  1
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCaremploye);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckemploye);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotoremploye);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaemploye);
                        // 

                        // Vehicle Visitor
                        $CarVisitor = $ds[12];
                        $TruckVisitor = $ds[13];
                        $MotorVisitor = $ds[14];
                        $SepedaVisitor = $ds[15];

                        $CarVisitorArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1',
                            'amount'        => $CarVisitor,
                            'people_id'     => '7',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $TruckVisitorArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '3',
                            'amount'        => $TruckVisitor,
                            'people_id'     => '7',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $MotorVisitorArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '2',
                            'amount'        => $MotorVisitor,
                            'people_id'     => '7',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $SepedaVisitorArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1037',
                            'amount'        => $SepedaVisitor,
                            'people_id'     => '7',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $uploadCarVisitor[] = $CarVisitorArray;
                        $uploadTruckVisitor[] = $TruckVisitorArray;
                        $uploadMotorVisitor[] = $MotorVisitorArray;
                        $uploadSepedaVisitor[] = $SepedaVisitorArray;
                        // 2
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCarVisitor);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckVisitor);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotorVisitor);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaVisitor);
                        // 

                        // Vehicle business partner
                        $CarBp = $ds[16];
                        $TruckBp = $ds[17];
                        $MotorBp = $ds[18];
                        $SepedaBp = $ds[19];
                        $CarBpArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1',
                            'amount'        => $CarBp,
                            'people_id'     => '8',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $TruckBpArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '3',
                            'amount'        => $TruckBp,
                            'people_id'     => '8',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $MotorBpArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '2',
                            'amount'        => $MotorBp,
                            'people_id'     => '8',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $SepedaBpArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1037',
                            'amount'        => $SepedaBp,
                            'people_id'     => '8',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $uploadCarBp[] = $CarBpArray;
                        $uploadTruckBp[] = $TruckBpArray;
                        $uploadMotorBp[] = $MotorBpArray;
                        $uploadSepedaBp[] = $SepedaBpArray;
                        // 3
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCarBp);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckBp);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotorBp);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaBp);
                        // 

                        // Vehicle Contractor
                        $CarContractor = $ds[20];
                        $TruckContractor = $ds[21];
                        $MotorContractor = $ds[22];
                        $SepedaContractor = $ds[23];

                        $CarContractorArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1',
                            'amount'        => $CarContractor,
                            'people_id'     => '9',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $TruckContractorArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '3',
                            'amount'        => $TruckContractor,
                            'people_id'     => '9',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $MotorContractorArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '2',
                            'amount'        => $MotorContractor,
                            'people_id'     => '9',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $SepedaContractorArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1037',
                            'amount'        => $SepedaContractor,
                            'people_id'     => '9',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $uploadCarContractor[] = $CarContractorArray;
                        $uploadTruckContractor[] = $TruckContractorArray;
                        $uploadMotorContractor[] = $MotorContractorArray;
                        $uploadSepedaContractor[] = $SepedaContractorArray;
                        // 
                        // 4 
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCarContractor);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckContractor);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotorContractor);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaContractor);

                        // Vehicle Pool
                        $CarPool = $ds[24];
                        $TruckPool = $ds[25];
                        $MotorPool = $ds[26];
                        $SepedaPool = $ds[27];

                        $CarPoolArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1',
                            'amount'        => $CarPool,
                            'people_id'     => '32',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $TruckPoolArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '3',
                            'amount'        => $TruckPool,
                            'people_id'     => '32',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $MotorPoolArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '2',
                            'amount'        => $MotorPool,
                            'people_id'     => '32',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );

                        $SepedaPoolArray = array(
                            'trans_id'      => $transId,
                            'type_id'       => '1037',
                            'amount'        => $SepedaPool,
                            'people_id'     => '32',
                            'created_at'    => date('Y-m-d H:i:s'),
                            'created_by'    => Session('npk'),
                            'status'        => 1
                        );
                        $uploadCarPool[] = $CarPoolArray;
                        $uploadTruckPool[] = $TruckPoolArray;
                        $uploadMotorPool[] = $MotorPoolArray;
                        $uploadSepedaPool[] = $SepedaPoolArray;
                        // 5
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCarPool);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckPool);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotorPool);
                        // DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaPool);
                    }




                    // document uploaded
                    DB::connection('soabi')->table('admisecdrep_transaction_material')->insert($uploadPKO);
                    DB::connection('soabi')->table('admisecdrep_transaction_material')->insert($uploadSj);
                    // 

                    // people uploaded 
                    DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadEmploye);
                    DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadVisitor);
                    DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadbisPartner);
                    DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($uploadcontractorValue);
                    //

                    // vehicle uploaded
                    // 1
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCaremploye);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckemploye);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotoremploye);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaemploye);
                    // 2
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCarVisitor);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckVisitor);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotorVisitor);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaVisitor);
                    // 3
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCarBp);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckBp);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotorBp);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaBp);
                    // 4
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCarContractor);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckContractor);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotorContractor);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaContractor);
                    // 5
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadCarPool);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadTruckPool);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadMotorPool);
                    DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($uploadSepedaPool);


                    DB::connection('soabi')->commit();
                    return back()->with('success', 'Report upload successfully!');
                } catch (\Exception $e) {
                    DB::connection('soabi')->rollback();
                    // return back()->with('failed', 'Report upload failed!');
                    dd($e);
                }
            }
        }
    }


}
