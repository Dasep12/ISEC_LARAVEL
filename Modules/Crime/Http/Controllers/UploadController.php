<?php

namespace Modules\Crime\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('crime::form/upload', [
            'uri'   => \Request::segment(2),
        ]);
    }

    public function upload_data(Request $req)
    {
        if ($req->file('file')) {
            $file = $req->file('file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('assets/upload_crime/'), $filename);
            $path_xlsx        = "assets/upload_crime/" . $filename;
            $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet      = $reader->load($path_xlsx);
            $dataCrime       = $spreadsheet->getSheet(0)->toArray();
            unset($dataCrime[0]);
            $params = array();
            DB::connection('crime')->beginTransaction();
            try {
                foreach ($dataCrime as $crm) {
                    $data = array(
                        'tanggal'       => strval($crm[1]),
                        'area_tkp'      => strval($crm[2]),
                        'jenis_kasus'   => strval($crm[3]),
                        'kategori'      => strval($crm[4]),
                        'pelapor'       => strval($crm[5]),
                        'tersangka'     => strval($crm[6]),
                        'korban'        => strval($crm[7]),
                        'barang_bukti'  => strval($crm[8]),
                        'jenis'         => strval($crm[9]),
                        'kerugian'      => strval($crm[10]),
                        'modus'         => strval($crm[10]),
                        'kronologi'     => strval($crm[12]),
                        'kota'          => strval($crm[13]),
                        'kelurahan'     => strval($crm[14]),
                        'kec'           => strval($crm[15]),
                        'types'         => strval($crm[16]),
                        'status'        => 1,
                        'created_at'    => strval(date('Y-m-d H:i:s'))
                    );
                    array_push($params, $data);
                }

                DB::connection('crime')->table('admisec_Tcrime')->insert($params);
                DB::connection('crime')->commit();
                return back()->with('success', 'Update data success !');
            } catch (\Exception $e) {
                DB::connection('crime')->rollback();
                return back()->with('failed', 'Update data failed !');
                // dd($e);
            }
        }
    }

    public function getList_crime(Request $req)
    {
        $data = DB::connection('crime')->select("SELECT * FROM admisec_Tcrime");
        return response()->json($data);
    }
}
