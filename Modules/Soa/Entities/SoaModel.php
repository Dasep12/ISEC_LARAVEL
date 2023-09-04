<?php

namespace Modules\Soa\Entities;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use GuzzleHttp\Psr7\Request;

class SoaModel extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\SoaModelFactory::new();
    }


    public static function getPerPlant()
    {
        $sql = "SELECT id, title FROM admisecdrep_sub WHERE categ_id='9' AND disable=0";
        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function getDataSoa($req)
    {

        $area = $req->input("areafilter");
        $start = $req->input("start");
        $end = $req->input("end");
        $where = "";
        if ($area) {
            $where .= 'AND at2.area_id= ' . $area . ' ';
        }

        $dateRange = "";
        if ($start) {
            $dateRange .= "AND FORMAT(at2.report_date,'yyyy-MM-dd') between '" . $start . "' AND '" . $end . "'  ";
        }

        $whereArea = "";
        // if (is_author('ALLAREA')) {
        //     $whereArea .= " AND wil_id='$this->wil'";
        // }
        $res =  DB::connection('soabi')->select("SELECT at2.report_date as tanggal , as2.title as area , SUM(X.ttal) as total_people  , 
        SUM(Y.ttal) as total_vehicle , 
        SUM(Z.ttal) as total_document ,
        at2.area_id 
        from  admisecdrep_transaction at2 
        inner join admisecdrep_sub as2 on as2.id  = at2.area_id 
        left outer JOIN (
            select sum(atp2.attendance)  as ttal , atp2.trans_id from admisecdrep_transaction_people atp2
            where atp2.people_id in (7,8,9)  and atp2.status = 1 
            group by  atp2.trans_id
        ) X  on X.trans_id = at2.id  
        left outer join(
            select sum(atv.amount) as ttal , atv.trans_id from admisecdrep_transaction_vehicle atv
            where atv.type_id in (1,2,3,1037)  and atv.status = 1 
            group by  atv.trans_id
        ) Y on Y.trans_id = at2.id 
        left outer join(
            select sum(atm.document_in)  as ttal , atm.trans_id from admisecdrep_transaction_material atm
            where atm.category_id in (12,1036,1035) and atm.status = 1 
            group by  atm.trans_id
        ) Z on Z.trans_id = at2.id
        WHERE at2.status = 1 
        $where 
        $dateRange
        $whereArea
        group by at2.report_date , as2.title ,at2.area_id
        order by at2.report_date  asc");
        return $res;
    }


    public static function listShiftDetail($req)
    {
        $date = $req->input("tanggal");
        $area = $req->input("area");
        $res = DB::connection('soabi')->select("SELECT at2.id as id_trans , at2.report_date as tanggal ,   at2.shift  , as2.title as area , SUM(X.ttal) as total_people  , 
        SUM(Y.ttal) as total_vehicle , 
        SUM(Z.ttal) as total_document 
        from  admisecdrep_transaction at2 
        inner join admisecdrep_sub as2 on as2.id  = at2.area_id 
        left outer JOIN (
            select sum(atp2.attendance)  as ttal , atp2.trans_id from admisecdrep_transaction_people atp2
            where atp2.people_id in (7,8,9) and atp2.status = 1 
            group by  atp2.trans_id
        ) X  on X.trans_id = at2.id  
        left outer join(
            select sum(atv.amount) as ttal , atv.trans_id from admisecdrep_transaction_vehicle atv
            where atv.type_id in (1,2,3,1037) and atv.status = 1
            group by  atv.trans_id
        ) Y on Y.trans_id = at2.id 
        left outer join(
            select sum(atm.document_in)  as ttal , atm.trans_id from admisecdrep_transaction_material atm
            where atm.category_id in (12,1036,1035) and atm.status = 1 
            group by  atm.trans_id
        ) Z on Z.trans_id = at2.id 
        WHERE at2.area_id  = '$area' and  at2.report_date  = '$date'
        group by at2.report_date , as2.title  , at2.id , at2.shift
        order by at2.shift  asc");
        return $res;
    }

    public static function detail_people($id)
    {
        $res  = DB::connection('soabi')->select("SELECT as2.title , COALESCE (X.total,0) as totals , X.shift from admisecdrep_sub as2 
        LEFT OUTER JOIN (
            select sum(atv.attendance) as total , at2.id as tr_id , atv.people_id , at2.shift  from admisecdrep_transaction at2 
            inner join admisecdrep_transaction_people  atv on atv.trans_id  = at2.id
            where at2.id  = '$id' and at2.status = 1 and atv.status = 1 
            group by   at2.id  , atv.people_id  , at2.shift
        )X on as2.id  = X.people_id
        where as2.id in (7,8,9)   ");
        return $res;
    }

    public static function detail_vehicle($id)
    {
        $res = DB::connection('soabi')->select("SELECT as2.title , COALESCE (X.total,0) as totals , X.shift from admisecdrep_sub as2 
        LEFT OUTER JOIN (
            select sum(atv.amount) as total , at2.id as tr_id , atv.type_id , at2.shift  from admisecdrep_transaction at2 
            inner join admisecdrep_transaction_vehicle atv on atv.trans_id  = at2.id
            where at2.id  = '$id' and at2.status = 1 and atv.status = 1 
            group by   at2.id  , atv.type_id  , at2.shift
        )X on as2.id  = X.type_id
        where as2.id  in  (1,2,3,1037) ");
        return $res;
    }

    public static function detail_material($id)
    {
        $res = DB::connection('soabi')->select("SELECT as2.title , COALESCE (X.total,0) as totals  from admisecdrep_sub as2 
        LEFT OUTER JOIN (
            select sum(atv.document_in) as total , at2.id as tr_id , atv.category_id   from admisecdrep_transaction at2 
            inner join admisecdrep_transaction_material  atv on atv.trans_id  = at2.id 
            where at2.id  = '$id' and at2.status = 1  and atv.status = 1
            group by   at2.id  , atv.category_id 
        )X on as2.id  = X.category_id 
        where as2.id  in  (12,1036,1035) ");
        return $res;
    }

    public static function deleteData($req)
    {
        $area  = $req->input("area");
        $date = $req->input("date");
        DB::connection('soabi')->beginTransaction();
        try {
            DB::connection('soabi')->update('UPDATE admisecdrep_transaction set `status` = 0 and `disable` = 1  WHERE area_id = ' . $area . ' and report_date =' . $date . ' ');

            DB::connection('soabi')->commit();
            return "01";
        } catch (\Exception $e) {
            DB::connection('soabi')->rollback();
            return "00";
        }
    }
}
