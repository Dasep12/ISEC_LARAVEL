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

    public static function saveSoa($req)
    {
        $reportDate = $req->input("report_date");
        $shift = $req->input("shift");
        $area = $req->input("area");
        $chronology = $req->input("chronology");

        // people
        $employee = $req->input("employee");
        $contractor = $req->input("contractor");
        $visitor = $req->input("visitor");
        $business_partner = $req->input("business_partner");

        // document
        $pkb = $req->input("pkb");
        $pko = $req->input("pko");
        $surat_jalan = $req->input("surat_jalan");

        // vehicle employee
        $car_employee = $req->input("car_employee");
        $motorcycle_employee = $req->input("motorcycle_employee");
        $bicycle_employee = $req->input("bicycle_employee");
        // vehicle visitor
        $car_visitor = $req->input("car_visitor");
        $motorcycle_visitor = $req->input("motorcycle_visitor");
        $bicycle_visitor = $req->input("bicycle_visitor");
        $truck_visitor = $req->input("truck_visitor");
        // vehicle business partener
        $car_bp = $req->input("car_bp");
        $motorcycle_bp = $req->input("motorcycle_bp");
        $bicycle_bp = $req->input("bicycle_bp");
        $truck_bp = $req->input("truck_bp");
        // vehicle contractor
        $car_contractor = $req->input("car_contractor");
        $motorcycle_contractor = $req->input("motorcycle_contractor");
        $bicycle_contractor = $req->input("bicycle_contractor");
        $truck_contractor = $req->input("truck_contractor");
        // vehicle pool
        $car_pool = $req->input("car_pool");
        $motorcycle_pool = $req->input("motorcycle_pool");
        $bicycle_pool = $req->input("bicycle_pool");
        $truck_pool = $req->input("truck_pool");


        $searchPlant = DB::connection('soabi')->select("SELECT * FROM admisecdrep_transaction WHERE area_id='$area' AND shift='$shift' AND report_date='$reportDate' ");

        if (count($searchPlant) <= 0) {

            DB::connection('soabi')->beginTransaction();
            try {
                $headerDatas = array(
                    'created_on'        => date('Y-m-d H:i:s'),
                    'created_by'        => Session('npk'),
                    'status'            => 1,
                    'disable'           => 0,
                    'report_date'       => $reportDate,
                    'shift'             => $shift,
                    'chronology'        => $chronology,
                    'area_id'           => $area
                );
                DB::connection('soabi')->table('admisecdrep_transaction')->insert($headerDatas);
                $last_id = DB::connection('soabi')->getPdo()->lastInsertId();
                $data_people = array(
                    array(
                        'people_id' => 6, 'attendance' => $employee, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'people_id' => 7, 'attendance' => $visitor, 'trans_id' => $last_id,
                        'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'people_id' => 8, 'attendance' => $business_partner, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'people_id' => 9, 'attendance' => $contractor, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                );

                $data_document = array(
                    array(
                        'category_id' =>  12, 'document_in' => $pkb, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'category_id' =>  1035, 'document_in' => $pko, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'category_id' =>  1036, 'document_in' => $surat_jalan, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                );

                $data_vehicle  = array(
                    // vehicle
                    array(
                        'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_employee, 'people_id' => 6, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_employee, 'people_id' => 6, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_employee, 'people_id' => 6, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),

                    // visitor 
                    array(
                        'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_visitor, 'people_id' => 7, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_visitor, 'people_id' => 7, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 3, 'amount' => $truck_visitor, 'people_id' => 7, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_visitor, 'people_id' => 7, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),

                    // bp 
                    array(
                        'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_bp, 'people_id' => 8, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_bp, 'people_id' => 8, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 3, 'amount' => $truck_bp, 'people_id' => 8, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_bp, 'people_id' => 8, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),

                    // contractor
                    array(
                        'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_contractor, 'people_id' => 9, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_contractor, 'people_id' => 9, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 3, 'amount' => $truck_contractor, 'people_id' => 9, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_contractor, 'people_id' => 9, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    // pool
                    array(
                        'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_pool, 'people_id' => 32, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_pool, 'people_id' => 32, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 3, 'amount' => $truck_pool, 'people_id' => 32, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                    array(
                        'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_pool, 'people_id' => 32, 'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => Session('npk')
                    ),
                );

                DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($data_people);
                DB::connection('soabi')->table('admisecdrep_transaction_material')->insert($data_document);
                DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($data_vehicle);
                DB::connection('soabi')->commit();
                return 1;
            } catch (\Exception $e) {
                DB::connection('soabi')->rollback();
                return $e;
            }
        } else {
            // plant tidak ditemukan
            return 2;
        }
    }

    public static function  detailHeaderSoa($req)
    {
        $res = DB::connection('soabi')->select("SELECT *  from admisecdrep_transaction at2  where at2.shift  = '" . $req->input('shift') . "' and at2.report_date = '" . $req->input('tanggal') . "' and at2.area_id  = '" . $req->input('area') . "' ");
        return $res;
    }

    public static function updateHeaderTrans($req)
    {

        $last_id = $req->input("idTrans");
        DB::connection('soabi')->beginTransaction();
        try {


            DB::connection('soabi')->delete("DELETE admisecdrep_transaction_people WHERE trans_id = '$last_id' ");
            DB::connection('soabi')->delete("DELETE admisecdrep_transaction_vehicle WHERE trans_id = '$last_id' ");
            DB::connection('soabi')->delete("DELETE admisecdrep_transaction_material WHERE trans_id = '$last_id' ");

            DB::connection('soabi')->commit();
            return 1;
        } catch (\Exception $e) {
            DB::connection('soabi')->rollback();
            // return 2;
            return $e;
        }
    }
    public static function updateDetailTransSoa($req)
    {
        $last_id = $req->input("idTrans");

        // people
        $employee = $req->input("employee");
        $contractor = $req->input("contractor");
        $visitor = $req->input("visitor");
        $business_partner = $req->input("business_partner");

        // document
        $pkb = $req->input("pkb");
        $pko = $req->input("pko");
        $surat_jalan = $req->input("surat_jalan");

        // vehicle employee
        $car_employee = $req->input("car_employee");
        $motorcycle_employee = $req->input("motorcycle_employee");
        $bicycle_employee = $req->input("bicycle_employee");
        // vehicle visitor
        $car_visitor = $req->input("car_visitor");
        $motorcycle_visitor = $req->input("motorcycle_visitor");
        $bicycle_visitor = $req->input("bicycle_visitor");
        $truck_visitor = $req->input("truck_visitor");
        // vehicle business partener
        $car_bp = $req->input("car_bp");
        $motorcycle_bp = $req->input("motorcycle_bp");
        $bicycle_bp = $req->input("bicycle_bp");
        $truck_bp = $req->input("truck_bp");
        // vehicle contractor
        $car_contractor = $req->input("car_contractor");
        $motorcycle_contractor = $req->input("motorcycle_contractor");
        $bicycle_contractor = $req->input("bicycle_contractor");
        $truck_contractor = $req->input("truck_contractor");
        // vehicle pool
        $car_pool = $req->input("car_pool");
        $motorcycle_pool = $req->input("motorcycle_pool");
        $bicycle_pool = $req->input("bicycle_pool");
        $truck_pool = $req->input("truck_pool");

        DB::connection('soabi')->beginTransaction();
        try {
            $data_people = array(
                array(
                    'people_id' => 6, 'attendance' => $employee, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'people_id' => 7, 'attendance' => $visitor, 'trans_id' => $last_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'people_id' => 8, 'attendance' => $business_partner, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'people_id' => 9, 'attendance' => $contractor, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
            );

            $data_document = array(
                array(
                    'category_id' =>  12, 'document_in' => $pkb, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'category_id' =>  1035, 'document_in' => $pko, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'category_id' =>  1036, 'document_in' => $surat_jalan, 'trans_id' => $last_id, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
            );

            $data_vehicle  = array(
                // vehicle
                array(
                    'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_employee, 'people_id' => 6, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_employee, 'people_id' => 6, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_employee, 'people_id' => 6, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),

                // visitor 
                array(
                    'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_visitor, 'people_id' => 7, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_visitor, 'people_id' => 7, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 3, 'amount' => $truck_visitor, 'people_id' => 7, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_visitor, 'people_id' => 7, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),

                // bp 
                array(
                    'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_bp, 'people_id' => 8, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_bp, 'people_id' => 8, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 3, 'amount' => $truck_bp, 'people_id' => 8, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_bp, 'people_id' => 8, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),

                // contractor
                array(
                    'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_contractor, 'people_id' => 9, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_contractor, 'people_id' => 9, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 3, 'amount' => $truck_contractor, 'people_id' => 9, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_contractor, 'people_id' => 9, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                // pool
                array(
                    'trans_id' => $last_id, 'type_id' => 1, 'amount' => $car_pool, 'people_id' => 32, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 2, 'amount' => $motorcycle_pool, 'people_id' => 32, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 3, 'amount' => $truck_pool, 'people_id' => 32, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
                array(
                    'trans_id' => $last_id, 'type_id' => 1037, 'amount' => $bicycle_pool, 'people_id' => 32, 'created_at' => date("Y-m-d H:i:s"),
                    'created_by' => Session('npk')
                ),
            );

            DB::connection('soabi')->table('admisecdrep_transaction_people')->insert($data_people);
            DB::connection('soabi')->table('admisecdrep_transaction_material')->insert($data_document);
            DB::connection('soabi')->table('admisecdrep_transaction_vehicle')->insert($data_vehicle);
            DB::connection('soabi')->commit();
            return 1;
        } catch (\Exception $e) {
            DB::connection('soabi')->rollback();
            return $e;
        }
    }
}
