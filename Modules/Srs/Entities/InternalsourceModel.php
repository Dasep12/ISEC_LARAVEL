<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

use AuthHelper;

class InternalsourceModel extends Model
{
    use HasFactory;
    
    protected $connection= 'sqlsrv';
    protected $table = 'srs_bi.dbo.admiseciso_transaction';
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\InternalsourceModelFactory::new();
    }

    public static function area()
    {
        $user_npk = AuthHelper::user_npk();
        $user_wilayah = AuthHelper::user_wilayah();

        $q = "SELECT id, title 
                    FROM srs_bi.dbo.admiseciso_area_sub 
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
            INNER JOIN srs_bi.dbo.admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
            WHERE aau.npk=$user_npk)";
        }

        $q .= " ORDER BY title ASC";

        $res = DB::connection('sqlsrv')->select($q, [1,1]);

        return $res;
    }

    public static function no_urut()
    {
        $q = "
            SELECT FORMAT(ISNULL(max(no_urut), 0) + 1, '000') no_urut
            FROM srs_bi.dbo.admiseciso_transaction
            WHERE month(event_date)=? and year(event_date)=?
        ";

        $res = DB::connection('sqlsrv')->select($q, [date('m'), date('Y')]);

        return $res;
    }

    public static function sub_area()
    {
        $q ="SELECT id, title FROM srs_bi.dbo.admiseciso_area_sub WHERE area_categ_id=? AND status=?";

        $res = DB::connection('sqlsrv')->select($q, ['6', 1]);

        return $res;
    }

    public static function sub_area2($request='',$categ_id='')
    {
        if($_POST) 
        {
            $categ_id = $request->input('idcateg');
        }
        else
        {
            $categ_id = $categ_id;
        }

        $q = "
                SELECT a.id, a.title, b.title title_cat
                    FROM srs_bi.dbo.admiseciso_area_sub a
                    INNER JOIN srs_bi.dbo.admiseciso_area_categ b ON b.id=a.area_categ_id
                WHERE a.area_categ_id=(select area_categtarget_id from srs_bi.dbo.admiseciso_area_sub where id=?) AND a.status=?
            ";

        $res = DB::connection('sqlsrv')->select($q, [$categ_id, 1]);

        return $res;
    }

    public static function assest()
    {
        $q = "
                SELECT id, title, assets_categ_id
                    FROM srs_bi.dbo.admiseciso_assets_sub
                WHERE assets_categ_id=? AND status=? ORDER BY title ASC
            ";
        
        $res = DB::connection('sqlsrv')->select($q, [1, 1]);

        return $res;
    }

    public static function risk_source()
    {
        $q = "
                SELECT id, title 
                    FROM srs_bi.dbo.admiseciso_risksource_sub
                WHERE risksource_categ_id=? AND status=? ORDER BY title ASC
            ";
        
        $res = DB::connection('sqlsrv')->select($q, [1, 1]);

        return $res;
    }

    public static function risk()
    {
        $q = "
                SELECT a.id, a.title, c.id level_id, c.level
                    FROM srs_bi.dbo.admiseciso_risk_sub a
                    LEFT JOIN srs_bi.dbo.admiseciso_risk_level c ON c.id=a.level_id
                WHERE a.risk_categ_id=? AND a.status=? 
                ORDER BY a.title ASC
            ";
        
        $res = DB::connection('sqlsrv')->select($q, [1, 1]);

        return $res;
    }

    // public function sub_risk($categ_id='')
    // {
    //     if($_POST) 
    //     {
    //         $id = $this->input->post('idcateg', true);
    //     }
    //     else
    //     {
    //         $id = $categ_id;
    //     }

    //     $q = $this->srsdb->query("
    //             SELECT a.id, a.title, b.title title_cat
    //                 FROM admiseciso_risk_sub a
    //                 INNER JOIN admiseciso_risk_categ b ON b.id=a.risk_categ_id
    //             WHERE a.risk_categ_id=(select risk_categtarget_id from admiseciso_risk_sub where id='$id') AND a.status=1 ORDER BY a.title ASC
    //         ");

    //     return $q;
    // }

    public static function risk_level()
    {
        $q = "
                SELECT id, title, level FROM srs_bi.dbo.admiseciso_risk_level WHERE status=? ORDER BY level ASC
            ";
        
        $res = DB::connection('sqlsrv')->select($q, [1]);

        return $res;
    }

    public static function vurnability_level()
    {
        $q = "
                SELECT id, title, level, financial_desc, sdm_desc, operational_desc, reputation_desc
                FROM srs_bi.dbo.admiseciso_vurnability_level 
                WHERE status=? ORDER BY level ASC
            ";
        
        $res = DB::connection('sqlsrv')->select($q, [1]);

        return $res;
    }

    protected $t_trans_iso = 'admiseciso_transaction';
    var $column_order = array(null, 'a.event_name', 'a.event_date', 'asu.title', 'ass.title', 'rss.title', 'ris.title', 'a.impact_level', null); //field yang ada di table user
    var $column_search = array('a.event_name', 'asu.title', 'ass.title', 'rss.title', 'ris.title'); //field yang diizin untuk pencarian 
    var $order = array('a.event_date' => 'desc'); // default order 

    public static function listTable($request)
    {
        $totalFilteredRecord = $totalDataRecord = $draw_val = "";

        $columns_list = array(
            // 0 => 'no',
            "a.event_name",
            "a.event_date",
            // "area",
            // "assets",
            // "risk_source",
            // "risk",
            // "impact_level",
            // 8 =>'action',
        );
         
        $totalDataRecord = InternalsourceModel::where('disable','=',0)->count();
         
        $totalFilteredRecord = $totalDataRecord;

        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')]; //order.0.column
        $dir_val = $request->input('order.0.dir'); //order.0.dir

        if(empty($request->input('search.value')))
        {
            $q = DB::connection('sqlsrv')->table('srs_bi.dbo.admiseciso_transaction AS a')->select('a.id', 'a.event_name','a.event_date','a.impact_level','asu.title AS area','rss.title AS risk_source','ass.title AS assets','ris.title AS risk');
            $q->join('srs_bi.dbo.admiseciso_area_sub AS asu', 'asu.id', '=', 'a.area_id');
            $q->join('srs_bi.dbo.admiseciso_risksource_sub AS rss', 'rss.id', '=', 'a.risk_source_id');
            $q->join('srs_bi.dbo.admiseciso_assets_sub AS ass', 'ass.id', '=', 'a.assets_id');
            $q->join('srs_bi.dbo.admiseciso_risk_sub AS ris', 'ris.id', '=', 'a.risk_id');
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
                $postnestedData[] = '<button data-id="'.$post_val->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal">
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
}
