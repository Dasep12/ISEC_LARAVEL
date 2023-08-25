<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\RoleModel;

use AuthHelper;

class InternalsourceModel extends Model
{
    use HasFactory;
    
    protected $fillable = [];

    protected $connection = 'srsbi';
    protected $table = 'dbo.admiseciso_transaction';
    protected $isModule = 'SRSISO';
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\InternalsourceModelFactory::new();
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
            $q .= " AND wil_id='$wil'";
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

    public static function sub_area2($req, $categ_id='')
    {
        if($req->isMethod('post')) 
        {
            $categ_id = $req->input('idcateg', true);
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

    public static function sub_assets($req, $categ_id='')
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
                    FROM admiseciso_assets_sub a
                    INNER JOIN admiseciso_assets_categ b ON b.id=a.assets_categ_id
                WHERE a.assets_categ_id=(select assets_categtarget_id from admiseciso_assets_sub where id=?) AND a.status=1
            ";

        $res = DB::connection('srsbi')->select($q, [$categ_id]);

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

    public static function sub_risksource($req, $categ_id='')
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
                WHERE a.risksource_categ_id=(select risksource_categtarget_id from admiseciso_risksource_sub where id=?) AND a.status=1 ORDER BY a.title ASC
            ";

        $res = DB::connection('srsbi')->select($q, [$categ_id]);

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
    
    public static function sub_risk($req, $categ_id='')
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

        $res = DB::connection('srsbi')->select($q, [1]);

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

    protected $t_trans_iso = 'admiseciso_transaction';
    var $column_order = array(null, 'a.event_name', 'a.event_date', 'asu.title', 'ass.title', 'rss.title', 'ris.title', 'a.impact_level', null); //field yang ada di table user
    var $column_search = array('a.event_name', 'asu.title', 'ass.title', 'rss.title', 'ris.title'); //field yang diizin untuk pencarian 
    var $order = array('a.event_date' => 'desc'); // default order 

    public static function listTable($request)
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
            8 =>'action',
        );
         
        $totalDataRecord = InternalsourceModel::where('disable','=',0)->count();
         
        $totalFilteredRecord = $totalDataRecord;

        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')]; //order.0.column
        $dir_val = $request->input('order.0.dir'); //order.0.dir

        if(empty($request->input('search.value')))
        {
            $q = DB::connection('srsbi')->table('dbo.admiseciso_transaction AS a')->select('a.id', 'a.event_name','a.event_date','a.impact_level','a.status','asu.title AS area','rss.title AS risk_source','ass.title AS assets','ris.title AS risk');
            $q->join('dbo.admiseciso_area_sub AS asu', 'asu.id', '=', 'a.area_id');
            $q->join('dbo.admiseciso_risksource_sub AS rss', 'rss.id', '=', 'a.risk_source_id');
            $q->join('dbo.admiseciso_assets_sub AS ass', 'ass.id', '=', 'a.assets_id');
            $q->join('dbo.admiseciso_risk_sub AS ris', 'ris.id', '=', 'a.risk_id');
            $q->where('disable','=',0);
            $q->offset($start_val);
            $q->limit($limit_val);
            $q->orderBy('a.event_date',$dir_val);
            $post_data = $q->get();
        }
        else 
        {
            $search_text = $request->input('search.value');

            $q1 = InternalsourceModel::select('event_name','event_date');
            $q1->orWhere('event_name', 'LIKE', "%{$search_text}%");
            $q1->where('disable','=',0);
            $q1->offset($start_val);
            $q1->limit($limit_val);
            $q1->orderBy($order_val,$dir_val);
            $post_data = $q1->get();
             
            $q2 = InternalsourceModel::where('disable','=',0);
            if($search_text)
            {
                $q2->orWhere('event_name', 'LIKE',"%{$search_text}%");
            }
            $totalFilteredRecord = $q2->count();
        }
         
        $data_val = array();
        if(!empty($post_data))
        {
            $no = $start_val;
            foreach($post_data as $key => $post_val)
            {
                $no++;
                $postnestedData = array();
                $postnestedData[] = $no;
                $postnestedData[] = $post_val->event_name;
                $postnestedData[] = date('d F Y H:i', strtotime($post_val->event_date));
                $postnestedData[] = $post_val->area;
                $postnestedData[] = $post_val->assets;
                $postnestedData[] = $post_val->risk_source;
                $postnestedData[] = $post_val->risk;
                $postnestedData[] = $post_val->impact_level;
        
                $access_modul = RoleModel::access_modul($npk, 'SRSISO')[0];
                // dd($access_modul);

                $edt_btn = AuthHelper::is_super_admin() ? '<a class="btn btn-sm btn-info" href="'.url('srs/internal_source/edit/'.$post_val->id).'">
                        <i class="fa fa-edit"></i>
                </a> ' : '';$appr_btn = AuthHelper::is_super_admin() || (isset($access_modul->apr) && $access_modul->apr == 1) ? $post_val->status == 1 ? '<button class="btn btn-sm btn-success" title="Approved">
                        <i class="fa fa-check"></i>
                    </button> ' : '<button data-id="'.$post_val->id.'" data-title="'.$post_val->event_name.'" class="btn btn-sm btn-success" data-toggle="modal" data-target="#approveModal">
                        Approve
                    </button> ' : '';
                $appr_btn = AuthHelper::is_super_admin() || (isset($access_modul->apr) && $access_modul->apr == 1) ? $post_val->status == 1 ? '<button class="btn btn-sm btn-success" title="Approved">
                        <i class="fa fa-check"></i>
                    </button> ' : '<button data-id="'.$post_val->id.'" data-title="'.$post_val->event_name.'" class="btn btn-sm btn-success" data-toggle="modal" data-target="#approveModal">
                        Approve
                    </button> ' : '';
                $postnestedData[] = $edt_btn.'<button data-id="'.$post_val->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal">
                        Detail
                    </button> ';
                // $postnestedData['options'] = "&emsp;<a href='{$datashow}'class='showdata' title='SHOW DATA' ><span class='showdata glyphicon glyphicon-list'></span></a>&emsp;<a href='{$dataedit}' class='editdata' title='EDIT DATA' ><span class='editdata glyphicon glyphicon-edit'></span></a>";
                $data_val[] = $postnestedData;
            }
        }

        $draw_val = $request->input('draw');
        $get_json_data = array(
            "draw"            => intval($draw_val),
            "recordsTotal"    => intval($totalDataRecord),
            "recordsFiltered" => intval($totalFilteredRecord),
            "data"            => $data_val
        );

        return $get_json_data;
    }

    public static function edit($id)
    {
        $q = "
                SELECT a.*, tat.id file_id, tat.trans_id, tat.file_name, tat.status
                    FROM admiseciso_transaction a
                    LEFT JOIN admiseciso_trans_attach tat ON tat.trans_id=a.id AND tat.status=1
                WHERE a.id=?
            ";

        $res = DB::connection('srsbi')->select($q, [$id]);

        return $res;
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
}
