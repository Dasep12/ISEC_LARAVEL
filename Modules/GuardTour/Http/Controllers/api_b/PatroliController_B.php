<?php

namespace Modules\GuardTour\Http\Controllers\api_b;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Modules\GuardTour\Entities\api_b\PatroliModels;
use Modules\GuardTour\Entities\Patroli;

class PatroliController_B extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */


    /**
     * @var DateTime
     */

    private $dateNow;
    private $dateTomorrow;
    private $api;
    private $keyApi;
    private $users;

    public function __construct(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dateNow = Carbon::now();
        $this->dateTomorrow = Carbon::now()->addDay(1);

        $accessTime = Carbon::now();
        $zero_clock = new Carbon('00:00:00');
        $six_clock = new Carbon('06:30:00');

        if ($accessTime > $zero_clock && $accessTime < $six_clock) {
            $this->dateNow = Carbon::now()->yesterday();
            $this->dateTomorrow = Carbon::now();
        }
    }

    public function getZonaPatroli(Request $req)
    {
        $plant = $req->id_plant;
        $shift = $req->id_shift;
        $date  = $req->tanggal;


        $resZonaPatroli = PatroliModels::getZonaPatroli($date, $plant, $shift);

        if ($resZonaPatroli->count() > 0) {
            return response()->json([
                'message'   => "patroli berlangsung",
                'status'    => true,
                'result'    => $resZonaPatroli->get()
            ]);
        }

        return response()->json([
            'message'   => "patroli berlangsung",
            'status'    => false,
            'result'    => $resZonaPatroli->get()
        ]);
    }

    public function getCheckpointPatroli(Request $req)
    {

        $plant = $req->get('id');
        $shift = $req->get('shift_id');
        $date  = $req->get('tanggal');
        $resCheckpoint = PatroliModels::getCheckpointPatroli($date, $plant, $shift);

        if ($resCheckpoint->count() <= 0) {
            return response()->json([
                'status'    => false,
                'message'   => 'checkpoint tidak ditemukan',
                "result" => $resCheckpoint->get()
            ]);
        }

        return response()->json([
            'status' => true,
            "message" => "data ditemukan",
            "total_checkpoint" => $resCheckpoint->count(),
            "result" => $resCheckpoint->get()
        ]);
    }

    public function getObjekPatroli(Request $req)
    {
        $plant = $req->get('id');
        $resObjek  = PatroliModels::getObjekPatroli($plant);

        if (count($resObjek) <= 0) {
            return response()->json([
                'status'    => false,
                'message'   => 'objek tidak ditemukan',
                'result'    => $resObjek
            ]);
        }


        return response()->json([
            "status"  => true,
            "message" => "data ditemukan",
            "total_objek" => count($resObjek),
            "result" => $resObjek
        ]);
    }

    public function getEventPatroli(Request $req)
    {
        $plant = $req->get('id');
        $resEvent  = PatroliModels::getEventPatroli($plant);

        if (count($resEvent) <= 0) {
            return response()->json([
                'status'    => false,
                'message'   => 'Event tidak ditemukan',
                'result'    => $resEvent
            ]);
        }


        return response()->json([
            "status"  => true,
            "message" => "data ditemukan",
            "total_event" => count($resEvent),
            "result" => $resEvent
        ]);
    }


    public function HitungWaktuPatroli(Request $req)
    {
        $shift   = $req->shift;
        $tanggal = $req->tanggal;
        $jam     = $req->jam;
        if ($shift == 3) {
            $tgl_sekarang    = strtotime($tanggal);
            $v    = date('Y-m-d', strtotime("+1 day", $tgl_sekarang));
        } else {
            $v = $tanggal;
        }
        $now   = date('Y-m-d H:i:s');
        $awal  = strtotime($now);
        $akhir = strtotime($v . ' ' . $jam);
        $diff  = $akhir - $awal;
        $mnt   = floor($diff / (60));

        if ($shift == 'LIBUR') {
            // echo "libur ";
            return response()->json([
                'status'    => false,
                'message'   => 'anda sedang libur',
            ], 200);
        } else {
            $data = DB::select("select jam_masuk  , jam_pulang from admisecsgp_mstshift where nama_shift='" . $shift . "' ");

            $sekarang  = strtotime(date('Y-m-d H:i:s'));
            $masuk     = strtotime($tanggal . ' ' . $data[0]->jam_masuk);
            if ($shift == 3) {
                $pulang    = strtotime($v . ' ' . $data[0]->jam_pulang);
            } else {
                $pulang    = strtotime($tanggal . ' ' . $data[0]->jam_pulang);
            }
            // jika data 
            //jika jam sekarang lebih besar dari jam masuk dan
            //jam sekarang lebih kecil dari jam pulang 
            if ($sekarang >= $masuk && $sekarang <= $pulang) {
                if ($mnt <= 30) {
                    return response()->json([
                        'status'    => false,
                        'patroli'   => 'end',
                        'message'   => 'patroli sudah berakhir',
                    ], 200);
                } else {
                    return response()->json([
                        'status'    => true,
                        'patroli'   => 'start',
                        'message'   => 'patroli di mulai',
                    ], 200);
                }
            } else {
                $this->response()->json([
                    'status'    => false,
                    'patroli'   => 'nok',
                    'message'   => 'patroli belum waktunya',
                ], 200);
            }
        }
    }

    public function ShowCheck(Request $req)
    {
        $plant_id =  $req->plant_id;
        $zona_id  = $req->zona_id;
        $query = PatroliModels::showTemuan($plant_id, $zona_id);
        if ($query->num_rows() > 0) {
            return response()->json(
                [
                    'status'        => true,
                    'link'          => URL::to('uploads/events/'),
                    'total_temuan'  => count($query),
                    'list_temuan'   => $query
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status'        => false,
                    'link'          => URL::to('uploads/events/'),
                    'total_temuan'  => count($query),
                    'list_temuan'   => $query
                ],
                200
            );
        }
    }

    public function persentasePatroli(Request $req)
    {
        $plant_id = $req->plant_id;
        $shift_id  = $req->shift_id;
        $date     = $req->tanggal;
        $tipe_patrol     = $req->tipe_patrol;

        $query = PatroliModels::showPersentase($plant_id, $date, $shift_id, $tipe_patrol);
        if (count($query) > 0) {
            $data = $query;
            return response()->json(
                [
                    'status'      => true,
                    'persentase'  => round($data[0]->persentase),
                    'target'      => $data[0]->persentase == 100 ? 1 : 0
                ],
                200
            );
        } else {
            $data = $query;
            return response()->json(
                [
                    'status'      => false,
                    'persentase'  => 0,
                    'target'      => 0
                ],
                200
            );
        }
    }
}
