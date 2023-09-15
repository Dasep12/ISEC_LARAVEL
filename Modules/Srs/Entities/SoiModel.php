<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\RoleModel;

use AuthHelper;

class SoiModel extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\SoiModelFactory::new();
    }

    public static function area()
    {
        $user_npk = AuthHelper::user_npk();
        $user_wilayah = AuthHelper::user_wilayah();

        $q = "SELECT id, title 
                    FROM dbo.admiseciso_area_sub 
                WHERE area_categ_id=? AND status=?";

        $tes = AuthHelper::is_author('ALLAREA');

        if(AuthHelper::is_author('ALLAREA'))
        {
            $q .= " AND wil_id='$user_wilayah'";
        }

        if(AuthHelper::is_section_head())
        {
            $q .= " AND id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
            INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
            INNER JOIN dbo.admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
            WHERE aau.npk=$user_npk)";
        }

        $q .= " ORDER BY title ASC";

        $res = DB::connection('srsbi')->select($q, [1,1]);

        return $res;
    }

    private static $tableName = 'admisecsoi_transaction';
    private static $columnOrder = array(null, 'asu.title', 'a.year', 'a.month', 'a.people', 'a.system', 'a.device', 'a.network', null);
    private static $columnSearch = array('asu.title', 'a.year', 'a.note');
    private static $order = array('a.year' => 'desc', 'a.month' => 'desc');

    private static function getDataTable($req)
    {
        $areaFilter = $req->input('areafilter');
        $yearFilter = $req->input('yearfilter');
        $monthFilter = $req->input('monthfilter');
        $datefilter = $req->input('datefilter');
        $searchFilter = $req->input('search.value');
        $dir = $req->input('order.0.dir');
        $npk = AuthHelper::user_npk();

        $q = DB::connection('srsbi')->table(self::$tableName.' AS a')->select('a.id', 'asu.title as area', 'a.year', 'a.month', 'a.people', 'a.system', 'a.device', 'a.network', 'a.status');
        $q->join('admiseciso_area_sub as asu', 'asu.id', '=', 'a.area_id');
        $q->where('a.disable',0);

        // if(AuthHelper::is_section_head())
        // {
        //     $q->where(raw('a.area_id IN (SELECT aas.id
        //         FROM isecurity.dbo.admisec_area_users aau 
        //         INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
        //         INNER JOIN dbo.admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
        //     WHERE aau.npk='.$npk.')'));
        // }
        // if(AuthHelper::is_author())
        // {
        //     $q->where('a.created_by', $npk);
        // }
        
        // AREA
        if($areaFilter) $q->where('a.area_id','=',$areaFilter);
        // YEAR
        if($yearFilter) $q->whereRaw("a.year = {$yearFilter}");
        // MONTH
        if($monthFilter) $q->whereRaw("a.month = {$monthFilter}");
        // DATE RANGE
        if($date_filter = str_replace('- ', ';', $datefilter))
        {
            $start_date = date('Y-m-d H:i', strtotime(explode(';', $date_filter)[0]));
            $end_date = date('Y-m-d H:i', strtotime(explode(';', $date_filter)[1]));
            $q->whereRaw("a.event_date BETWEEN '".$start_date."'AND '".$end_date."'");
        }

        if($searchFilter)
        {
            $searchColumn = '';
            foreach (self::$columnSearch as $key => $val) {
                if($key > 0) $searchColumn .= 'or ';
                $searchColumn .="{$val} like '%$searchFilter%'";
            }
            $q->whereRaw($searchColumn);
            
            // foreach (self::$columnSearch as $key => $cse) {
            //     // $q1->orderBy($order_val,$dir_val);
            //     $q->orderBy($cse, 'desc');
            // }
        }

        return $q;
    }
   
    public static function listTable($req)
    {
        $npk = AuthHelper::user_npk();

        $totalFilteredRecord = $totalDataRecord = $draw_val ="";

        $columnsList = array_values(self::$columnOrder);

        $limit_val = $req->input('length');
        $start_val = $req->input('start');
        $dir = $req->input('order.0.dir');

        $getData = self::getDataTable($req);
        $totalDataRecord = $getData->count();

        $qd = self::getDataTable($req);
        $qd->offset($start_val);
        $qd->limit($limit_val);
        if($order = $req->input('order.0.column'))
        {
            $order_val = $columnsList[$order];
            $qd->orderBy($order_val,$dir);
        }
        else
        {
            foreach(self::$order as $ordKey => $ord) {
                $qd->orderBy($ordKey, $ord);
            }
        }
        $resultData = $qd->get();

        $totalFilteredRecord = $totalDataRecord;
         
        $data_val = array();
        if(!empty($resultData))
        {
            $access_modul = RoleModel::access_modul($npk, 'SRSSOI')[0];
            // dd($access_modul);

            $no = $start_val;
            foreach($resultData as $key => $field)
            {
                $no++;
                $row = array();
                $month = date("F", mktime(0, 0, 0, $field->month, 10));
                $row[] = $no;
                $row[] = $field->area;
                $row[] = $field->year;
                $row[] = $month;
                $row[] = $field->people;
                $row[] = $field->system;
                $row[] = $field->device;
                $row[] = $field->network;
                $edt_btn = AuthHelper::is_super_admin() ? '<a class="btn btn-sm btn-info"href="'. url('srs/soi/edit/'.$field->id) . '">
                            <i class="fa fa-edit"></i>
                        </a> ': '';
                $del_btn = AuthHelper::is_super_admin() || (isset($access_modul->dlt) && $access_modul->dlt == 1) ? '<button data-id="'. $field->id . '"data-title="'. $field->area . '"class="btn btn-sm btn-danger"data-toggle="modal"data-target="#deleteModal">
                            <i class="fa fa-trash"></i>
                        </button> ': '';
                $appr_btn = AuthHelper::is_super_admin() || (isset($access_modul->apr) && $access_modul->apr == 1) ? $field->status == 1 ? '<button class="btn btn-sm btn-success"title="Approved">
                            <i class="fa fa-check"></i>
                        </button> ': '<button data-id="'. $field->id . '"data-title="'.$field->area.' - '.$field->month.' - '.$field->year.'"class="btn btn-sm btn-success"data-toggle="modal"data-target="#approveModal">
                            Approve
                        </button> ': '';
                $row[] = $appr_btn.$edt_btn . '<button data-id="'. $field->id . '"class="btn btn-sm btn-primary"data-toggle="modal"data-target="#detailModal">
                            Detail
                        </button> '. $del_btn;

                $data_val[] = $row;
            }
        }

        $draw_val = $req->input('draw');
        $get_json_data = array(
           "draw"           => intval($draw_val),
           "recordsTotal"   => intval($totalDataRecord),
           "recordsFiltered"=> intval($totalFilteredRecord),
           "data"           => $data_val
        );

        return $get_json_data;
    }

    public static function edit($id)
    {
        $q = DB::connection('srsbi')->select("SELECT a.id, a.area_id, a.year, a.month, a.knowlage, a.attitude, a.skill, a.people, a.asms_value, a.perform_gt, a.system, a.device, a.network, ars.title area, a.note
                    FROM admisecsoi_transaction as a
                    INNER JOIN admiseciso_area_sub as ars ON ars.id=a.area_id
                WHERE a.id={$id} AND a.disable=0
            ");

        return $q;
    }

    public static function getPerformanceGt($req)
    {
        $area = $req->input('area');
        $year = $req->input('year');
        $month = $req->input('month');

        $q = DB::connection('srsbi')->select("SELECT count(1) total_ckp_p ,count(tra.total_ckp_trans) total_tra, (count(tra.total_ckp_trans) * 100 / count(1)) persentase 
                FROM isecurity.dbo.admisecsgp_trans_zona_patroli szn 
                INNER JOIN isecurity.dbo.admisecsgp_trans_jadwal_patroli atjp ON atjp.date_patroli=szn.date_patroli 
                    AND atjp.admisecsgp_mstplant_plant_id=szn.admisecsgp_mstplant_plant_id 
                    AND atjp.admisecsgp_mstshift_shift_id=szn.admisecsgp_mstshift_shift_id 
                INNER JOIN isecurity.dbo.admisecsgp_mstckp sckp on sckp.admisecsgp_mstzone_zone_id=szn.admisecsgp_mstzone_zone_id
                LEFT JOIN (
                    select count(ath.trans_header_id) total_ckp_trans, ath.date_patroli
                            ,ath.admisecsgp_mstshift_shift_id
                            ,ath.admisecsgp_mstckp_checkpoint_id
                        from isecurity.dbo.admisecsgp_trans_headers ath 
                        where ath.type_patrol=0 and ath.status=1 
                    group by ath.date_patroli, ath.admisecsgp_mstusr_npk
                        ,ath.admisecsgp_mstshift_shift_id
                        ,ath.admisecsgp_mstckp_checkpoint_id
                ) tra ON tra.date_patroli=szn.date_patroli and tra.admisecsgp_mstshift_shift_id=szn.admisecsgp_mstshift_shift_id
                    AND tra.admisecsgp_mstckp_checkpoint_id=sckp.checkpoint_id
            WHERE year(szn.date_patroli)='$year' AND month(szn.date_patroli)='$month' AND szn.admisecsgp_mstplant_plant_id in (select plant_id from dbo.admisec_area_join_plant where area_id='$area')
                AND szn.status=1 AND szn.status_zona=1 AND sckp.status=1 AND sckp.status=1
            GROUP BY szn.date_patroli ,szn.admisecsgp_mstshift_shift_id ,atjp.admisecsgp_mstusr_npk
            ORDER BY szn.date_patroli ASC
        ");

        return $q;
    }

    public static function detail($req)
    {
        $id = $req->input('id');

        $q = DB::connection('srsbi')->select("
                SELECT a.id, a.year, a.month, a.knowlage, a.attitude, a.skill, a.people, a.asms_value, a.perform_gt, a.system, a.device, a.network, ars.title area, a.note
                    FROM admisecsoi_transaction a
                    INNER JOIN admiseciso_area_sub ars ON ars.id=a.area_id
                WHERE a.id='$id'
            ");

        return $q;
    }

    public static function saveData($req)
    {
        $npk = AuthHelper::user_npk();
        $area = $req->input('area');
        $year = $req->input('year');
        $month = $req->input('month');
        $knowlage = $req->input('knowlage');
        $attitude = $req->input('attitude');
        $skill = $req->input('skill');
        $people = $req->input('people');
        $asms = $req->input('asms');
        $guardtour = $req->input('guardtour');
        $system = $req->input('system');
        $device = $req->input('device');
        $network = $req->input('network');
        $note = htmlentities($req->input('note', true), ENT_QUOTES, 'UTF-8');

        $q = "INSERT INTO admisecsoi_transaction (area_id, year, month, knowlage, attitude, skill, people, asms_value, perform_gt, system, device, network, note, created_by, created_on) VALUES('$area', '$year', '$month', $knowlage, $attitude, $skill, $people, $asms, $guardtour, $system, $device, '$network', '$note', $npk, CURRENT_TIMESTAMP)";

        // dd($q);

        $res = DB::connection('srsbi')->insert($q);
        
        if($res)
        {
            return '00';
        }
        else
        {
            return '02';
        }
    }

    public static function updateData($req)
    {
        $npk = AuthHelper::user_npk();
        $id = $req->input('id');
        $area = $req->input('area');
        $year = $req->input('year');
        $month = $req->input('month');
        $knowlage = $req->input('knowlage');
        $attitude = $req->input('attitude');
        $skill = $req->input('skill');
        $people = $req->input('people');
        $asms = $req->input('asms');
        $guardtour = $req->input('guardtour');
        $system = $req->input('system');
        $device = $req->input('device');
        $network = $req->input('network');
        $note = htmlentities($req->input('note', true), ENT_QUOTES, 'UTF-8');
        $curr_date = date('Y-m-d H:i:s');

        // dd($_POST);

        $res = DB::connection('srsbi')->update("UPDATE admisecsoi_transaction 
                SET area_id=$area, year='$year', month='$month', knowlage='$knowlage', attitude='$attitude', skill='$skill', people='$people', asms_value='$asms', perform_gt='$guardtour', system='$system', device='$device', network='$network', note='$note', updated_on='$curr_date', updated_by='$npk'
                WHERE id={$id}
            ");

        if($res)
        {
            return '00';
        }
        else
        {
            return '02';
        }
    }

    public static function approveData($req)
    {
        $role = AuthHelper::user_role();
        $sess_npk = AuthHelper::user_npk();

        $id = $req->input('id');
        $curr_date = date('Y-m-d H:i:s');

        $res = DB::connection('srsbi')->update("UPDATE admisecsoi_transaction SET status=1, approved_by='$sess_npk', approved_on='$curr_date' WHERE id='$id'
        ");

        if($res)
        {
            return '00';
        }
        else
        {
            return '02';
        }
    }

    public static function deleteData($req)
    {
        $role = AuthHelper::user_role();
        $sess_npk = AuthHelper::user_npk();

        $id = $req->input('id');
        $curr_date = date('Y-m-d H:i:s');

        $res = DB::connection('srsbi')->update("UPDATE admisecsoi_transaction SET disable=1, updated_by='$sess_npk', updated_on='$curr_date' WHERE id='$id'");

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