<?php

namespace Modules\GuardTour\Http\Controllers;

use App\Helpers\BulanHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\JadwalPatroli;
use Modules\GuardTour\Entities\JadwalProduksi;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Produksi;
use Modules\GuardTour\Entities\Shift;
use Modules\GuardTour\Entities\Zona;
use Ramsey\Uuid\Uuid;

date_default_timezone_set('Asia/Jakarta');

class JadProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function master(Request $req)
    {

        $date = date('Y-m');
        $plant_id = "";
        $headerJadwal = "";
        $month = "";

        if (isset($_POST['submit'])) {
            $date = $req->date;
            $month = BulanHelper::convertMonth(explode('-', $date)[1]);
            $plant_id = $req->plant;
            $headerJadwal = JadwalProduksi::headerJadwalProduksi($date, $plant_id);
        }

        $plant =  Session('role') == 'SUPERADMIN' ? Plants::all() : Plants::where('admisecsgp_mstsite_site_id', Session('site_id'))->get();

        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::jadwal_produksi/master_jadwal_produksi', [
            'uri'        => $uri,
            'plants'     => $plant,
            'date'       => $date,
            'month'      => $month,
            'plant_id'   => $plant_id,
            'header'     => $headerJadwal
        ]);
    }

    public function edit_jadwal(Request $req)
    {
        $date = date('Y-m-d');
        $plant_id = "";
        $headerJadwal = "";
        if (isset($_POST['submit'])) {
            $date = $req->date;
            $plant_id = $req->plant;
            $headerJadwal = JadwalPatroli::getPatroliPerTanggal($date, $plant_id);
        }
        $plant =  Session('role') == 'SUPERADMIN' ? Plants::all() : Plants::where('admisecsgp_mstsite_site_id', Session('site_id'))->get();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::jadwal_patroli/form_edit_jadwal_patroli', [
            'uri'        => $uri,
            'plants'     => $plant,
            'data'       => $headerJadwal,
            'date'       => $date,
            'plant_id'   => $plant_id,
            'shift'      => Shift::all()
        ]);
    }

    public function updateProduksi(Request $req)
    {
        $id  = $req->id;
        $stat = $req->status;
        $data = JadwalProduksi::find($id);
        $data->status_zona  = $stat;
        $data->updated_at = date('Y-m-d H:i:s');
        $data->updated_by = Session('npk');
        if ($data->save()) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function form_upload()
    {

        $plant =  Session('role') == 'SUPERADMIN' ? Plants::all() : Plants::where('admisecsgp_mstsite_site_id', Session('site_id'))->get();

        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::jadwal_produksi/form_upload_jadwal_produksi', [
            'uri'        => $uri,
            'plants'     => $plant
        ]);
    }

    public function uploadJadwal(Request $req)
    {
        if ($req->file('file')) {
            $file = $req->file('file');
            $filename = 'TMPPRD' . $file->getClientOriginalName();
            $file->move(public_path('assets/jadwal/'), $filename);
            // $exe = pathinfo(public_path('assets/jadwal/' . $filename), PATHINFO_EXTENSION);
            $path_xlsx        = 'assets/jadwal/' . $filename;
            $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet      = $reader->load($path_xlsx);
            $datajadwal       = $spreadsheet->getSheet(0)->toArray();
            $sheet1 = $spreadsheet->getSheet(0);
            $bulan = $sheet1->getCell('B2');
            $tahun = $sheet1->getCell('B3');
            $plants = $sheet1->getCell('B5');
            $bln =  BulanHelper::convertBulan(strtoupper($bulan));
            $date = $tahun . '-' . $bln;
            $plant  = Plants::where('plant_name', $plants)->first();

            for ($r = 0; $r <= 6; $r++) {
                unset($datajadwal[$r]);
            }

            // dd($datajadwal);

            // cek inputan plant 
            if ($plant) {
                // cek validasi plant inputan dengan plant di excel
                if ($plant->plant_id != $req->plant) {
                    return redirect()->route('jadproduksi.form_upload')->with(['failed' => 'Plant Yang di pilih  Tidak Sama Dengan Di Plant File Anda']);
                    die();
                }
                // cek validasi tanggal di pilih dengan tanggal di file excel
                if ($date != $req->date) {
                    return redirect()->route('jadproduksi.form_upload')->with(['failed' => 'Periode Bulan Yang di pilih  Tidak Sama Dengan Periode Bulan di File Anda']);
                    die();
                }

                // cek apakah jadwal sudah pernah terupload apa belum
                $jdwl = JadwalProduksi::cekJadwalProduksi($date, $plant->plant_id);
                if ($jdwl != null) {
                    // echo "jadwal sudah ada";
                    return redirect()->route('jadproduksi.form_upload')->with(['failed' => 'Jadwal Produksi Periode ' . $date . ' Sudah Ada']);
                    die();
                }


                $dataproduksi = array();
                foreach ($datajadwal as $prd) {
                    $keyStatus = 3;
                    $var_shift = Shift::where('nama_shift', $prd[1])->first();
                    $var_zona = Zona::where('zone_name', $prd[0])->first();
                    $l = 1;
                    for ($p = 2; $p <= count($datajadwal[7]) - 2; $p += 2) {

                        // cek validasi penamaan produksi / non-produksi di kolom tanggal excel
                        $produksiData = Produksi::where('name', $prd[$p])->first();
                        if (!$produksiData) {
                            return redirect()->route('jadproduksi.form_upload')->with(['failed' => 'Value ' . $prd[$p] . ' tidak sesuai format']);
                            die();
                        }

                        // cek penulisan on off untuk kolom status zona
                        if (strval($prd[$keyStatus]) == "on" || strval($prd[$keyStatus]) == "off") {
                        } else {
                            return redirect()->route('jadproduksi.form_upload')->with(['failed' => 'Value ' . $prd[$keyStatus] . ' tidak sesuai format']);
                            die();
                        }


                        $data =  array(
                            'id_zona_patroli'                    => $this->attributes['uuid'] = Uuid::uuid4()->toString(),
                            'date_patroli'                       => $date . '-' . $l,
                            'admisecsgp_mstplant_plant_id'       => $plant->plant_id,
                            'admisecsgp_mstshift_shift_id'       => $var_shift->shift_id,
                            'admisecsgp_mstzone_zone_id'         => $var_zona->zone_id,
                            'admisecsgp_mstproduction_produksi_id' => $produksiData->produksi_id,
                            'status_zona'                        => $prd[$keyStatus] == 'on' ? 1 : 0,
                            'status'                             => 1,
                            'created_at'                         => date('Y-m-d H:i:s'),
                            'created_by'                         => Session('npk')
                        );

                        // array_push($dataproduksi, $data);
                        $dataproduksi[] = $data;
                        $keyStatus += 2;
                        $l++;
                    }
                }


                DB::beginTransaction();
                try {
                    for ($i = 0; $i < count($dataproduksi); $i++) {
                        JadwalProduksi::insert($dataproduksi[$i]);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }

                File::delete(public_path() . '/assets/jadwal/' .  $filename);
                return redirect()->route('jadproduksi.form_upload')->with(['success' => 'Data Berhasil di Upload']);
            } else {
                return redirect()->route('jadproduksi.form_upload')->with(['failed' => 'Data Plant Tidak Ditemukan']);
            }
        }
    }
}
