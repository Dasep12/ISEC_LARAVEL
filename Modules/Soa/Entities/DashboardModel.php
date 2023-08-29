<?php

namespace Modules\Soa\Entities;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use GuzzleHttp\Psr7\Request;

class DashboardModel extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\DashboardModelFactory::new();
    }

    public static function getPerPlant()
    {
        $sql = "SELECT id, title FROM admisecdrep_sub WHERE categ_id='9' AND disable=0";
        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function peopleAll($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();

        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $sql = "SELECT FORMAT(COALESCE(SUM(b.attendance),0), 'N0') AS total_people
        FROM soa_bi.dbo.admisecdrep_transaction as a
        INNER JOIN soa_bi.dbo.admisecdrep_transaction_people b ON b.trans_id=a.id and 
        b.people_id in (7,8,9)
        INNER JOIN admisecdrep_sub as2 on as2.id  = a.area_id 
        WHERE a.disable=0  and a.status = 1 and b.status = 1  $whereWil";
        if (!empty($area)) $sql .= " AND a.area_id='$area'";
        if (!empty($month)) $sql .= " AND MONTH(a.report_date)='$month'";
        if (!empty($year)) $sql .= " AND YEAR(a.report_date)='$year'";

        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function vehicleAll($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();

        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $sql = "SELECT FORMAT(COALESCE(SUM(atv.amount),0), 'N0') AS total
        FROM soa_bi.dbo.admisecdrep_transaction as a
        INNER JOIN soa_bi.dbo.admisecdrep_transaction_vehicle atv ON atv.trans_id=a.id
        INNER JOIN admisecdrep_sub as2 on as2.id  = a.area_id  
        WHERE a.disable=0 and atv.type_id in (1,2,3,1037) and a.status = 1 and atv.status = 1  $whereWil";
        if (!empty($area)) $sql .= " AND a.area_id='$area'";
        if (!empty($month)) $sql .= " AND MONTH(a.report_date)='$month'";
        if (!empty($year)) $sql .= " AND YEAR(a.report_date)='$year'";

        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function documentAll($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        // $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();

        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }


        $sql  = "SELECT SUM(atm.document_in) AS total
        FROM soa_bi.dbo.admisecdrep_transaction atr
        INNER JOIN soa_bi.dbo.admisecdrep_transaction_material atm ON atm.trans_id=atr.id
        INNER JOIN admisecdrep_sub as2 on as2.id  = atr.area_id 
        WHERE atr.disable=0 and atm.category_id in (1035,1036) and atr.status = 1 and atm.status = 1 ";

        // $sql  = "SELECT FORMAT(COALESCE(COUNT(PKBNo),0), 'N0') AS total
        // FROM T_PKB trx WHERE NULLIF(PKBNo, '') IS NOT NULL ";

        if (!empty($month)) $sql .= " AND MONTH(atr.report_date)='$month'";
        if (!empty($year)) $sql .= " AND YEAR(atr.report_date) = '$year' ";
        if (!empty($area)) $sql .= " AND atr.area_id='$area'";

        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function documentPKBAll($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        // $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        if ($area != "" || $area != null) {
            $plantID = DB::connection('soabi')->select("SELECT code_sub as id FROM admisecdrep_sub WHERE id='$area'  ");
            $area =  $plantID[0]->id;
        }
        $sql = "SELECT  COUNT(tp.PKBNo) as total  FROM T_PKB tp 
        WHERE  NULLIF(tp.PKBNo, '') IS NOT NULL  ";

        if (!empty($area)) $sql .= " AND tp.LocationName='$area'";
        if (!empty($month)) $sql .= " AND MONTH(tp.PKBDate)='$month'";
        if (!empty($year)) $sql .= " AND YEAR(tp.PKBDate)='$year'";

        $res = DB::connection('egate')->select($sql);
        return $res;
    }



    // daily
    public static function peopleDays($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $month = empty($month) ? date('m') : $month;
        $user_wilayah = AuthHelper::user_wilayah();
        $whereArea = "";
        if ($area) {
            $whereArea .= 'AND trx.area_id  = ' . $area;
        }

        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $kalendar = CAL_GREGORIAN;
        $days = cal_days_in_month($kalendar, $month, $year);

        $sql = "WITH days(DayNum) AS
        (
            SELECT 1
            UNION ALL
            SELECT DayNum+1 
                FROM days
            WHERE DayNum < '$days'
        )
        SELECT m.DayNum day_num ,tas.id AS people_categ ,tas.title  ,COALESCE(SUM(trx.total),0) total
            FROM days m
                INNER JOIN soa_bi.dbo.admisecdrep_sub tas ON tas.id in (7,8,9) 
                LEFT OUTER JOIN (
                    SELECT atp.people_id, atr.report_date, atr.disable, atr.area_id ,as2.wil_id as wil  , SUM(atp.attendance) AS total
                        FROM soa_bi.dbo.admisecdrep_transaction atr
                        INNER JOIN soa_bi.dbo.admisecdrep_transaction_people atp ON atp.trans_id=atr.id 
                        INNER JOIN soa_bi.dbo.admisecdrep_sub as2 ON as2.id  = atr.area_id 
                        WHERE atr.status = 1  and atp.status = 1 
                    GROUP BY atp.people_id, atr.report_date, atr.disable , atr.area_id ,as2.wil_id 
                ) AS trx ON DAY(trx.report_date)=m.DayNum AND trx.people_id=tas.id AND YEAR(trx.report_date)='$year' 
                    AND MONTH(trx.report_date)='$month'
                    $whereArea
                    $whereWil 
            WHERE tas.disable=0  
            GROUP BY m.DayNum, tas.id ,tas.title
            ORDER BY tas.id ASC";

        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function vehicleDays($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $month = empty($month) ? date('m') : $month;
        $user_wilayah = AuthHelper::user_wilayah();
        $whereArea = "";
        if ($area) {
            $whereArea .= 'AND trx.area_id  = ' . $area;
        }

        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $kalendar = CAL_GREGORIAN;
        $days = cal_days_in_month($kalendar, $month, $year);

        $sql = "WITH days(DayNum) AS
        (
            SELECT 1
            UNION ALL
            SELECT DayNum+1 
                FROM days
            WHERE DayNum < '$days'
        )
        SELECT m.DayNum day_num ,tas.id AS vehicle_categ ,tas.title ,COALESCE(SUM(trx.total),0) total
        FROM days m
            INNER JOIN soa_bi.dbo.admisecdrep_sub tas ON tas.id in (1,2,3,1037) 
            LEFT OUTER JOIN (
                SELECT atp.type_id, atr.report_date, atr.disable, atr.area_id , as2.wil_id as wil ,  SUM(atp.amount) AS total
                    FROM soa_bi.dbo.admisecdrep_transaction atr
                    INNER JOIN soa_bi.dbo.admisecdrep_transaction_vehicle atp ON atp.trans_id=atr.id  
                    INNER JOIN soa_bi.dbo.admisecdrep_sub as2 ON as2.id  = atr.area_id 
                    WHERE atr.status = 1  and atp.status = 1
                GROUP BY atp.type_id, atr.report_date, atr.disable , atr.area_id ,as2.wil_id 
            ) AS trx ON DAY(trx.report_date)=m.DayNum AND trx.type_id=tas.id AND YEAR(trx.report_date)='$year' 
                AND MONTH(trx.report_date)='$month'
                $whereArea
                $whereWil 
        WHERE tas.disable=0 
        GROUP BY m.DayNum, tas.id ,tas.title
        ORDER BY tas.id ASC";

        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function documentDays($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $month = empty($month) ? date('m') : $month;
        $user_wilayah = AuthHelper::user_wilayah();
        $whereArea = "";
        if ($area) {
            $whereArea .= 'AND trx.area_id  = ' . $area;
        }

        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $kalendar = CAL_GREGORIAN;
        $days = cal_days_in_month($kalendar, $month, $year);

        $sql = "WITH days(DayNum) AS
        (
            SELECT 1
            UNION ALL
            SELECT DayNum+1 
                FROM days
            WHERE DayNum < '$days'
        )
        SELECT m.DayNum day_num ,tas.id AS document_categ ,tas.title  ,COALESCE(SUM(trx.total),0) total
        FROM days m
            INNER JOIN soa_bi.dbo.admisecdrep_sub tas ON tas.id in (1036,1035) 
            LEFT OUTER JOIN (
                SELECT atp.category_id, atr.report_date, atr.disable,  atr.area_id, as2.wil_id as wil  , SUM(atp.document_in) AS total
                    FROM soa_bi.dbo.admisecdrep_transaction atr
                    INNER JOIN soa_bi.dbo.admisecdrep_transaction_material atp ON atp.trans_id=atr.id
                    INNER JOIN soa_bi.dbo.admisecdrep_sub as2 ON as2.id  = atr.area_id 
                    WHERE atr.status = 1  and atp.status = 1 
                GROUP BY atp.category_id, atr.report_date, atr.disable , atr.area_id,as2.wil_id 
            ) AS trx ON DAY(trx.report_date)=m.DayNum AND trx.category_id=tas.id AND YEAR(trx.report_date)='$year' 
                AND MONTH(trx.report_date)='$month'
                $whereArea
                $whereWil
        WHERE tas.disable=0 
        GROUP BY m.DayNum, tas.id ,tas.title
        ORDER BY tas.id ASC";

        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function pkbDays($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $month = empty($month) ? date('m') : $month;
        if ($area != "" || $area != null) {
            $plantID = DB::connection('soabi')->select("SELECT code_sub as id FROM admisecdrep_sub WHERE id='$area'  ");
            $area =  $plantID[0]->id;
        }
        $kalendar = CAL_GREGORIAN;
        $days = cal_days_in_month($kalendar, $month, $year);
        $sql = "WITH days(DayNum) AS
                (
                    SELECT 1
                    UNION ALL
                    SELECT DayNum+1 
                        FROM days
                    WHERE DayNum < '$days'
                )
        SELECT m.DayNum day_num , SUM(COALESCE(X.total,0)) as total 
        FROM days m 
            LEFT OUTER JOIN(
                SELECT COUNT(*) as total , tp.PKBDate  as tgl FROM T_PKB tp 
                GROUP BY tp.PKBDate 
            )X on YEAR(X.tgl) = '$year' and MONTH(X.tgl) = '$month' and DAY(X.tgl) = m.DayNum
                GROUP BY m.DayNum ";

        if (!empty($area)) $sql .= "WHERE tp.LocationName='$area'";
        // if (!empty($month)) $sql .= " AND MONTH(tp.PKBDate)='$month'";
        // if (!empty($year)) $sql .= " AND YEAR(tp.PKBDate)='$year'";

        $res = DB::connection('egate')->select($sql);
        return $res;
    }
    // 


    // category 
    public static function vehicleCategory($req, $id)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $sql = "SELECT COALESCE(SUM(atv.amount),0) AS total
                FROM admisecdrep_transaction as a
                INNER JOIN admisecdrep_transaction_vehicle atv ON atv.trans_id=a.id 
                INNER JOIN admisecdrep_sub as2 ON as2.id  = a.area_id 
                WHERE a.disable=0 and atv.type_id = '$id' and atv.status = 1 $whereWil ";

        if (!empty($area)) $sql .= " AND a.area_id='$area'";
        if (!empty($month)) $sql .= " AND MONTH(a.report_date)='$month'";
        if (!empty($year)) $sql .= " AND YEAR(a.report_date)='$year'";

        $res = DB::connection('soabi')->select($sql);
        if ($res) {
            return (int) $res[0]->total;
        } else {
            return (int) 0;
        }
    }

    public static function peopleCategory($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $sql = "SELECT tas.id, tas.title
                ,COALESCE(trx.total, 0) AS total_kehadiran
                FROM soa_bi.dbo.admisecdrep_sub tas
                LEFT JOIN (
                    SELECT atp.people_id, atr.disable, SUM(atp.attendance) AS total
                        FROM soa_bi.dbo.admisecdrep_transaction atr
                        INNER JOIN soa_bi.dbo.admisecdrep_transaction_people atp ON atp.trans_id=atr.id 
                        INNER JOIN admisecdrep_sub as2 ON as2.id  = atr.area_id 
                        WHERE atr.disable=0 and atp.status = 1 and atr.status = 1 $whereWil ";

        if (!empty($area)) $sql .= " AND atr.area_id='$area'";
        if (!empty($month)) $sql .= " AND MONTH(atr.report_date)='$month'";
        if (!empty($year)) $sql .= " AND YEAR(atr.report_date)='$year'";

        $sql .= " GROUP BY atp.people_id, atr.disable
                ) AS trx ON trx.people_id=tas.id 
            WHERE tas.id in(7,8,9) AND tas.disable=0 ORDER BY tas.id ASC";


        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function documentCategory($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $sql = "SELECT tas.id, tas.title 
        ,COALESCE(trx.total, 0) AS total
        FROM soa_bi.dbo.admisecdrep_sub tas
        LEFT JOIN (
            SELECT atp.category_id, atr.disable, SUM(atp.document_in) AS total
                FROM soa_bi.dbo.admisecdrep_transaction atr
                INNER JOIN soa_bi.dbo.admisecdrep_transaction_material atp ON atp.trans_id=atr.id 
                INNER JOIN admisecdrep_sub as2 ON as2.id  = atr.area_id 
                WHERE atr.disable=0 and atr.status = 1 and atp.status = 1 $whereWil ";

        if (!empty($area)) $sql .= " AND atr.area_id='$area'";
        if (!empty($month)) $sql .= " AND MONTH(atr.report_date)='$month'";
        if (!empty($year)) $sql .= " AND YEAR(atr.report_date)='$year'";

        $sql .= " GROUP BY atp.category_id, atr.disable
            ) AS trx ON trx.category_id=tas.id 
            WHERE tas.id in(1035,1036) AND tas.disable=0 ORDER BY tas.id ASC";


        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function documentPKB($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }


        $sql = "SELECT  1 as id  ,'PKB' as title  , COUNT(tp.PKBNo) as total  FROM T_PKB tp 
        WHERE  NULLIF(tp.PKBNo, '') IS NOT NULL ";

        // if (!empty($area)) $sql .= " AND tp.LocationName='$area'";
        if ($area != "" || $area != null) {
            $plantID = DB::connection('soabi')->select("SELECT code_sub as id FROM admisecdrep_sub WHERE id='$area'  ");
            $sql .= " AND tp.LocationName='" . $plantID[0]->id . " '";
        }

        if (!empty($month)) $sql .= " AND MONTH(tp.PKBDate)='$month'";
        if (!empty($year)) $sql .= " AND YEAR(tp.PKBDate)='$year'";

        $res = DB::connection('egate')->select($sql);
        return $res;
    }



    // categoriy bulanan
    public static function peopleSetahun($req)
    {
        $year = $req->input("year") == null ? date('Y') : $req->input("year");
        $area = $req->input("plant");
        $area_kode = $req->input("area_fill");
        $wherePlant = "";

        if ($area != "" || $area != null) {
            $wherePlant .= " AND a.area_id='$area'";
        }
        // else if ($area_kode != "" || $area_kode != null) {
        //     $idArea  = $this->soadb->get_where("admisecdrep_sub", ['code_sub' => $area_kode])->row();
        //     $wherePlant .= " AND a.area_id='$idArea->id'";
        // }

        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $res = DB::connection('soabi')->select("WITH months(MonthNumber) AS
        (
            SELECT 1
            UNION ALL
            SELECT MonthNumber+1 
            FROM months
            WHERE MonthNumber < 12
        )
        select
        (
          SELECT COALESCE(SUM(b.attendance),0) AS total_people
                FROM soa_bi.dbo.admisecdrep_transaction as a
                INNER JOIN soa_bi.dbo.admisecdrep_transaction_people b ON b.trans_id=a.id and 
                b.people_id in (7,8,9)
                INNER JOIN soa_bi.dbo.admisecdrep_sub as2 ON as2.id  = a.area_id 
                WHERE a.disable=0 and b.status = 1
                AND MONTH(a.report_date)= MonthNumber
                AND YEAR(a.report_date)='$year'
                AND a.status = 1
                $wherePlant
                $whereWil
        )as total 
        from months ");
        $data = array();

        foreach ($res as $r) {
            $data[] = (int) $r->total;
        }
        return $data;
    }

    public static function vehicleSetahun($req)
    {
        $year = $req->input("year") == null ? date('Y') : $req->input("year");
        $area = $req->input("plant");
        $area_kode = $req->input("area_fill");
        $wherePlant = "";

        if ($area != "" || $area != null) {
            $wherePlant .= " AND a.area_id='$area'";
        }
        // else if ($area_kode != "" || $area_kode != null) {
        //     $idArea  = $this->soadb->get_where("admisecdrep_sub", ['code_sub' => $area_kode])->row();
        //     $wherePlant .= " AND a.area_id='$idArea->id'";
        // }

        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        $res = DB::connection('soabi')->select("WITH months(MonthNumber) AS
        (
            SELECT 1
            UNION ALL
            SELECT MonthNumber+1 
            FROM months
            WHERE MonthNumber < 12
        )
        select
        (
            SELECT COALESCE(SUM(atv.amount),0) AS total
                        FROM soa_bi.dbo.admisecdrep_transaction as a
                        INNER JOIN soa_bi.dbo.admisecdrep_transaction_vehicle atv ON atv.trans_id=a.id 
                        INNER JOIN soa_bi.dbo.admisecdrep_sub as2 ON as2.id  = a.area_id 
                    WHERE a.disable=0 and atv.type_id in (1,2,3,1037) and atv.status = 1
                AND MONTH(a.report_date)= MonthNumber
                AND a.status = 1
                AND YEAR(a.report_date)='$year'
                $wherePlant
                $whereWil
        )as total 
        from months ");
        $data = array();

        foreach ($res as $r) {
            $data[] = (int) $r->total;
        }
        return $data;
    }

    public static function documentSetahun($req)
    {
        $year = $req->input("year") == null ? date('Y') : $req->input("year");
        $area = $req->input("plant");
        $wherePlant = "";
        if ($area) {
            $wherePlant .= " AND atr.area_id='$area'";
        }
        $res = DB::connection('soabi')->select("WITH months(MonthNumber) AS
        (
            SELECT 1
            UNION ALL
            SELECT MonthNumber+1 
            FROM months
            WHERE MonthNumber < 12
        )
        select MonthNumber  as bulan  ,
        (
          SELECT COALESCE(SUM(atm.document_in),0) AS total
                    FROM soa_bi.dbo.admisecdrep_transaction atr
                    LEFT JOIN soa_bi.dbo.admisecdrep_transaction_material atm ON atm.trans_id=atr.id
                    INNER JOIN soa_bi.dbo.admisecdrep_sub as2 ON as2.id  = atr.area_id 
                WHERE atr.disable=0 and atm.category_id in (1035,1036) and atm.status = 1
                AND MONTH(atr.report_date)= MonthNumber
                AND atr.status = 1
                AND YEAR(atr.report_date)='$year'
                $wherePlant 
        )as total 
        from months");

        $data = array();

        foreach ($res as $r) {
            $data[] = (int) $r->total;
        }
        return $data;
    }

    public static function pkbSetahun($req)
    {
        $year = $req->input("year") == null ? date('Y') : $req->input("year");
        $area = $req->input("plant");
        $wherePlant = "";

        if ($area != "" || $area != null) {
            $plantID = DB::connection('soabi')->select("SELECT code_sub as id FROM admisecdrep_sub WHERE id='$area'  ");
            $wherePlant .= " AND tp.LocationName='" . $plantID[0]->id . " '";
        }
        $res = DB::connection('egate')->select("WITH days(DayNum) AS
        (
            SELECT 1
            UNION ALL
            SELECT DayNum+1 
                FROM days
            WHERE DayNum < '12'
        )
        SELECT m.DayNum day_num ,
        (
            select count(*) as total FROM T_PKB tp 
            WHERE 
            YEAR(tp.PKBDate) = '$year' 
            and MONTH(tp.PKBDate) = m.DayNum 
            $wherePlant
        ) total
        FROM days m");

        $data = array();

        foreach ($res as $r) {
            $data[] = (int) $r->total;
        }
        return $data;
    }
    //


    // PKB modal popup graphic
    public static function pkbAllPlant($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }

        if ($area != "" || $area != null) {
            $plantID = DB::connection('soabi')->select("SELECT code_sub as id FROM admisecdrep_sub WHERE id='$area'  ");
            $area =  $plantID[0]->id;
        }

        $sql = "WITH Mplants AS (
            Select DummiesPlant FROM  (values ('P1'),('P2'),('P3'),('P4'),('P5'),('HO'),('PC')) A(DummiesPlant)
        )
        SELECT pl.DummiesPlant as plants , sum(COALESCE(X.total,0)) as total  FROM Mplants pl
            LEFT OUTER JOIN(
             SELECT COUNT(tp.PKBNo) as total , tp.PKBDate , tp.LocationName as plt FROM T_PKB tp
             WHERE YEAR(tp.PKBDate) = '$year'";
        if (!empty($month))  $sql .= "and MONTH(tp.PKBDate) = '$month'";
        $sql .= "GROUP BY tp.PKBDate , tp.LocationName
            )X on X.plt = pl.DummiesPlant
        ";
        if (!empty($area)) $sql .= " WHERE pl.DummiesPlant='$area'";
        $sql .= "GROUP BY pl.DummiesPlant";
        $res = DB::connection('egate')->select($sql);
        return $res;
    }

    public static function pkbPlantSetahun($req)
    {
        // $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        // $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }
        $sql = "WITH days(DayNum) AS
            (
                SELECT 1
                UNION ALL
                SELECT DayNum+1 
                    FROM days
                WHERE DayNum < '12'
            ),
        Mplants AS 
            (
            Select * FROM  (values ('P1'),('P2'),('P3'),('P4'),('P5'),('HO'),('PC')) A(DummiesPlant)
            ) 
        SELECT m.DayNum as months , Mplants.DummiesPlant as plantss, SUM(COALESCE(X.counting,0)) as total
          FROM days m 
           LEFT JOIN Mplants on Mplants.DummiesPlant in ('P1','P2','P3','P4','P5','HO','PC')
            LEFT OUTER JOIN(
                SELECT count(tp.PKBNo) as counting , tp.LocationName as plants , tp.PKBDate as tgl FROM T_PKB tp 
                GROUP BY tp.LocationName , tp.PKBDate 
            )X on MONTH(X.tgl) = m.DayNum  AND YEAR(x.tgl)='$year'  AND  X.plants = Mplants.DummiesPlant 
        GROUP BY m.DayNum , Mplants.DummiesPlant
        ORDER BY DummiesPlant  ASC";
        $res = DB::connection('egate')->select($sql);
        return $res;
    }

    public static function pkbByDepartement($req, $type)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }
        if ($area != "" || $area != null) {
            $plantID = DB::connection('soabi')->select("SELECT code_sub as id FROM admisecdrep_sub WHERE id='$area'  ");
            $area =  $plantID[0]->id;
        }
        if ($type == 'top') {
            $sql = "SELECT TOP 5  tp.DeptName , count(tp.DeptName) as total 
            from T_PKB tp WHERE YEAR(tp.PKBDate)='$year'";
        } else {
            $sql = "SELECT  tp.DeptName , count(tp.DeptName) as total 
        from T_PKB tp WHERE YEAR(tp.PKBDate)='$year'";
        }

        if (!empty($area)) $sql .= "AND tp.LocationName='$area'";
        if (!empty($month)) $sql .= "AND MONTH(tp.PKBDate)='$month'";
        $sql .= "group by tp.DeptName order by total desc ";
        $res = DB::connection('egate')->select($sql);
        return $res;
    }

    public static function pkbByUser($req, $type)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $user_wilayah = AuthHelper::user_wilayah();
        $whereWil = "";
        if (AuthHelper::is_author('ALLAREA')) {
            $whereWil .= " AND wil_id='$user_wilayah'";
        }
        if ($area != "" || $area != null) {
            $plantID = DB::connection('soabi')->select("SELECT code_sub as id FROM admisecdrep_sub WHERE id='$area'  ");
            $area =  $plantID[0]->id;
        }
        if ($type == 'top') {
            $sql = "SELECT TOP 5  tp.Creator , count(tp.EntryUser) as total 
            from T_PKB tp WHERE YEAR(tp.PKBDate)='$year'";
        } else {
            $sql = "SELECT  tp.Creator , count(tp.EntryUser) as total 
        from T_PKB tp WHERE YEAR(tp.PKBDate)='$year'";
        }

        if (!empty($area)) $sql .= "AND tp.LocationName='$area'";
        if (!empty($month)) $sql .= "AND MONTH(tp.PKBDate)='$month'";
        $sql .= "group by tp.Creator , tp.EntryUser order by total desc ";
        $res = DB::connection('egate')->select($sql);
        return $res;
    }
}
