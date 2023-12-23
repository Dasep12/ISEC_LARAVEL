<?php

namespace Modules\GuardTour\Http\Controllers;

use App\Helpers\BulanHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\JadwalPatroli;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Shift;
use Ramsey\Uuid\Uuid;

date_default_timezone_set('Asia/Jakarta');

class JadPatroliController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function master(Request $req)
    {

        $date = date('Y-m');
        $date2 = date('F,Y');
        $plant_id = "";
        $headerJadwal = "";
        if (isset($_POST['submit'])) {
            $date = $req->date;
            $date2 = $req->date_var;
            $plant_id = $req->plant;
            $headerJadwal = JadwalPatroli::headerJadwalPatroli($date, $plant_id);

            // echo $date . "<br>" . $plant_id;
            // dd($headerJadwal);
        }

        $pl =   Session('role') == 'SUPERADMIN' ? Plants::where('status', 1)->get() : Plants::where([
            ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
            ['status', '=', 1],
        ])->get();

        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::jadwal_patroli/master_jadwal_patroli', [
            'uri'        => $uri,
            'plants'     => $pl,
            'date'       => $date,
            'date2'      => $date2,
            'month'      => BulanHelper::convertMonth(explode('-', $date)[1]),
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
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);

        $plant =  Session('role') == 'SUPERADMIN' ? Plants::all() : Plants::where('admisecsgp_mstsite_site_id', Session('site_id'))->get();

        return view('guardtour::jadwal_patroli/form_edit_jadwal_patroli', [
            'uri'        => $uri,
            'plants'     => $plant,
            'data'       => $headerJadwal,
            'date'       => $date,
            'plant_id'   => $plant_id,
            'shift'      => Shift::all()
        ]);
    }

    public function updateJadwal(Request $req)
    {
        $id  = $req->id;
        $shift = $req->shift;
        $data = JadwalPatroli::find($id);
        $data->admisecsgp_mstshift_shift_id  = $shift;
        if ($data->save()) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function form_upload()
    {

        $plant =  Session('role') == 'SUPERADMIN' ? Plants::where('status', 1)->get() : Plants::where([
            ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
            ['status', '=', 1],
        ])->get();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::jadwal_patroli/form_upload_jadwal_patroli', [
            'uri'        => $uri,
            'plants'     => $plant
        ]);
    }

    public function uploadJadwal(Request $req)
    {
        if ($req->file('file')) {
            $file = $req->file('file');
            $filename = 'TMPJDWL' . $file->getClientOriginalName();
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

            // cek inputan plant 
            if ($plant) {

                // cek validasi plant inputan dengan plant di excel
                if ($plant->plant_id != $req->plant) {
                    return redirect()->route('jadpatroli.form_upload')->with(['failed' => 'Plant Yang di pilih  Tidak Sama Dengan Di Plant File Anda']);
                    die();
                }

                // cek validasi tanggal di pilih dengan tanggal di file excel
                if ($date != $req->date) {
                    return redirect()->route('jadpatroli.form_upload')->with(['failed' => 'Periode Bulan Yang di pilih  Tidak Sama Dengan Periode Bulan di File Anda']);
                    die();
                }

                // cek apakah jadwal sudah pernah terupload apa belum
                $jdwl = JadwalPatroli::cekJadwalPatroli($date, $plant->plant_id);
                if ($jdwl != null) {
                    // echo "jadwal sudah ada";
                    return redirect()->route('jadpatroli.form_upload')->with(['failed' => 'Jadwal Patroli Periode ' . $date . ' Sudah Ada']);
                    die();
                }
                $data_jadpatroli = array();
                foreach ($datajadwal as $dj) {
                    $npk = $dj[0];
                    $name = $dj[1];

                    // cek apakah nama petugas sudah sesuai apa belum dengan di master user 
                    $petugas = JadwalPatroli::cekPetugasPatroli($npk, $name, $plant->plant_id);
                    if ($petugas == null) {
                        // echo "user tidak ada";
                        return redirect()->route('jadpatroli.form_upload')->with(['failed' => 'User' . $name . ' Tidak Ditemukan']);
                        die();
                    }
                    $l = 2;
                    $shift = array();
                    for ($i = 1; $i <= (count($datajadwal[7]) - 2); $i++) {
                        //cek penulisan shift 
                        $cekShift = JadwalPatroli::cekShift($dj[$l]);
                        if ($cekShift == null) {
                            return redirect()->route('jadpatroli.form_upload')->with(['failed' => 'Data Shift Tidak Ada']);
                            die();
                        }

                        // kolek data jadwal patroli ke dalam fungsi array
                        $sh = [
                            'tanggal_' . $i => $dj[$l]
                        ];
                        array_push($shift, $sh);
                        $l++;
                    }

                    $day = 1;
                    for ($b = 0; $b < count($shift); $b++) {
                        $SHIFT  = Shift::where('nama_shift', $shift[$b]['tanggal_' . $day])->first();

                        $data = array(
                            'id_jadwal_patroli'            => $this->attributes['uuid'] = Uuid::uuid4()->toString(),
                            'admisecsgp_mstshift_shift_id' =>  $SHIFT->shift_id,
                            'admisecsgp_mstplant_plant_id' => $plant->plant_id,
                            'admisecsgp_mstusr_npk'        => $npk,
                            'date_patroli'                 => $date . '-' . $day,
                            'created_at'                   => date('Y-m-d H:i:s'),
                            'created_by'                   => Session('npk'),
                            'status'                       => 1,
                        );
                        array_push($data_jadpatroli, $data);
                        $day++;
                    }
                }

                DB::beginTransaction();

                try {
                    JadwalPatroli::insert($data_jadpatroli);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
                File::delete(public_path() . '/assets/jadwal/' .  $filename);
                return redirect()->route('jadpatroli.form_upload')->with(['success' => 'Data Berhasil di Upload']);
            } else {
                return redirect()->route('jadpatroli.form_upload')->with(['failed' => 'Data Plant Tidak Ditemukan']);
            }
        }
    }
}
