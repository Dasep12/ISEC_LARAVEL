<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\RoleModel;
use AuthHelper;

class UserAreaModel extends Model
{
    use HasFactory;
    
    private static $columnOrder = array(null, 'usr.name', null);
    private static $columnSearch = array('usr.name');
    private static $order = array('usr.name' => 'desc');

    private static function getDataTable($req)
    {
        $areaFilter = $req->input('areafilter');
        $yearFilter = $req->input('yearfilter');
        $datefilter = $req->input('datefilter');
        $statusfilter = $req->input('statusfilter');
        $searchFilter = $req->input('search.value');
        $dir_val = $req->input('order.0.dir');
        $npk = AuthHelper::user_npk();

        $q = DB::connection('sqlsrv')
            ->table('admisec_area_users as aus')
            ->select('aus.id','usr.name','msi.site_name')
            ->join('admisecsgp_mstusr as usr', 'usr.npk', '=', 'aus.npk')
            ->join('admisecsgp_mstsite as msi', 'aus.site_id', '=', 'msi.site_id');
       
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
        // STATUS
        if($statusfilter !== '' && ($statusfilter == '0' || $statusfilter == '1')) $q->where('a.status','=',$statusfilter);

        if($searchFilter)
        {
            $searchColumn = '';
            foreach (self::$columnSearch as $key => $val) {
                if($key > 0) $searchColumn .= ' or ';
                $searchColumn .= "{$val} like '%$searchFilter%' ";
            }
            $q->whereRaw($searchColumn);
        }

        return $q;
    }

    public static function listTable($req)
    {
        $npk = AuthHelper::user_npk();

        $totalFilteredRecord = $totalDataRecord = $draw_val = "";

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
            foreach($resultData as $key => $item)
            {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $item->name;
                $row[] = $item->site_name;
                // $row[] = $item->module;

                $delBtn = AuthHelper::is_super_admin() || (isset($access_modul->dlt) && $access_modul->dlt == 1) ? '<button data-id="'.$item->id.'" class="btn btn-sm btn-danger " data-toggle="modal" data-target="#deleteModal"> <i class="fa fa-trash"></i></button> ' : '';
                $row[] = $delBtn;
                
                $data_val[] = $row;
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
    
    public static function insertData($req)
    {
        $npk = $req->input('npk');
        $site = $req->input('site');

        $q = "INSERT INTO admisec_area_users (npk, site_id) VALUES (?,?)";

        $res = DB::connection('sqlsrv')->insert($q, [$npk, $site]);

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
        $id = $req->input('id');

        $q = "DELETE FROM admisec_area_users WHERE id=?";

        $res = DB::connection('sqlsrv')->delete($q, [$id]);

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