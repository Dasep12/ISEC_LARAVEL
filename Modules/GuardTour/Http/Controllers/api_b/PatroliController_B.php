<?php

namespace Modules\GuardTour\Http\Controllers\api_b;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


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
        $this->api = $req->header('X-API-KEY');
        $this->keyApi = AuthModels::checkKey($this->api);
        if (!$this->keyApi) {
            return response([
                'api' => 'not valid'
            ]);
        }
        $this->users = AuthModels::getUsers($this->keyApi->user_id);

        $accessTime = Carbon::now();
        $zero_clock = new Carbon('00:00:00');
        $six_clock = new Carbon('06:30:00');

        if ($accessTime > $zero_clock && $accessTime < $six_clock) {
            $this->dateNow = Carbon::now()->yesterday();
            $this->dateTomorrow = Carbon::now();
        }
    }
}
