<?php

namespace Modules\GuardTour\Http\Controllers\api;

use App\Models\AuthModel;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\api\AuthModels;
use Modules\GuardTour\Entities\api\JadwalModels;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
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
        $this->api = $req->header('X-API-KEY');
        $this->keyApi = AuthModels::checkKey($this->api);
        if (!$this->keyApi) {
            return response([
                'api' => 'not valid'
            ]);
        }
        $this->users = AuthModels::getUsers($this->keyApi->user_id);
    }

    public function jadwalUser(Request $req)
    {

        $accessTime = Carbon::now();
        $zero_clock = new Carbon('00:00:00');
        $six_clock = new Carbon('06:30:00');

        if ($accessTime > $zero_clock && $accessTime < $six_clock) {
            $this->dateNow = Carbon::now()->yesterday();
            $this->dateTomorrow = Carbon::now();
        }
        $response = array();

        $jadwalHariIni  = JadwalModels::getJadwal($this->dateNow->format('Y-m-d'), $this->dateTomorrow->format('Y-m-d'), $this->keyApi->user_id, $this->users->admisecsgp_mstplant_plant_id);
        if ($jadwalHariIni != null) {
            $response = $jadwalHariIni;
        }
        return response($response);
    }

    public function shift()
    {
        $accessTime = Carbon::now();
        $zero_clock = new Carbon('00:00:00');
        $six_clock = new Carbon('06:30:00');

        if ($accessTime > $zero_clock && $accessTime < $six_clock) {
            $this->dateNow = Carbon::now()->yesterday();
            $this->dateTomorrow = Carbon::now();
        }
        $shift = JadwalModels::getShift($this->dateNow->format('Y-m-d'));
        return response($shift);
    }
}
