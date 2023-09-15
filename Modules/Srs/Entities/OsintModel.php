<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\RoleModel;

use AuthHelper;

class OsintModel extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\OsintModelFactory::new();
    }

    public static function getCategory($headerId)
    {
        $q = DB::connection('srsbi')->table('admisecosint_sub_header_data as shd')
            ->select('shd.sub_id', 'shd.name', 'shd.level_id', 'arl.level')
            ->leftJoin('admisecosint_risk_level as arl','arl.id','=','shd.level_id')
            ->where(['shd.header_data_id'=> $headerId,"shd.status"=> 1]);

        $res = $q->get();

        return collect($res)->map(function($x){ return (array) $x; })->toArray();
    }

    public static function getDataWhere($table, $where)
    {
        return DB::connection('srsbi')->table($table)->where($where)->get();
    }

    public static function getPlant()
    {
        return DB::connection('srsbi')->select("SELECT ars.id , ars.title as plant FROM admiseciso_area_sub ars WHERE area_categ_id = 1 AND status=1");
    }

    public static function levelVurne($id)
    {
        return DB::connection('srsbi')->select("SELECT ashd.sub_id  , arl.[level] , arl.id level_id , arl.description  , ashd.name  FROM admisecosint_sub_header_data ashd 
        left join admisecosint_risk_level arl  on arl.id  = ashd.level_id 
        where ashd.header_data_id  = $id");
    }
    
    private static $tableName = 'admisecosint_transaction';
    private static $columnOrder = array(null, 't.activity_name','asu.title','ashd.name','ashd1.name', 'sng.name', 't.date', 't.total_level', null);
    private static $columnSearch = array('t.activity_name', 'asu.title', 'ashd.name', 'ashd2.name', 'asu.title', 'sng.name');
    private static $order = array('t.date'=> 'desc');

    private static function getDataTable($req)
    {
        $npk = AuthHelper::user_npk();
        $areaFilter = $req->input('areafilter');
        $yearFilter = $req->input('yearfilter');
        $datefilter = $req->input('datefilter');
        $searchFilter = $req->input('search.value');
        $dir = $req->input('order.0.dir');

        $q = DB::connection('srsbi')->table(self::$tableName.' AS t')->select('t.id', 't.activity_name as act', 'asu.title as plant','ashd.name as media','ashd1.name as sub_media', 'ashd2.name as jenis_media', 'ashd3.name as risk', DB::raw('CAST(t.date as DATE) as event_date') , 't.impact_level_id', 't.total_level', 'sng.name as sentiment', 't.status');
        $q->join('admiseciso_area_sub as asu', 'asu.id','=','t.plant_id');
        $q->join('admisecosint_sub_header_data as ashd', 'ashd.sub_id', '=', 't.media_id');
        $q->leftJoin('admisecosint_sub2_header_data as ashd1', 'ashd1.id', '=', 't.sub1_media_id');
        $q->leftJoin('admisecosint_sub1_header_data as ashd2', 'ashd2.id', '=', 't.sub_media_id');
        $q->leftJoin('admisecosint_sub_header_data as ashd3', 'ashd3.sub_id', '=', 't.risk_id');
        $q->leftJoin('admisecosint_sub_header_data as sng', 'sng.sub_id', '=', 't.hatespeech_type_id');

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
        if($yearFilter) $q->whereRaw("year(t.date) = {$yearFilter}");
        // DATE RANGE
        if($date_filter = str_replace('- ', ';', $datefilter))
        {
            $start_date = date('Y-m-d H:i', strtotime(explode(';', $date_filter)[0]));
            $end_date = date('Y-m-d H:i', strtotime(explode(';', $date_filter)[1]));
            $q->whereRaw("t.date BETWEEN '".$start_date."'AND '".$end_date."'");
        }

        if($searchFilter)
        {
            $searchColumn = '';
            foreach (self::$columnSearch as $key => $val) {
                if($key > 0) $searchColumn .= 'or ';
                $searchColumn .="{$val} like '%$searchFilter%'";
            }
            $q->whereRaw($searchColumn);
            
            // foreach (self::$columnSearch as $key => $val) {
            //     $q->orderBy($val,$dir_val);
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
            $access_modul = RoleModel::access_modul($npk, 'SRSISO')[0];
            // dd($access_modul);

            $no = $start_val;
            foreach($resultData as $key => $field)
            {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->act;
                $row[] = $field->plant;
                $row[] = $field->media;
                $row[] = $field->jenis_media;
                $row[] = $field->sentiment;
                $row[] = date('d F Y ', strtotime($field->event_date));
                $row[] = $field->total_level;
                $edt_btn = AuthHelper::is_super_admin() ? '<a class="btn btn-sm btn-info"href="'. url('srs/osint_source/edit?id='. $field->id) . '">
                            <i class="fa fa-edit"></i>
                        </a> ': '';
                $del_btn = AuthHelper::is_super_admin() || (isset($access_modul->dlt) && $access_modul->dlt == 1) ? '<button data-id="'. $field->id . '"data-title="'. $field->act . '"class="btn btn-sm btn-danger"data-toggle="modal"data-target="#deleteModal">
                            <i class="fa fa-trash"></i>
                        </button> ': '';
                $appr_btn = AuthHelper::is_super_admin() || (isset($access_modul->apr) && $access_modul->apr == 1) ? $field->status == 1 ? '<button class="btn btn-sm btn-success"title="Approved">
                            <i class="fa fa-check"></i>
                        </button> ': '<button data-id="'. $field->id . '"data-title="'. $field->risk . '"class="btn btn-sm btn-success"data-toggle="modal"data-target="#approveModal">
                            Approve
                        </button> ': '';
                $row[] = $edt_btn . '<button data-id="'. $field->id . '"class="btn btn-sm btn-primary"data-toggle="modal"data-target="#detailModal">
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
    
    public static function getCategorySub1($req, $id='')
    {
        $subId  = $id;
        
        if($req->isMethod('post')) 
        {
            $subId  = $req->input("id");
        }

        $q = DB::connection('srsbi')->table('admisecosint_sub1_header_data as shd1')->select('shd1.id', 'shd1.name', 'shd1.level_id', 'arl.level');
        $q->leftJoin('admisecosint_risk_level as arl','arl.id', '=', 'shd1.level_id');
        $q->where(['shd1.sub_header_data' => $subId, "shd1.status" => 1]);
        $query = $q->get();

        return $query;
    }

    public static function saveData($req)
    {
        $event_date = $req->input('event_date');
        $plant = $req->input('plant');
        $subArea = $req->input('area');
        $subArea1 = $req->input('subArea1');
        $subArea2 = $req->input('subArea2');
        $issueTarget = $req->input('issueTarget');
        $subIssueTarget = $req->input('subIssueTarget');
        $subIssueTarget1 = $req->input('subIssueTarget1');
        $subIssueTarget2 = $req->input('subIssueTarget2');
        $riskSource = $req->input('riskSource');
        $subriskSource = $req->input('subriskSource');
        $subriskSource1 = $req->input('subriskSource1');
        $riskTreat = $req->input('riskTreat');
        $categoryLevel = $req->input('category_level');
        $activity_name = $req->input('activity_name');
        $vulne = $req->input('vulne');
        $vulneLevel = $req->input('vulneLevel');
        $plant_employee = $req->input('employe_plant');
        $url1 = $req->input('url1');
        $url2 = $req->input('url2');

        // NEGATIVE SENTIMENT
        $hatespeech = $req->input('hatespeech');
        $riskLevel = explode(":", $hatespeech)[1];
        $hatespeech = explode(":", $hatespeech)[0];

        $mediaIssue = $req->input('mediaIssue');
        // $mediaIssueLevel = explode(":", $mediaIssue)[1];
        // $mediaIssue = explode(":", $mediaIssue)[0];
        $SubmediaIssue = $req->input('SubmediaIssue');

        $regional = $req->input('regional');
        $regional = explode(":", $regional)[0];

        $legalitas = $req->input('legalitas');
        $legalitasSub1 = $req->input('legalitas_sub1');
        $legalitasSub1 = explode(":", $legalitasSub1)[0];

        $format = $req->input('format');
        $format = explode(":", $format)[0];

        $sdmSector = $req->input('sdm');
        $sdmSector = explode(":", $sdmSector)[0];
        $reput = $req->input('reput');
        $reput = explode(":", $reput)[0];
        $impactLevel = max($sdmSector, $reput);

        $totalLevel = $req->input('total_level');

        $desc = addslashes($req->input('description'));
        $desc = preg_replace("/'/", "\&#39;", $desc);

        $sess_npk = AuthHelper::user_npk();
        $curr_date = date('Y-m-d H:i:s');

        $q1 = "INSERT INTO admisecosint_transaction(
            plant_id ,
            area_id ,
            sub_area1_id ,
            sub_area2_id ,
            target_issue_id, 
            sub_target_issue1_id, 
            sub_target_issue2_id , 
            sub_target_issue3_id ,
            risk_source,
            sub_risk_source,
            sub_risk1_source ,
            media_id,
            sub_media_id ,
            risk_id, 
            created_at ,
            status,
            created_by,
            date,
            sdm_sector_level_id,
            reputasi_level_id ,
            description ,
            activity_name ,
            impact_level_id ,
            employe_plant,
            url1,
            url2,
            regional_id,
            hatespeech_type_id,
            legalitas_id,
            legalitas_sub1_id,
            format_id,
            risk_level_id,
            total_level
            ) 
            VALUES (
                NULLIF('$plant', '') ,
                NULLIF('$subArea', ''),
                NULLIF('$subArea1', '') ,
                NULLIF('$subArea2', '') ,
                NULLIF('$issueTarget', ''), 
                NULLIF('$subIssueTarget', '') ,
                NULLIF('$subIssueTarget1', '') ,
                NULLIF('$subIssueTarget2', '') ,
                NULLIF('$riskSource', '') ,
                NULLIF('$subriskSource', '') ,
                NULLIF('$subriskSource1', '') ,
                NULLIF('$mediaIssue', '') ,
                NULLIF('$SubmediaIssue', '') ,
                NULLIF('$riskTreat', '') ,
                '$curr_date' ,
                1 ,
                '$sess_npk' ,
                '$event_date' ,
                '$sdmSector',
                '$reput' ,
                '$desc' ,
                '$activity_name' ,
                '$impactLevel' ,
                NULLIF('$plant_employee', ''),
                NULLIF('$url1', ''),
                NULLIF('$url2', ''),
                '$regional',
                '$hatespeech',
                '$legalitas',
                '$legalitasSub1',
                '$format',
                '$riskLevel',
                '$totalLevel'
            )";

        // dd($req->file('attach'));

        DB::connection('srsbi')->beginTransaction();

        try {
            $qTrans = DB::connection('srsbi')->insert($q1);
            $transId = DB::connection('srsbi')->getPdo()->lastInsertId();

            if ($qTrans) {
                if (isset($_FILES['attach']) && $_FILES['attach']['name'][0] !== '') {
                    $upload = self::uploadMultipleFile($req->file('attach'), $curr_date);
                    
                    if (empty($upload) || $upload == '01') {
                        return '01';
                    }

                    $attach_file = $upload;

                    $field_file = 1;
                    $column_file_arr = array();
                    $field_file_arr = array();
                    $field_file_column = array();
                    foreach ($upload as $key => $ifl) {
                        $column_file_arr[] = 'attach_file_' . $field_file;
                        $field_file_arr[] = "'" . $ifl['file_name'] . "'";
                        $field_file_column[] = "( {$transId}, '" . $ifl['file_name'] . "', '{$curr_date}', '1')";
                        $field_file++;
                    }

                    $column_file_implode = implode(", ", $column_file_arr);
                    $field_file_implode = implode(", ", $field_file_column);
                } else {
                    $attach_file = '';
                }

                if ($attach_file !== '' && count($attach_file) > 0) 
                {
                    $q_file = "INSERT INTO admisecosint_transaction_file(trans_id, file_name, created_at,status) VALUES " . $field_file_implode;

                    $qTrans = DB::connection('srsbi')->insert($q_file);

                    if ($qTrans) 
                    {
                        DB::connection('srsbi')->commit();
                        return '00';
                    } else {
                        DB::connection('srsbi')->rollback();
                        return '03';
                    }
                } else {
                    DB::connection('srsbi')->commit();
                    return '00';
                }
            } else {
                return '02';
            }
        } catch (\Exception $e) {
            DB::connection('srsbi')->rollback();
            return '01';
        }
    }

    public static function edit($req)
    {
        $id = $req->input("id");

        $q = DB::connection('srsbi')->table(self::$tableName.' AS tr')->select("tr.id","tr.activity_name","tr.date","tr.area_id","tr.sub_area2_id","tr.sub_target_issue1_id","tr.target_issue_id","tr.sub_target_issue3_id","tr.sub_risk_source","tr.risk_source","tr.sub_risk1_source","tr.employe_plant","tr.sub_target_issue2_id","tr.sub_area1_id","tr.plant_id","tr.description","tr.sub_media_id","tr.url1","tr.url2","asu.title as plant","lev.level as sdm_level","lev2.level as reputasi_level","tr.created_by","ashd.name as media","tr.media_id","tr.media_level_id","tr.sub1_media_id","melvl.level as media_level","ashd1.name as jenis_media","tr.regional_id","tr.regional_level_id","tr.legalitas_id","tr.legalitas_sub1_id","tr.legalitas_level_id","tr.format_id","tr.format_level_id","tr.sdm_sector_level_id","tr.reputasi_level_id","tr.risk_level_id","rlvl.level as risk_level","tr.impact_level_id","implvl.level as impact_level","tr.hatespeech_type_id","tr.category_level","tr.total_level");
        $q->leftJoin('admiseciso_area_sub as asu', 'tr.plant_id','=','asu.id');
        $q->leftJoin('admisecosint_sub_header_data as suh', 'tr.sdm_sector_level_id','=','suh.sub_id');
        $q->leftJoin('admisecosint_risk_level as melvl', 'tr.media_level_id','=','melvl.id');
        $q->leftJoin('admisecosint_risk_level as lev', 'suh.level_id','=','lev.id');
        $q->leftJoin('admisecosint_risk_level as rlvl', 'rlvl.id','=','tr.risk_level_id');
        $q->leftJoin('admisecosint_sub_header_data as suh2', 'tr.reputasi_level_id','=','suh2.sub_id');
        $q->leftJoin('admisecosint_risk_level as lev2', 'suh2.level_id','=','lev2.id');
        $q->leftJoin('admisecosint_risk_level as implvl', 'implvl.id', '=', DB::raw('(select level_id from admisecosint_sub_header_data where sub_id=tr.impact_level_id)'));
        $q->leftJoin('admisecosint_sub_header_data as ashd', 'ashd.sub_id ','=','tr.media_id');
        $q->leftJoin('admisecosint_sub2_header_data as ashd1', 'ashd1.id ','=','tr.sub1_media_id');
        $q->where('tr.id', $id);
        
        return $q->first();
    }

    public static function updateData($req)
    {
        $sess_npk = AuthHelper::user_npk();
        $curr_date = date('Y-m-d H:i:s');
        $id = $req->input('id', true);
        $event_date = $req->input('event_date', true);
        $plant = $req->input('plant', true);
        $subArea = $req->input('area', true);
        $subArea1 = $req->input('subArea1', true);
        $subArea2 = $req->input('subArea2', true);
        $issueTarget = $req->input('issueTarget', true);
        $subIssueTarget = $req->input('subIssueTarget', true);
        $subIssueTarget1 = $req->input('subIssueTarget1', true);
        $subIssueTarget2 = $req->input('subIssueTarget2', true);
        $riskSource = $req->input('riskSource', true);
        $subriskSource = $req->input('subriskSource', true);
        $subriskSource1 = $req->input('subriskSource1', true);

        $riskTreat = $req->input('riskTreat', true);
        // $LevelriskTreat = $req->input('LevelriskTreat', true);
        $activity_name = $req->input('activity_name', true);
        $vulne = $req->input('vulne', true);
        $vulneLevel = $req->input('vulneLevel', true);
        $plant_employee = $req->input('employe_plant', true);
        $desc = addslashes($req->input('description', true));
        $desc = preg_replace("/'/", "\&#39;", $desc);
        $url1 = $req->input('url1', true);
        $url2 = $req->input('url2', true);

        $mediaIssue = $req->input('mediaIssue', true);
        // $mediaIssueLevel = explode(":", $mediaIssue)[1];
        // $mediaIssue = explode(":", $mediaIssue)[0];
        $SubmediaIssue = $req->input('SubmediaIssue', true);
        $SubmediaIssue1 = $req->input('SubmediaIssue1', true);
        $SubmediaIssue2 = $req->input('SubmediaIssue2', true);

        // NEGATIVE SENTIMENT
        $hatespeech = $req->input('hatespeech', true);
        $riskLevel = explode(":", $hatespeech)[1];
        $hatespeech = explode(":", $hatespeech)[0];

        $sdmSector = $req->input('sdm', true);
        $sdmSector = explode(":", $sdmSector)[0];
        $reput = $req->input('reput', true);
        $reput = explode(":", $reput)[0];
        $impactLevel = max($sdmSector, $reput);

        $regional = $req->input('regional', true);
        $regional = explode(":", $regional)[0];

        $legalitas = $req->input('legalitas', true);
        $legalitasSub1 = $req->input('legalitas_sub1', true);
        $legalitasSub1 = explode(":", $legalitasSub1)[0];

        $format = $req->input('format', true);
        $format = explode(":", $format)[0];

        $totalLevel = $req->input('total_level', true);

        $data = [
            'plant_id' => empty($plant) ? NULL : $plant,
            'area_id' => empty($subArea) ? NULL : $subArea,
            'sub_area1_id' => empty($subArea1) ? NULL : $subArea1,
            'sub_area2_id' => empty($subArea2) ? NULL : $subArea2,
            'target_issue_id' => empty($issueTarget) ? NULL : $issueTarget,
            'sub_target_issue1_id' =>  empty($subIssueTarget) ? NULL :  $subIssueTarget,
            'sub_target_issue2_id' => empty($subIssueTarget1) ? NULL : $subIssueTarget1,
            'sub_target_issue3_id' =>  empty($subIssueTarget2) ? NULL : $subIssueTarget2,
            'risk_source' => empty($riskSource) ? NULL : $riskSource,
            'sub_risk_source' => empty($subriskSource) ? NULL : $subriskSource,
            'sub_risk1_source' => empty($subriskSource1) ? NULL : $subriskSource1,
            'media_id' => empty($mediaIssue) ? NULL : $mediaIssue,
            'sub_media_id' => empty($SubmediaIssue) ? NULL : $SubmediaIssue,
            'sub1_media_id' => empty($SubmediaIssue1) ? NULL : $SubmediaIssue1,
            'sub2_media_id' => empty($SubmediaIssue2) ? NULL : $SubmediaIssue2,
            'risk_id' => empty($riskTreat) ? NULL : $riskTreat,
            'created_at' => $curr_date,
            'status' => 1,
            'created_by' => $sess_npk,
            'date' => $event_date,
            'sdm_sector_level_id' => empty($sdmSector) ? NULL :  $sdmSector,
            'reputasi_level_id' => empty($reput) ? NULL : $reput,
            'description' => empty($desc) ? NULL : $desc,
            'activity_name' => empty($activity_name) ? NULL  : $activity_name,
            'employe_plant' => empty($plant_employee) ? NULL  : $plant_employee,
            'url1' => empty($url1) ? NULL  : $url1,
            'url2' => empty($url2) ? NULL  : $url2,
            'regional_id' => $regional,
            'hatespeech_type_id' => $hatespeech,
            'legalitas_id' => $legalitas,
            'legalitas_sub1_id' => empty($legalitasSub1) ? NULL  : $legalitasSub1,
            'format_id' => $format,
            'impact_level_id' => $impactLevel,
            'risk_level_id' => $riskLevel,
            'total_level' => $totalLevel,
        ];

        // dd($data);

        // update data transaksi
        // $where = ['id' => $id];
        // $this->osidb->trans_begin();
        // $this->osidb->where($where);
        // $updateData = $this->osidb->update("admisecosint_transaction", $data);
        
        DB::connection('srsbi')->beginTransaction();

        try {
            $updateData = DB::connection('srsbi')->table('admisecosint_transaction')->where('id', $id)->update($data);

            if ($updateData) {
                if (isset($_FILES['attach']) && $_FILES['attach']['name'][0] !== '') {
                    // $upload = $this->upload_multiple($_FILES['attach'], $curr_date);
                    $upload = self::uploadMultipleFile($req->file('attach'), $curr_date);
                    
                    if (empty($upload) || $upload == '01') {
                        return '01';
                    }

                    $attach_file = $upload;

                    $field_file = 1;
                    $column_file_arr = array();
                    $field_file_arr = array();
                    $field_file_column = array();
                    foreach ($upload as $key => $ifl) {
                        $column_file_arr[] = 'attach_file_' . $field_file;
                        $field_file_arr[] = "'" . $ifl['file_name'] . "'";
                        $field_file_column[] = "( {$id}, '" . $ifl['file_name'] . "', '{$curr_date}', '1')";
                        $field_file++;
                    }

                    $column_file_implode = implode(", ", $column_file_arr);
                    $field_file_implode = implode(", ", $field_file_column);
                } else {
                    $attach_file = '';
                }

                if ($attach_file !== '' && count($attach_file) > 0) {
                    $q_file = "INSERT INTO admisecosint_transaction_file(trans_id, file_name, created_at,status) VALUES " . $field_file_implode;

                    $qTrans = DB::connection('srsbi')->insert($q_file);

                    if ($qTrans) {
                        DB::connection('srsbi')->commit();
                        return '00';
                    } else {
                        DB::connection('srsbi')->rollback();
                        return '03';
                    }
                } else {
                    DB::connection('srsbi')->commit();
                    return '00';
                }
            } else {
                DB::connection('srsbi')->rollback();
                return '02';
            }
        } catch (\Exception $e) {
            DB::connection('srsbi')->rollback();
            return '01';
        }
    }

    public static function deleteAttached($req)
    {
        $idFile = $req->input("fileId");
        $idTrans = $req->input("id");

        // $where = ['id' => $idFile];
        // $data = ['status' => 0];
        // $this->osidb->where($where);
        // $this->osidb->update("admisecosint_transaction_file", $data);

        $qTrans = DB::connection('srsbi')->update("UPDATE admisecosint_transaction_file SET status=0 WHERE id=$idFile");

        if ($qTrans) {
            return "00";
        } else {
            return '03';
        }
    }
    
    public static function deleteData($req)
    {
        $id = $req->input("id");

        $search = DB::connection('srsbi')->select("SELECT * FROM admisecosint_transaction_file WHERE trans_id = $id ");
        $search = collect($search);

        DB::connection('srsbi')->beginTransaction();

        if ($search->count() > 0) 
        {
            $deleteFile = DB::connection('srsbi')->delete("DELETE FROM admisecosint_transaction_file WHERE trans_id = $id ");

            if ($deleteFile) {
                $deleteRow = DB::connection('srsbi')->delete("DELETE FROM admisecosint_transaction WHERE id = $id ");

                if($deleteRow)
                {
                    DB::connection('srsbi')->commit();
                    return '00';
                }
                else
                {
                    DB::connection('srsbi')->rollback();
                    return '03';
                }
            } else {
                DB::connection('srsbi')->rollback();
                return '03';
            }
        } else {
            $deleteFile = DB::connection('srsbi')->delete("DELETE FROM admisecosint_transaction WHERE id = $id ");

            if ($deleteFile) 
            {
                DB::connection('srsbi')->commit();
                return '00';
            } else {
                DB::connection('srsbi')->rollback();
                return '03';
            }
        }
    }
    
    public static function search($req)
    {
        $keyword = $req->input('keyword');
        $key_array = explode(" ", $keyword);

        // SUBSTRING(chronology, 1, 200) 
        $q = "SELECT top 10 id, activity_name event_name ,[date] event_date ,SUBSTRING(description, 1, 300) chronology
                from admisecosint_transaction at2 
            where 
            ";
        foreach ($key_array as $key => $val) {
            if($key > 0) $q .= ' or ';
            $q .= "activity_name like '%$val%' ";
            $q .= ' or ';
            $q .= " description like '%$val%'";
        }

        $get = DB::connection('srsbi')->select($q);

        return $get;
    }

    public static function getDetail($req)
    {
        $id = $req->input("id");
        
        $res = DB::connection('srsbi')->table('admisecosint_transaction AS tr')
            ->select('tr.id','tr.activity_name','tr.date','asu.title as plant','lev.level as sdm_level','lev2.level as reputasi_level','tr.created_by','ashd.name as media','ashd1.name as jenis_media','url1','url2', 'trg.name as target_issue','rso.name as risk_source','rsos.name as risk_source_sub','ngs.name as negative_sentiment','rgn.name as regional_name','lgt.name as legalitas_name','lgts.name as legalitas_sub1_name','frm.name as format_name','implvl.level as impact_level', 'tr.risk_level', 'tr.description', 'tr.created_at')
            ->leftJoin('admiseciso_area_sub as asu', 'tr.plant_id', '=', 'asu.id')
            ->leftJoin('admisecosint_sub_header_data as suh', 'tr.sdm_sector_level_id','=','suh.sub_id')
            ->leftJoin('admisecosint_risk_level as lev', 'suh.level_id', '=', 'lev.id')
            ->leftJoin('admisecosint_sub_header_data as suh2', 'tr.reputasi_level_id', '=', 'suh2.sub_id')
            ->leftJoin('admisecosint_risk_level as lev2', 'suh2.level_id', '=','lev2.id')
            ->leftJoin('admisecosint_sub_header_data AS ashd', 'ashd.sub_id ', '=', 'tr.media_id')
            ->leftJoin('admisecosint_sub2_header_data AS ashd1', 'ashd1.id', '=','tr.sub1_media_id')
            ->leftJoin('admisecosint_sub_header_data AS trg', 'trg.sub_id', '=', 'tr.target_issue_id')
            ->leftJoin('admisecosint_sub_header_data AS rso', 'rso.sub_id ', '=', 'tr.risk_source')
            ->leftJoin('admisecosint_sub1_header_data AS rsos', 'rsos.id', '=', 'tr.sub_risk_source')
            ->leftJoin('admisecosint_sub_header_data AS ngs', 'ngs.sub_id', '=', 'tr.hatespeech_type_id')
            ->leftJoin('admisecosint_sub_header_data AS rgn', 'rgn.sub_id','=','tr.regional_id')
            ->leftJoin('admisecosint_sub_header_data AS lgt', 'lgt.sub_id','=','tr.legalitas_id')
            ->leftJoin('admisecosint_sub1_header_data AS lgts', 'lgts.id','=','tr.legalitas_sub1_id')
            ->leftJoin('admisecosint_sub_header_data AS frm', 'frm.sub_id','=','tr.format_id')
            ->leftJoin('admisecosint_risk_level AS implvl', 'implvl.id', '=',DB::connection('srsbi')->raw('(select level_id from admisecosint_sub_header_data where sub_id=tr.impact_level_id)'))
            ->where('tr.id', $id)
            ->first();

        return $res;
    }
    
    private static function uploadMultipleFile($files, $date)
    {
        if($files == null) return '01';

        $allowedfileExtension = ['pdf','jpg','jpeg','mp4','png','docx','xlsx'];
        $path = 'uploads/srsbi/osint';

        if(!is_dir($path))
        {
            mkdir($path, 0777);
        }

        $dataFiles = [];
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            
            if($check)
            {
                $rand_number = rand ( 10000 , 99999 );
                
                $fileName = 'srs_osi_'.preg_replace('/[^A-Za-z0-9]/', "", strtolower($date)).'_'.$rand_number.'.'.$file->getClientOriginalExtension();

                // $image_path =  $image->storeAs('images_temuan', $fileName, 'public');
                // array_push($images, $image_path);

                $file->move(public_path($path), $fileName);
                $dataFiles[] = array(
                    'file_name' => $fileName
                );
            }
        }

        if(count($dataFiles) == 0) return '01';
        
        return $dataFiles;
    }
}