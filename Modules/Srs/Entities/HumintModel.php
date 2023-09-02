<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\RoleModel;

use AuthHelper, FormHelper;

class HumintModel extends Model
{
    use HasFactory;
    
    protected $fillable = [];

    protected $connection = 'srsbi';
    protected $table = 'dbo.admiseciso_transaction';
    protected $isModule = 'SRSISO';
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\HumintModelFactory::new();
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

    public static function no_urut()
    {
        $q = "
            SELECT FORMAT(ISNULL(max(no_urut), 0) + 1, '000') no_urut
            FROM dbo.admiseciso_transaction
            WHERE month(event_date)=? and year(event_date)=?
        ";

        $res = DB::connection('srsbi')->select($q, [date('m'), date('Y')]);

        return $res;
    }

    public static function sub_area()
    {
        $q ="SELECT id, title FROM dbo.admiseciso_area_sub WHERE area_categ_id=? AND status=?";

        $res = DB::connection('srsbi')->select($q, ['6', 1]);

        return $res;
    }

    public static function subArea2($req, $categ_id='')
    {
        if($req->isMethod('post')) 
        {
            $categ_id = $req->input('idcateg');
        }
        else
        {
            $categ_id = $categ_id;
        }

        $q = "
                SELECT a.id, a.title, b.title title_cat
                    FROM admiseciso_area_sub a
                    INNER JOIN admiseciso_area_categ b ON b.id=a.area_categ_id
                WHERE a.area_categ_id=(select area_categtarget_id from admiseciso_area_sub where id=?) AND a.status=1
            ";

        $res = DB::connection('srsbi')->select($q, [$categ_id]);

        return $res;
    }

    public static function assest()
    {
        $q = "
                SELECT id, title, assets_categ_id
                    FROM dbo.admiseciso_assets_sub
                WHERE assets_categ_id=? AND status=? ORDER BY title ASC
            ";
        
        $res = DB::connection('srsbi')->select($q, [1, 1]);

        return $res;
    }

    public static function subAssets($req, $categ_id='')
    {
        if($req->isMethod('post')) 
        {
            $id = $req->input('idcateg');
        }
        else
        {
            $id = $categ_id;
        }

        $q = "
                SELECT a.id, a.title, b.title title_cat
                    FROM admiseciso_assets_sub a
                    INNER JOIN admiseciso_assets_categ b ON b.id=a.assets_categ_id
                WHERE a.assets_categ_id=(select assets_categtarget_id from admiseciso_assets_sub where id=?) AND a.status=1
            ";

        $res = DB::connection('srsbi')->select($q, [$id]);

        return $res;
    }

    public static function risk_source()
    {
        $q = "
                SELECT id, title 
                    FROM dbo.admiseciso_risksource_sub
                WHERE risksource_categ_id=? AND status=? ORDER BY title ASC
            ";
        
        $res = DB::connection('srsbi')->select($q, [1, 1]);

        return $res;
    }

    public static function subRiskSource($req, $categ_id='')
    {
        if($req->isMethod('post')) 
        {
            $id = $req->input('idcateg', true);
        }
        else
        {
            $id = $categ_id;
        }

        $q = "
        SELECT a.id, a.title, b.title title_cat
            FROM admiseciso_risksource_sub a
            INNER JOIN admiseciso_risksource_categ b ON b.id=a.risksource_categ_id
        WHERE a.risksource_categ_id=(select risksource_categtarget_id from admiseciso_risksource_sub where id='$id') AND a.status=1 ORDER BY a.title ASC
            ";

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    public static function risk()
    {
        $q = "
                SELECT a.id, a.title, c.id level_id, c.level
                    FROM dbo.admiseciso_risk_sub a
                    LEFT JOIN dbo.admiseciso_risk_level c ON c.id=a.level_id
                WHERE a.risk_categ_id=? AND a.status=? 
                ORDER BY a.title ASC
            ";
        
        $res = DB::connection('srsbi')->select($q, [1, 1]);

        return $res;
    }
    
    public static function subRisk($req, $categ_id='')
    {
        if($req->isMethod('post')) 
        {
            $id = $req->input('idcateg', true);
        }
        else
        {
            $id = $categ_id;
        }

        $q = "
                SELECT a.id, a.title, b.title title_cat
                    FROM admiseciso_risk_sub a
                    INNER JOIN admiseciso_risk_categ b ON b.id=a.risk_categ_id
                WHERE a.risk_categ_id=(select risk_categtarget_id from admiseciso_risk_sub where id=?) AND a.status=1 ORDER BY a.title ASC
            ";

        $res = DB::connection('srsbi')->select($q, [$id]);

        return $res;
    }

    public static function risk_level()
    {
        $q = "
                SELECT id, title, level FROM dbo.admiseciso_risk_level WHERE status=? ORDER BY level ASC
            ";
        
        $res = DB::connection('srsbi')->select($q, [1]);

        return $res;
    }

    public static function vurnability_level()
    {
        $q = "
                SELECT id, title, level, financial_desc, sdm_desc, operational_desc, reputation_desc
                FROM dbo.admiseciso_vurnability_level 
                WHERE status=? ORDER BY level ASC
            ";
        
        $res = DB::connection('srsbi')->select($q, [1]);

        return $res;
    }
    
    private static $t_trans_iso = 'admiseciso_transaction';
    private static $column_order = array(null, 'a.event_name', 'a.event_date', 'asu.title', 'ass.title', 'rss.title', 'ris.title', 'a.impact_level', null);
    private static $columnSearch = array('a.event_name', 'asu.title', 'ass.title', 'rss.title', 'ris.title');
    private static $order = array('a.event_date' => 'desc');

    private static function getDataTable($req)
    {
        $areaFilter = $req->input('areafilter');
        $yearFilter = $req->input('yearfilter');
        $datefilter = $req->input('datefilter');
        $searchFilter = $req->input('search.value');
        $dir_val = $req->input('order.0.dir');
        $npk = AuthHelper::user_npk();

        $q = DB::connection('srsbi')->table('dbo.admiseciso_transaction AS a')->select('a.id', 'a.event_name','a.event_date','a.impact_level','a.status','asu.title AS area','rss.title AS risk_source','ass.title AS assets','ris.title AS risk');
        $q->join('dbo.admiseciso_area_sub AS asu', 'asu.id', '=', 'a.area_id');
        $q->join('dbo.admiseciso_risksource_sub AS rss', 'rss.id', '=', 'a.risk_source_id');
        $q->join('dbo.admiseciso_assets_sub AS ass', 'ass.id', '=', 'a.assets_id');
        $q->join('dbo.admiseciso_risk_sub AS ris', 'ris.id', '=', 'a.risk_id');
        $q->where('a.disable','=',0);
        if(AuthHelper::is_section_head())
        {
            $q->where(raw('a.area_id IN (SELECT aas.id
                FROM isecurity.dbo.admisec_area_users aau 
                INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
                INNER JOIN dbo.admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
            WHERE aau.npk='.$npk.')'));
        }
        if(AuthHelper::is_author())
        {
            $q->where('a.created_by', $npk);
        }
        // AREA
        if($areaFilter) $q->where('a.area_id','=',$areaFilter);
        // YEAR
        if($yearFilter) $q->whereRaw("year(a.event_date) = {$yearFilter}");
        // DATE RANGE
        if($date_filter = str_replace(' - ', ';', $datefilter))
        {
            $start_date = date('Y-m-d H:i', strtotime(explode(';', $date_filter)[0]));
            $end_date = date('Y-m-d H:i', strtotime(explode(';', $date_filter)[1]));
            $q->whereRaw("a.event_date BETWEEN '".$start_date."' AND '".$end_date."'");
        }

        if($searchFilter)
        {
            $searchColumn = '';
            foreach (self::$columnSearch as $key => $val) {
                if($key > 0) $searchColumn .= ' or ';
                $searchColumn .= "{$val} like '%$searchFilter%' ";
            }
            $q->whereRaw($searchColumn);
            
            foreach (self::$columnSearch as $key => $val) {
                // $q1->orderBy($order_val,$dir_val);
                $q->orderBy($val,$dir_val);
            }
        }

        return $q;
    }
   
    public static function listTable($req)
    {
        $npk = AuthHelper::user_npk();

        $totalFilteredRecord = $totalDataRecord = $draw_val = "";

        $columns_list = array(
            0 => 'no',
            1 => "a.event_name",
            2 => "a.event_date",
            3 => "area",
            4 => "assets",
            5 => "risk_source",
            6 => "risk",
            7 => "impact_level",
            8 => 'action',
        );

        $limit_val = $req->input('length');
        $start_val = $req->input('start');
        $order_val = $columns_list[$req->input('order.0.column')];
        $dir_val = $req->input('order.0.dir');

        $getData = self::getDataTable($req);
        $totalDataRecord = $getData->count();

        $qd = self::getDataTable($req);
        $qd->offset($start_val);
        $qd->limit($limit_val);
        $qd->orderBy('a.event_date','desc');
        $resultData = $qd->get();

        $totalFilteredRecord = $totalDataRecord;
         
        $data_val = array();
        if(!empty($resultData))
        {
            $access_modul = RoleModel::access_modul($npk, 'SRSISO')[0];
            // dd($access_modul);

            $no = $start_val;
            foreach($resultData as $key => $item)
            {
                $no++;
                $postnestedData = array();
                $postnestedData[] = $no;
                $postnestedData[] = $item->event_name;
                $postnestedData[] = date('d F Y H:i', strtotime($item->event_date));
                $postnestedData[] = $item->area;
                $postnestedData[] = $item->assets;
                $postnestedData[] = $item->risk_source;
                $postnestedData[] = $item->risk;
                $postnestedData[] = $item->impact_level;

                $edtBtn = AuthHelper::is_super_admin() ? '<a class="btn btn-sm btn-info" href="'.url('srs/humint_source/edit/'.$item->id).'">
                        <i class="fa fa-edit"></i>
                </a> ' : '';
                $apprBtn = AuthHelper::is_super_admin() || (isset($access_modul->apr) && $access_modul->apr == 1) ? $item->status == 1 ? '<button class="btn btn-sm btn-success" title="Approved">
                        <i class="fa fa-check"></i>
                    </button> ' : '<button data-id="'.$item->id.'" data-title="'.$item->event_name.'" class="btn btn-sm btn-success" data-toggle="modal" data-target="#approveModal">
                        Approve
                    </button> ' : '';
                $delBtn = AuthHelper::is_super_admin() || (isset($access_modul->dlt) && $access_modul->dlt == 1) ? '<button data-id="'.$item->id.'" class="btn btn-sm btn-danger " data-toggle="modal" data-target="#deleteModal"> <i class="fa fa-trash"></i></button> ' : '';
                $postnestedData[] = $apprBtn.$edtBtn.'<button data-id="'.$item->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal">
                        Detail
                    </button> '.$delBtn;
                $data_val[] = $postnestedData;
            }
        }

        $draw_val = $req->input('draw');
        $get_json_data = array(
            "draw"            => intval($draw_val),
            "recordsTotal"    => intval($totalDataRecord),
            "recordsFiltered" => intval($totalFilteredRecord),
            "data"            => $data_val
        );

        return $get_json_data;
    }

    public static function saveData($req)
    {
        $tanggal = $req->input('tanggal', true);
        $event_name = $req->input('event_name', true);

        $area = $req->input('area', true);
        $sub_area1 = $req->input('sub_area1', true);
        $sub_area2 = $req->input('sub_area2', true);
        $sub_area3 = $req->input('sub_area3', true);

        $assets = $req->input('assets', true);
        $sub_assets1 = $req->input('sub_assets1', true);
        $sub_assets2 = $req->input('sub_assets2', true);

        $risk_source = $req->input('risk_source', true);
        $sub_risksource1 = $req->input('sub_risksource1', true);
        $sub_risksource2 = $req->input('sub_risksource2', true);

        $risk = explode(':', $req->input('risk', true))[0];
        $sub_risk1 = $req->input('sub_risk1', true);
        $sub_risk2 = $req->input('sub_risk2', true);
        $risk_level = $req->input('risk_level', true);

        $financial = $req->input('financial', true);
        $sdm = $req->input('sdm', true);
        $operational = $req->input('operational', true);
        $reputation = $req->input('reputation', true);
        $find_impact = array(explode(':', $financial)[0], explode(':', $sdm)[0], explode(':', $operational)[0], explode(':', $reputation)[0]);
        $impact = max($find_impact);
        $chronology = addslashes($req->input('chronology', true));
        $chronology = preg_replace("/'/", "\&#39;", $chronology);
        $reporter = $req->input('reporter', true);
        $sess_npk = AuthHelper::user_npk();
        $curr_date = date('Y-m-d H:i:s');
        
        $q_no_urut = "
            SELECT FORMAT(ISNULL(max(no_urut), 0) + 1, '000') no_urut
            FROM admiseciso_transaction
            WHERE month(event_date)=".date('m', strtotime($tanggal))." and year(event_date)=".date('Y', strtotime($tanggal))."
        ";
        
        $res_q_no_urut = DB::connection('srsbi')->select($q_no_urut);

        $no_urut = $res_q_no_urut[0]->no_urut;
        $no_ref = $no_urut.'/LK/EA/'.FormHelper::convertRomawi(date('m', strtotime($tanggal))).'/'.date('Y', strtotime($tanggal));

        $q = array();
        foreach ($area as $key => $are) {
            $q[$are] = "('$no_ref','$no_urut','$event_name', '$tanggal', '$are', NULLIF('$sub_area1', ''), NULLIF('$sub_area2', ''), NULLIF('$sub_area3', ''), '$assets', NULLIF('$sub_assets1', ''), NULLIF('$sub_assets2', ''), '$risk_source', NULLIF('$sub_risksource1', ''), NULLIF('$sub_risksource2', ''), '$risk', NULLIF('$sub_risk1', ''), NULLIF('$sub_risk2', ''), '$risk_level', '".explode(':', $financial)[1]."', '".explode(':', $sdm)[1]."', '".explode(':', $operational)[1]."', '".explode(':', $reputation)[1]."', '$impact', '$chronology', '$sess_npk', '$reporter'";
            if(isset($field_file_arr) && !empty($field_file_arr)) $q[$are] .= ",".$field_file_implode;
            $q[$are] .= ')'; 
        }

        $q_implode = implode (", ", $q);

        $column = "INSERT INTO admiseciso_transaction(no_reference, no_urut, event_name, event_date, area_id, area_sub1_id, area_sub2_id, area_sub3_id, assets_id, assets_sub1_id, assets_sub2_id, risk_source_id, risksource_sub1_id, risksource_sub2_id, risk_id, risk_sub1_id, risk_sub2_id, risk_level_id, financial_level, sdm_level, operational_level, reputation_level, impact_level, chronology, created_by, reporter";
        $column .= ") VALUES";

        DB::connection('srsbi')->beginTransaction();

        try {
            $qTrans = DB::connection('srsbi')->insert($column.$q_implode);
            $transId = DB::connection('srsbi')->getPdo()->lastInsertId();

            if($qTrans)
            {
                if($_FILES['attach']['name'][0] !== '')
                {
                    $upload = self::uploadMultipleFile($req->file('attach'), $tanggal);

                    if(empty($upload) || $upload == '01')
                    {
                        return '01';
                    }

                    $attach_file = $upload;

                    $field_file = 1;
                    $column_file_arr = array();
                    $field_file_arr = array();
                    $field_file_column = array();
                    foreach ($upload as $key => $ifl) {
                        $column_file_arr[] = 'attach_file_'.$field_file;
                        $field_file_arr[] = "'".$ifl['file_name']."'";
                        $field_file_column[] = "( {$transId}, '".$ifl['file_name']."', '{$curr_date}')";
                        $field_file++;
                    }
                    
                    $column_file_implode = implode (", ", $column_file_arr);
                    $field_file_implode = implode (", ", $field_file_column);
                }
                else
                {
                    $attach_file = '';
                }

                if($attach_file !== '' && count($attach_file) > 0)
                {
                    $qFile = "INSERT INTO admiseciso_trans_attach(trans_id, file_name, created_on) VALUES ".$field_file_implode;
                    // dd($qFile);

                    $resFile = DB::connection('srsbi')->insert($qFile);

                    if($resFile)
                    {
                        DB::connection('srsbi')->commit();
                        return '00';
                    }
                    else
                    {
                        DB::connection('srsbi')->rollback();
                        return '03';
                    }
                }
                else
                {
                    DB::connection('srsbi')->commit();
                    return '00';
                }
            }
            else
            {
                return '02';
            }
        } catch (\Exception $e) {
            DB::connection('srsbi')->rollback();
            return '01';
        }
    }

    public static function edit($id)
    {
        $q = "
                SELECT a.*, tat.id file_id, tat.trans_id, tat.file_name, tat.status
                    FROM admiseciso_transaction a
                    LEFT JOIN admiseciso_trans_attach tat ON tat.trans_id=a.id AND tat.status=1
                WHERE a.id=? AND a.disable=?
            ";

        $res = DB::connection('srsbi')->select($q, [$id, 0]);

        return $res;
    }
    
    public static function updateData($req)
    {
        $id = $req->input('id', true);
        $tanggal = $req->input('tanggal', true);
        $tanggal_lama = $req->input('old_date', true);
        $no_urut = $req->input('no_urut', true);
        $event_name = $req->input('event_name', true);

        $area = $req->input('area', true);
        $sub_area1 = $req->input('sub_area1', true);
        $sub_area2 = $req->input('sub_area2', true);
        $sub_area3 = $req->input('sub_area3', true);

        $assets = $req->input('assets', true);
        $sub_assets1 = $req->input('sub_assets1', true);
        $sub_assets2 = $req->input('sub_assets2', true);

        $risk_source = $req->input('risk_source', true);
        $sub_risksource1 = $req->input('sub_risksource1', true);
        $sub_risksource2 = $req->input('sub_risksource2', true);

        $risk = explode(':', $req->input('risk', true))[0];
        $sub_risk1 = $req->input('sub_risk1', true);
        $sub_risk2 = $req->input('sub_risk2', true);
        $risk_level = $req->input('risk_level', true);

        $financial = $req->input('financial', true);
        $sdm = $req->input('sdm', true);
        $operational = $req->input('operational', true);
        $reputation = $req->input('reputation', true);
        $find_impact = array(explode(':', $financial)[0], explode(':', $sdm)[0], explode(':', $operational)[0], explode(':', $reputation)[0]);
        $impact = max($find_impact);
        $chronology = htmlentities(addslashes($req->input('chronology', true)));
        $chronology = preg_replace("/'/", "\&#39;", $chronology);
        $reporter = $req->input('reporter', true);
        $sess_npk = AuthHelper::user_npk('npk');
        $attached = $req->input('attached');
        $curr_date = date('Y-m-d H:i:s');
        
        // Jika tanggal event diubah maka buat baru
        if(date('Ymd', strtotime($tanggal)) !== date('Ymd', strtotime($tanggal_lama)))
        {
            $q_no_urut = $this->srsdb->query("
                SELECT FORMAT(ISNULL(max(no_urut), 0) + 1, '000') no_urut_max
                FROM admiseciso_transaction
                WHERE month(event_date)=".date('m', strtotime($tanggal))." and year(event_date)=".date('Y', strtotime($tanggal))."
            ")->row();

            $no_urut = $q_no_urut->no_urut_max;
            $no_ref = $no_urut.'/LK/EA/'.FormHelper::convertRomawi(date('m', strtotime($tanggal))).'/'.date('Y', strtotime($tanggal));
        }
        else
        {
            $no_urut = $no_urut;
            // $no_ref = $tanggal_lama;
            $no_ref = $no_urut.'/LK/EA/'.FormHelper::convertRomawi(date('m', strtotime($tanggal))).'/'.date('Y', strtotime($tanggal));
        }

        $q = array();
        foreach ($area as $key => $are) {
            $q[$are] = "no_reference='$no_ref',no_urut='$no_urut',event_name='$event_name', event_date='$tanggal', area_id='$are', area_sub1_id=NULLIF('$sub_area1', ''), area_sub2_id=NULLIF('$sub_area2', ''), area_sub3_id=NULLIF('$sub_area3', ''), assets_id='$assets', assets_sub1_id=NULLIF('$sub_assets1', ''), assets_sub2_id=NULLIF('$sub_assets2', ''), risk_source_id='$risk_source', risksource_sub1_id=NULLIF('$sub_risksource1', ''), risksource_sub2_id=NULLIF('$sub_risksource2', ''), risk_id='$risk', risk_sub1_id=NULLIF('$sub_risk1', ''), risk_sub2_id=NULLIF('$sub_risk2', ''), risk_level_id='$risk_level', financial_level='".explode(':', $financial)[1]."', sdm_level='".explode(':', $sdm)[1]."', operational_level='".explode(':', $operational)[1]."', reputation_level='".explode(':', $reputation)[1]."', impact_level='$impact', chronology='$chronology', updated_by='$sess_npk', reporter='$reporter', updated_on='".date('Y-m-d H:i:s')."'";
        }

        $q_upd_implode = implode (", ", $q);
        
        DB::connection('srsbi')->beginTransaction();

        try {
            $column_update = "UPDATE admiseciso_transaction SET {$q_upd_implode} WHERE id={$id}";

            $qTrans = DB::connection('srsbi')->update($column_update);
            
            if($qTrans)
            {
                if(isset($_FILES['attach']) && $_FILES['attach']['name'][0] !== '')
                {
                    $no_attached_file = array();
                    foreach ($attached as $key => $atc) {
                        $no_attached_file[] = $key;
                    }

                    $upload = self::uploadMultipleFile($req->file('attach'), $tanggal);

                    if(empty($upload) || $upload == '01')
                    {
                        return '01';
                    }

                    $attach_file = $upload;

                    $no_attached_file = array_values($no_attached_file);

                    $field_file = 1; // No. column
                    $column_file_arr = array(); // Nama column
                    $field_file_name = array();
                    $field_file_column = array();

                    foreach ($upload as $key => $ifl) {
                        $column_file_arr[] = 'attach_file_'.$field_file;
                        $field_file_name[] = "'".$ifl['file_name']."'";
                        $field_file_column[] = "( {$id}, '".$ifl['file_name']."', '{$curr_date}')";
                        $field_file++;
                    }
                    
                    $column_file_implode = implode (", ", $column_file_arr);
                    $field_file_implode = implode (", ", $field_file_column);
                }
                else
                {
                    $attach_file = '';
                }

                if($attach_file !== '' && count($attach_file) > 0)
                {
                    $q_file = "INSERT INTO admiseciso_trans_attach(trans_id, file_name, created_on) VALUES ".$field_file_implode;
                        
                    $qTransFile = DB::connection('srsbi')->update($q_file);

                    if($qTransFile)
                    {
                        DB::connection('srsbi')->commit();
                        return '00';
                    }
                    else
                    {
                        DB::connection('srsbi')->rollback();
                        return '03';
                    }
                }
                else
                {
                    DB::connection('srsbi')->commit();
                    return '00';
                }
            }
            else
            {
                return '02';
            }
        } catch (\Exception $e) {
            DB::connection('srsbi')->rollback();
            return '01';
        }
    }

    public static function detail($req) 
    {
        $id = $req->input('id');

        $q = "
            SELECT a.id, a.event_name, a.event_date, a.no_urut, a.no_reference, a.reporter, a.chronology, vfi.level financial_level, vop.level operational_level, vre.level reputation_level, sdm.level sdm_level, a.impact_level, a.attach_file_1, a.attach_file_2, a.attach_file_3, a.attach_file_4, a.attach_file_5, asu.title area, asu1.title area_sub1, asu2.title area_sub2, asu3.title area_sub3, ass.title assets, ass1.title assets_sub1, ass2.title assets_sub2, rss.title risksource, rss1.title risksource1, rss2.title risksource2, ris.title risk, ris1.title risk1, ris2.title risk2, rle.level risk_level, tat.file_name
                , musr.name author, a.created_by author_npk, husr.name section_head, husr.npk section_head_npk
                FROM admiseciso_transaction a
                INNER JOIN admiseciso_area_sub asu ON asu.id=a.area_id
                INNER JOIN admiseciso_risk_level rle ON rle.id=a.risk_level_id
                INNER JOIN admiseciso_vurnability_level vfi ON vfi.id=a.financial_level
                INNER JOIN admiseciso_vurnability_level vop ON vop.id=a.operational_level
                INNER JOIN admiseciso_vurnability_level vre ON vre.id=a.reputation_level
                INNER JOIN admiseciso_vurnability_level sdm ON sdm.id=a.sdm_level
                INNER JOIN admiseciso_area_sub asu1 ON asu1.id=a.area_sub1_id
                INNER JOIN admiseciso_area_sub asu2 ON asu2.id=a.area_sub2_id
                LEFT JOIN admiseciso_area_sub asu3 ON asu3.id=a.area_sub3_id
                INNER JOIN admiseciso_assets_sub ass ON ass.id=a.assets_id
                LEFT JOIN admiseciso_assets_sub ass1 ON ass1.id=a.assets_sub1_id
                LEFT JOIN admiseciso_assets_sub ass2 ON ass2.id=a.assets_sub2_id
                INNER JOIN admiseciso_risksource_sub rss ON rss.id=a.risk_source_id
                LEFT JOIN admiseciso_risksource_sub rss1 ON rss1.id=a.risksource_sub1_id
                LEFT JOIN admiseciso_risksource_sub rss2 ON rss2.id=a.risksource_sub2_id
                INNER JOIN admiseciso_risk_sub ris ON ris.id=a.risk_id
                LEFT JOIN admiseciso_risk_sub ris1 ON ris1.id=a.risk_sub1_id
                LEFT JOIN admiseciso_risk_sub ris2 ON ris2.id=a.risk_sub2_id
                LEFT JOIN admiseciso_trans_attach tat ON tat.trans_id=a.id AND tat.status=1
                INNER JOIN isecurity.dbo.admisecsgp_mstusr musr ON musr.npk=a.created_by
                INNER JOIN (
                    select aas.id, amu.name, amu.npk 
                    from isecurity.dbo.admisec_area_users aau 
                    inner join isecurity.dbo.admisecsgp_mstusr amu ON amu.npk=aau.npk 
                    inner join isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id
                    inner join dbo.admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah
                    group by aas.id, amu.name, amu.npk
                ) husr ON husr.id=a.area_id
            WHERE a.id=?
        ";
        
        $res = DB::connection('srsbi')->select($q, [$id]);
        return $res;
    }
    
    public static function approve($req)
    {
        $userRole = AuthHelper::user_role();
        $userNpk = AuthHelper::user_npk();
        $id = $req->input('id');
        $currDate = date('Y-m-d H:i:s');

        $q = "UPDATE admiseciso_transaction SET status=?, approved_on=?, approved_by='$userNpk' WHERE id=?";
        
        $res = DB::connection('srsbi')->update($q, [1, "{$currDate}", $id]);

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
        $userRole = AuthHelper::user_role();
        $id = $req->input('id');

        $q = "UPDATE admiseciso_transaction SET disable=? WHERE id=?";

        $res = DB::connection('srsbi')->update($q, [1,$id]);

        if($res)
        {
            return '00';
        }
        else
        {
            return '02';
        }
    }
    
    public static function deleteAttachFile($req)
    {
        $userRole = AuthHelper::user_role();
        $path = public_path().'/uploads/srsbi/humint/';

        if(AuthHelper::is_super_admin())
        {
            $id = $req->input('fileId', true);
            $fileName = $req->input('fileName', true);
            $filePath = $path.$fileName;
            
            $q = "UPDATE admiseciso_trans_attach SET status=2 WHERE id=?";
            
            $res = DB::connection('srsbi')->update($q, [$id]);

            if($res)
            {
                if(file_exists($filePath))
                {
                    unlink($filePath);
                }
                return '00';
            }
            else
            {
                return '02';
            }
        }
        else
        {
            return '01';
        }
    }

    public static function search($req)
    {
        $keyword = $req->input('keyword',true);
        $key_array = explode(" ", $keyword);

        $q = "SELECT top 10 id, event_name ,event_date ,SUBSTRING(chronology, 1, 300) chronology
                from admiseciso_transaction at2 
            where 
            ";
        foreach ($key_array as $key => $val) {
            if($key > 0) $q .= ' or ';
            $q .= "event_name like '%$val%' ";
            $q .= ' or ';
            $q .= " chronology like '%$val%'";
        }

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    private static function uploadMultipleFile($files, $date)
    {
        if($files == null) return '01';

        $allowedfileExtension = ['pdf','jpg','jpeg','mp4','png','docx','xlsx'];
        $path = 'uploads/srsbi/humint';

        if(!is_dir($path))
        {
            mkdir($path, 0777, true);
        }

        $dataFiles = [];
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            
            if($check)
            {
                $rand_number = rand ( 10000 , 99999 );
                
                $fileName = 'srs_iso_'.preg_replace('/[^A-Za-z0-9]/', "", strtolower($date)).'_'.$rand_number.'.'.$file->getClientOriginalExtension();

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
