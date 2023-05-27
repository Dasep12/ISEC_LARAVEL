<?php

namespace Modules\GuardTour\Http\Controllers\api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\api\AuthModels;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Modules\GuardTour\Entities\api\JadwalModels;

class PatroliController extends Controller
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

    public function dataPatroli(Request $req)
    {

        $shift = JadwalModels::getCurrentShift($this->dateNow->format('Y-m-d'));
        if ($shift != null) {
            $res  = JadwalModels::getDataPatroli($this->dateNow->format('Y-m-d'), $shift[0]->shift_id, $this->users->admisecsgp_mstplant_plant_id);
            return response()->json(
                $res
            );
        }
        return response()->json(
            []
        );
    }

    public function getdataTemuan()
    {
        $dataTemuan = JadwalModels::getAllDataTemuan();
        return response()->json(
            $dataTemuan
        );
    }

    public function dataTemuan(Request $req)
    {
        $syncToken = $req->sync_token;
        $data = array(
            'admisecsgp_mstusr_npk'             => $this->users->npk,
            'admisecsgp_mstckp_checkpoint_id'   => $req->admisecsgp_mstckp_checkpoint_id,
            'admisecsgp_mstshift_shift_id'      => $req->admisecsgp_mstshift_shift_id,
            'admisecsgp_mstzone_zone_id'        => $req->admisecsgp_mstzone_zone_id,
            'date_patroli'                      => $this->dateNow->format('Y-m-d'),
            'checkin_checkpoint'                => $req->checkin_checkpoint,
            'checkout_checkpoint'               => $req->checkout_checkpoint,
            'type_patrol'                       => $req->type_patrol,
            'status'                            => $req->status,
            'sync_token'                        => $syncToken,
            'created_at'                        => $this->dateNow->format('Y-m-d H:i:s'),
            'created_by'                        => $this->users->npk,
        );

        $header = DB::table('admisecsgp_trans_headers')
            ->where('sync_token', $syncToken)
            ->select('*')
            ->get();

        if ($header->count() > 0) {
            $headers = $header->first();
            $id = $headers->trans_header_id;
            DB::table('admisecsgp_trans_headers')
                ->where('trans_header_id', $id)
                ->update($data);
        } else {
            DB::table('admisecsgp_trans_headers')
                ->insert($data);
            $id = DB::getPdo()->lastInsertId();
        }

        $details = $req->detail_temuan;
        if ($details) {
            foreach ($details as $k => $detail) {
                $dataDetail = array(
                    //detail
                    'admisecsgp_trans_headers_trans_headers_id' => $id,
                    'admisecsgp_mstobj_objek_id' => $detail['admisecsgp_mstobj_objek_id'],
                    'conditions' => $detail['conditions'],
                    'description' => $detail['description'],
                    'is_laporan_kejadian' => $detail['is_laporan_kejadian'],
                    'laporkan_pic' => $detail['laporkan_pic'],
                    'is_tindakan_cepat' => $detail['is_tindakan_cepat'],
                    'status_temuan' => $detail['status_temuan'],
                    'deskripsi_tindakan' => $detail['deskripsi_tindakan'],
                    'note_tindakan_cepat' => $detail['note_tindakan_cepat'],
                    'status' => $detail['status'],
                    'created_at' => $this->dateNow->format('Y-m-d H:i:s'),
                    'sync_token' => $detail['sync_token'],
                    'created_by' => $this->users->npk,
                );
                if (array_key_exists('admisecsgp_mstevent_event_id', $detail)) {
                    $dataDetail['admisecsgp_mstevent_event_id'] = $detail['admisecsgp_mstevent_event_id'];
                }

                if ($_FILES != null) {
                    $files = array_key_exists('detail_temuan', $_FILES) ? $_FILES['detail_temuan'] : null;
                    $upload_result = array('image_1' => null, 'image_2' => null, 'image_3' => null,);
                    if ($files != null) {
                        $image_field = array('image_1', 'image_2', 'image_3');
                        foreach ($image_field as $key => $field) {
                            if (array_key_exists($k, $files['name'])) {
                                if (array_key_exists($field, $files['name'][$k])) {
                                    $filename = $this->dateNow->getTimestamp() . '_' . $files['name'][$k][$field];
                                    $_FILES[$field]['name'] = $files['name'][$k][$field];
                                    $_FILES[$field]['type'] = $files['type'][$k][$field];
                                    $_FILES[$field]['tmp_name'] = $files['tmp_name'][$k][$field];
                                    $_FILES[$field]['error'] = $files['error'][$k][$field];
                                    $_FILES[$field]['size'] = $files['size'][$k][$field];

                                    $name = $_FILES[$field]['name'];
                                    $uploads_dir = public_path('assets/temuan/');
                                    if (is_uploaded_file($_FILES[$field]['tmp_name'])) {
                                        //in case you want to move  the file in uploads directory
                                        if (!move_uploaded_file($_FILES[$field]['tmp_name'], $uploads_dir . $name)) {
                                            $upload_result[$field] = null;
                                        } else {
                                            $upload_result[$field] = 'assets/temuan/' . $_FILES[$field]['name'];
                                        }
                                    }
                                } else {
                                    $upload_result[$field] = null;
                                }
                            } else {
                                $upload_result[$field] = null;
                            }
                        }
                    }
                    $dataDetail['image_1'] = $upload_result['image_1'];
                    $dataDetail['image_2'] = $upload_result['image_2'];
                    $dataDetail['image_3'] = $upload_result['image_3'];
                } else {
                    $url = URL::to('/');
                    if (array_key_exists('image_1', $detail)) {
                        $dataDetail['image_1'] = str_replace($url, "", $detail['image_1']);
                    }
                    if (array_key_exists('image_2', $detail)) {
                        $dataDetail['image_2'] = str_replace($url, "", $detail['image_2']);
                    }
                    if (array_key_exists('image_3', $detail)) {
                        $dataDetail['image_3'] = str_replace($url, "", $detail['image_3']);
                    }
                }

                $headerDetail =   DB::table('admisecsgp_trans_details')
                    ->where('sync_token', $detail['sync_token'])
                    ->select('*')
                    ->get();

                $countDetail = $headerDetail->count();
                if ($countDetail > 0) {
                    $existingDataDetail = $headerDetail->first();
                    $idDetail = $existingDataDetail->trans_detail_id;

                    DB::table('admisecsgp_trans_details')
                        ->where('trans_detail_id', $idDetail)
                        ->update($dataDetail);
                } else {
                    DB::table('admisecsgp_trans_details')
                        ->insert($dataDetail);
                }
            }
        }

        $result = JadwalModels::getDataTemuan($id);
        return response()->json(
            $result
        );
    }

    public function getPatrolActivity(Request $req)
    {
        $idJadwalPatroli = $req->query('id_jadwal_patroli');
        $activity = DB::table('admisecsgp_patrol_activity')
            ->where('admisecsgp_trans_jadwal_patroli_id_jadwal_patroli', $idJadwalPatroli)
            ->select('*')
            ->get();
        $count = $activity->count();
        if ($count > 0) {
            $data = $activity->first();
        } else {
            $data = new \stdClass();
        }
        return response()->json(
            $data
        );
    }

    public function setPatrolActivity(Request $req)
    {
        $idJadwalPatroli = $req->id_jadwal_patroli;
        $status = $req->status;
        $start_at = $req->start_at;
        $start_end = $req->start_end;
        $data = array(
            'admisecsgp_trans_jadwal_patroli_id_jadwal_patroli' =>  $idJadwalPatroli,
            'status' => $status,
            'start_at' => $start_at,
        );

        if ($start_end) {
            $data['end_at'] = $start_end;
        }


        $activity = DB::table('admisecsgp_patrol_activity')
            ->where('admisecsgp_trans_jadwal_patroli_id_jadwal_patroli', $idJadwalPatroli)
            ->select('*')
            ->get();

        $count = $activity->count();
        if ($count > 0) {
            $existingData = $activity->first();
            $id = $existingData->activity_id;
        } else {
            DB::table('admisecsgp_patrol_activity')
                ->insert($data);
            $id = DB::getPdo()->lastInsertId();
        }

        $activity = DB::table('admisecsgp_patrol_activity')
            ->where('activity_id', $id)
            ->select('*')
            ->get();
        $existingData = $activity->first();
        return response()->json(
            $existingData
        );
    }
}
