<?php

namespace Modules\GuardTour\Http\Controllers\api_b;

use App\Helpers\BulanHelper;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\Api_B\AuthPatrolModels;

class AuthController_B extends Controller
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
    private $shiftCurrent;

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

        $shiftOne_clock = new Carbon('07:00:00');
        $shiftTwo_clock = new Carbon('15:00:00');
        $shiftThree_clock = new Carbon('23:00:00');

        if ($accessTime > $shiftOne_clock && $accessTime < $shiftTwo_clock) {
            $this->shiftCurrent = "1";
        } else if ($accessTime > $shiftTwo_clock && $accessTime < $shiftThree_clock) {
            $this->shiftCurrent = "2";
        } else  if ($accessTime < $shiftOne_clock && $accessTime > $shiftThree_clock) {
            $this->shiftCurrent = "3";
        }

        
    }


    public function login(Request $req)
    {
        $npk        = $req->npk;
        $password   = md5($req->password);

        // shift_now
        $shift_now = AuthPatrolModels::getShiftPatrol($this->dateNow, $npk);
        // end

        // current shft
        $currentShift = AuthPatrolModels::getCurrentShiftPatrol($this->shiftCurrent, $this->dateNow->format('Y-m-d'));

        // $shift_besok 
        $shift_tommorow = AuthPatrolModels::getShiftPatrol($this->dateTomorrow, $npk);
        // end

        // date patroli 
        $currentDatePatrol = BulanHelper::convertHari($this->dateNow->format('D')) . ' ' . $this->dateNow->format('d') . ' ' . BulanHelper::convertMonth($this->dateNow->format('m')) . ' ' . $this->dateNow->format('Y');
        $nextDatePatroli = BulanHelper::convertHari($this->dateTomorrow->format('D')) . ' ' . $this->dateTomorrow->format('d') . ' ' . BulanHelper::convertMonth($this->dateTomorrow->format('m')) . ' ' . $this->dateTomorrow->format('Y');
        // end


        // CARI NPK DAN PASSWORD
        $foundAkun = AuthPatrolModels::getAkun($npk, $password);
        // END

        // result identitas 
        $resUser  = AuthPatrolModels::getUsers($npk);
        // end


        // result jadwal patroli 
        $resJadwalPatroli = AuthPatrolModels::getJadwalPatroli($this->dateNow->format('Y-m-d'), $npk);
        // end

        // dd($shift_tommorow);

        if ($foundAkun->count() > 0) {
            return response()->json([
                'status'    => true,
                'shift_now' => array(
                    $currentShift
                ),
                "shift_patroli_hari_ini" => $shift_now->shift,
                "shift_patroli_selanjutnya" => isset($shift_tommorow) ? $shift_tommorow->shift : '-',
                "tanggal_patroli_sekarang" => $currentDatePatrol,
                "tanggal_patroli_selanjutnya" => $nextDatePatroli,
                'result' => array($resUser),
                "status_jadwal" => $resJadwalPatroli->count() <= 0 ? false : true,
                "jadwal_patroli" => array(
                    $resJadwalPatroli->first()
                )
            ]);
        } else {
            return response()->json(
                [
                    'status'    => false,
                    'result'    =>  'NPK atau password salah'
                ]
            );
        }
    }
}
