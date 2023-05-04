<?php

namespace Modules\GuardTour\Http\Controllers;

use App\Helpers\BulanHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

    public function master()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::jadwal_patroli/master_jadwal_patroli', [
            'uri'        => $uri,
            'plants'     => Plants::all()
        ]);
    }

    public function view_jadwal(Type $var = null)
    {
        # code...
    }

    public function form_upload()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::jadwal_patroli/form_upload_jadwal_patroli', [
            'uri'        => $uri,
            'plants'     => Plants::all()
        ]);
    }

    public function uploadJadwal(Request $req)
    {
        if ($req->file('file')) {
            $file = $req->file('file');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('assets/jadwal/'), $filename);

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

                JadwalPatroli::insert($data_jadpatroli);
                return redirect()->route('jadpatroli.master')->with(['success' => 'Data Berhasil di Perbarui']);
            } else {
                return redirect()->route('jadpatroli.form_upload')->with(['failed' => 'Data Plant Tidak Ditemukan']);
            }
        }
    }
}
