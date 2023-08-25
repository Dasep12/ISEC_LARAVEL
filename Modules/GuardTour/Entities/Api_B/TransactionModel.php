<?php

namespace Modules\GuardTour\Entities\api_b;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use AuthHelper;

class TransactionModel extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\Api\TransactionModelFactory::new();
    }

    public static function checkpointInsert($req)
    {
        $npk = $req->npk;
        $checkpoint_id = $req->checkpoint_id;
        $zone_id = $req->zone_id;
        $shift_id = $req->shift_id;
        $date_patroli = $req->date_patroli;
        $datetime_ckp_post = $req->time_checkpoint;
        $time_checkpoint = substr($datetime_ckp_post, 11, 2) == '24' ? date('Y-m-d H:i:s', strtotime('-1 day', strtotime($datetime_ckp_post))) : date('Y-m-d H:i:s', strtotime($datetime_ckp_post));
        $type_patrol = $req->type_patrol; // Patroli sesuai jadwal
        $sync_token = self::generateToken($npk);
            
        $q = "SELECT count(1) count_duplikat_ckp 
                    FROM admisecsgp_trans_headers 
                WHERE date_patroli='$date_patroli' AND admisecsgp_mstusr_npk='$npk' AND admisecsgp_mstshift_shift_id='$shift_id' AND admisecsgp_mstzone_zone_id='$zone_id' AND admisecsgp_mstckp_checkpoint_id='$checkpoint_id' and type_patrol='$type_patrol'";

        $res = DB::connection('sqlsrv')->select($q);

        if($res[0]->count_duplikat_ckp > 0)
        {
            return '01';
        }
        else
        {
            $q = "INSERT INTO admisecsgp_trans_headers(checkin_checkpoint, date_patroli, admisecsgp_mstusr_npk, admisecsgp_mstshift_shift_id, admisecsgp_mstzone_zone_id, admisecsgp_mstckp_checkpoint_id, status, created_at, created_by, type_patrol, sync_token) 
                VALUES('$time_checkpoint', '$date_patroli', '$npk', '$shift_id', '$zone_id', '$checkpoint_id', 1, getdate(), '$npk', $type_patrol, '$sync_token')";

            $res = DB::connection('sqlsrv')->insert($q);
            // dd($res);

            if($res)
            {
                return '00';
            }
            else
            {
                return '02';
            }
        }
    }

    public static function insertNormal($req)
    {
        $tgl_patroli = $req->tgl_patroli;
        $npk = $req->npk;
        $shift_id = $req->shift_id;
        $object_id = $req->object_id;
        $checkpoint_id = $req->checkpoint_id;
        $type_patrol = $req->type_patrol;
        $sync_token = self::generateToken($npk);
        
        $q = "SELECT TOP 1 trans_header_id header_id, (SELECT count(1) FROM admisecsgp_trans_details WHERE admisecsgp_trans_headers_trans_headers_id=trans_header_id AND admisecsgp_mstobj_objek_id='$object_id' AND conditions=1) count_duplikat_obj 
                FROM admisecsgp_trans_headers 
            WHERE admisecsgp_mstusr_npk='$npk' AND admisecsgp_mstshift_shift_id='$shift_id' AND admisecsgp_mstckp_checkpoint_id='$checkpoint_id' AND date_patroli='$tgl_patroli' AND type_patrol='$type_patrol'
        ";

        $res = DB::connection('sqlsrv')->select($q);

        if(count($res) > 0)
        {
            $data_header = $res;

            if($data_header[0]->count_duplikat_obj > 0)
            {
                return '02'; // Exist Data  
            }
            else
            {
                $fieldDetail = array(
                    'admisecsgp_trans_headers_trans_headers_id' => $data_header[0]->header_id,
                    'admisecsgp_mstobj_objek_id' => $object_id,
                    'conditions' => 0,
                    // 'ms_event_id' => $event_id,
                    // 'description' => $deskripsi,
                    'laporkan_pic' => 0,
                    'is_tindakan_cepat' => 0,
                    'is_laporan_kejadian' => 0,
                    'status_temuan' => 1, // normal
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $npk,
                    'sync_token' => $sync_token,
                );

                // $q2 = $this->db->insert('admisecsgp_trans_details', $fieldDetail);

                $res = DB::connection('sqlsrv')->table('admisecsgp_trans_details')->insert($fieldDetail);

                if($res)
                {
                    return '00';
                }
                else
                {
                    return '04';
                }
            }
        }
        else
        {
            return '01';
        }
    }

    public static function insertAbnormal($req)
    {
        $npk = $req->npk;
        $tgl_patroli = $req->tgl_patroli;
        $shift_id = $req->shift_id;
        $event_id = $req->event_id;
        $object_id = $req->object_id;
        $checkpoint_id = $req->checkpoint_id;
        $deskripsi = $req->deskripsi;
        $deskripsi_tindakan = $req->deskripsi_tindakan;
        $lap_pic = $req->lap_pic;
        $tindakan = $req->tindakan;
        $status_temuan = $tindakan == 1 ? 1 : 0;
        $created_at = $req->created_at;
        $sync_token = self::generateToken($npk);
        $type_patrol = $req->type_patrol;

        $q = "SELECT TOP 1 trans_header_id header_id,
                (SELECT COUNT(trans_detail_id) FROM admisecsgp_trans_details WHERE admisecsgp_trans_headers_trans_headers_id=trans_header_id AND admisecsgp_mstobj_objek_id='$object_id' AND conditions=0) count_duplikat_obj, 
                (select TOP 1 admisecsgp_mstplant_plant_id from admisecsgp_mstusr where npk='$npk') plant_id 
            FROM admisecsgp_trans_headers WHERE admisecsgp_mstusr_npk='$npk' AND admisecsgp_mstshift_shift_id='$shift_id' AND admisecsgp_mstckp_checkpoint_id='$checkpoint_id' AND date_patroli='$tgl_patroli' AND type_patrol='$type_patrol'
        ";

        $res = DB::connection('sqlsrv')->select($q);

        if(count($res) > 0)
        {
            $data_header = $res;

            if($data_header[0]->count_duplikat_obj > 0)
            {
                return '02'; // Exist Data  
            }
            else
            {
                $upload = self::uploadMultiple($req->file('images'), $event_id);

                if($upload == '01')
                {
                    return '03';
                }

                $field_img = [];
                $imgs_link = array();
                foreach ($upload as $key => $item_file) {

                    $field_img['image_'.($key+1)] = 'assets/temuan/'.$item_file['fileName'];

                    $imgs_link[] = URL('assets/temuan/'.$item_file['fileName']);
                }

                $fieldDetail = array(
                    'admisecsgp_trans_headers_trans_headers_id' => $data_header[0]->header_id,
                    'admisecsgp_mstobj_objek_id' => $object_id,
                    'admisecsgp_mstevent_event_id' => $event_id,
                    'conditions' => 0,
                    'description' => strtoupper($deskripsi),
                    'deskripsi_tindakan' => $tindakan == 1 ? strtoupper($deskripsi_tindakan) : NULL,
                    'is_laporan_kejadian' => 0,
                    'laporkan_pic' => $lap_pic,
                    'is_tindakan_cepat' => $tindakan,
                    'status_temuan' => $status_temuan, // belum diclose
                    'status' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $npk,
                    'sync_token' => $sync_token,
                );

                $resField = array_merge($fieldDetail, $field_img);

                $res = DB::connection('sqlsrv')->table('admisecsgp_trans_details')->insert($resField);
                
                if($res)
                {
                    return '00';
                }
                else
                {
                    return '04';
                }
            }
        }
        else
        {
            return '01';
        }
    }

    public static function insertFinishCheckpoint($req)
    {
        $tgl_patroli = $req->date_patrol;
        // $time_finish = date("Y-m-d H:i:s", strtotime($req->time_finish));
        $datetime_finish_post = $req->time_finish;
        $time_finish = substr($datetime_finish_post, 11, 2) == '24' ? date('Y-m-d H:i:s', strtotime('-1 day', strtotime($datetime_finish_post))) : date('Y-m-d H:i:s', strtotime($datetime_finish_post));

        $npk = $req->npk;
        $shift_id = $req->shift_id;
        $checkpoint_id = $req->checkpoint_id;
        $type_patrol = $req->type_patrol;

        $q = "SELECT TOP 1 trans_header_id 
                FROM admisecsgp_trans_headers 
            WHERE admisecsgp_mstusr_npk='$npk' AND admisecsgp_mstshift_shift_id='$shift_id' AND admisecsgp_mstckp_checkpoint_id='$checkpoint_id' AND date_patroli='$tgl_patroli' AND type_patrol='$type_patrol'
        ";

        $res = DB::connection('sqlsrv')->select($q);

        if(count($res) > 0)
        {
            $data_header = $res;

            $header_id = $data_header[0]->trans_header_id;
            $update_on = date('Y-m-d H:i:s');

            // dd($time_finish);

            $q = "UPDATE admisecsgp_trans_headers SET checkout_checkpoint='$time_finish', updated_at='$update_on' WHERE trans_header_id='$header_id'
            ";

            $res = DB::connection('sqlsrv')->update($q);

            if($req)
            {
                // $this->db->trans_commit();
                return '00';
            }
            else
            {
                // $this->db->trans_rollback();

                return '02';

            }
        }
        else
        {
            return '01';
        }
    }

    public static function sendEmailAbnormal($req)
    {
        $p_npk = $req->npk;
        $p_plant_id = $req->plant_id;
        $p_tgl_patroli = $req->tgl_patroli;
        $p_shift_id = $req->shift_id;
        $p_type_patrol = $req->type_patrol;

        $q = "SELECT st.nilai_setting, pl.plant_name, eo.nama_objek, eok.event_name, cz.check_name, cz.zone_name, td.description, td.image_1, td.image_2, td.image_3
            FROM admisecsgp_trans_headers th
            INNER JOIN admisecsgp_trans_details td ON td.admisecsgp_trans_headers_trans_headers_id=th.trans_header_id AND td.laporkan_pic=1
            INNER JOIN admisecsgp_mstplant pl ON pl.plant_id='$p_plant_id'
                JOIN (
                    select sst.nama_setting, sst.nilai_setting, sst.type, sst.unit
                    from admisecsgp_setting sst
                    group by sst.nama_setting, sst.nilai_setting, sst.type, sst.unit
                ) st ON st.nama_setting='email_config'
                JOIN (
                    select sob.objek_id, sob.nama_objek
                        from admisecsgp_mstobj sob
                    group by sob.objek_id, sob.nama_objek
                ) eo ON eo.objek_id=td.admisecsgp_mstobj_objek_id
                JOIN (
                    select sev.event_id, sev.event_name, sob.kategori_name
                        from admisecsgp_mstevent sev
                        inner join admisecsgp_mstkobj sob on sob.kategori_id=sev.admisecsgp_mstkobj_kategori_id
                    group by sev.event_id, sev.event_name, sob.kategori_name
                ) eok ON eok.event_id=td.admisecsgp_mstevent_event_id
                JOIN (
                    select sck.checkpoint_id, sck.check_name, szo.zone_name
                        from admisecsgp_mstckp sck
                        inner join admisecsgp_mstzone szo on szo.zone_id=sck.admisecsgp_mstzone_zone_id
                    group by sck.checkpoint_id, sck.check_name, szo.zone_name
                ) cz ON cz.checkpoint_id=th.admisecsgp_mstckp_checkpoint_id
            WHERE th.admisecsgp_mstusr_npk='$p_npk' AND th.admisecsgp_mstshift_shift_id='$p_shift_id' AND th.date_patroli='$p_tgl_patroli' AND th.type_patrol='$p_type_patrol'
        ";

        $res = DB::connection('sqlsrv')->select($q);

        // dd(count($res));

        if(count($res) > 0)
        {
            return $res;
        }
        else
        {
            return '01';
        }
    }

    public static function userGa($plant_id)
    {
        $q = "SELECT ug.email, ug.type
                FROM admisecsgp_mstusr_ga ug
            WHERE ug.admisecsgp_mstplant_plant_id='$plant_id'
        ";

        $res = DB::connection('sqlsrv')->select($q);

        if(count($res) > 0)
        {
            return $res;
        }
        else
        {
            return '01';
        }
    }

    private static function generateToken($npk)
    {
        $static_str='AL';
        $currenttimeseconds = date("mdY_His");
        $token_id=$static_str.$npk.$currenttimeseconds;
        return  join('-', str_split(md5($token_id), 7));
    }

    private static function uploadMultiple($files, $title)
    {
        if($files == null) return '01';

        $images = [];
        foreach ($files as $image) {
            $rand_number = rand ( 10000 , 99999 );
            // $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $fileName = $title.'_'.date('YmdHis').'_'.$rand_number.'.'.$image->getClientOriginalExtension();

            // $image_path =  $image->storeAs('images_temuan', $fileName, 'public');
            // array_push($images, $image_path);

            $image->move(public_path('assets/temuan'), $fileName);  
            $images[] = array(
                'fileName' => $fileName
            );
        }

        if(count($images) == 0) return '01';
        
        return $images;
    }

}