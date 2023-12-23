<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class DashboardModels extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'comp_name', 'address1', 'comp_phone', 'status', 'created_by', 'created_at', 'others'];
    protected $table = "admisecsgp_mstcmp";
    protected $primaryKey = 'company_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\CompanyFactory::new();
    }


    public static function getPlant()
    {
        $res = DB::select("SELECT plant_id , plant_name FROM admisecsgp_mstplant
         WHERE  status = 1 
         order by plant_name ASC  ");
        return $res;
    }

    public static function getPerPlant($id)
    {
        $res = DB::select("SELECT plant_id , plant_name FROM admisecsgp_mstplant
        WHERE plant_id='" . $id . "' AND status = 1 
         order by plant_name ASC ");
        return $res;
    }

    public static function trenPatroliBulanan($year, $plant)
    {
        $SQL = "WITH months(MonthNum) AS
                (
                    SELECT 1
                    UNION ALL
                    SELECT MonthNum+1 
                        FROM months
                    WHERE MonthNum < 12
                )
        SELECT m.MonthNum bulan , COALESCE (SUM(X.totals),0) as results  FROM months m
        left join (
        select  sum(vdg.counts_patroli) totals";
        if (!empty($plant)) {
            $SQL .= ", vdg.plant_name as plants";
        }
        $SQL .= ", MONTH(vdg.date_patroli)as bulan ,  YEAR(vdg.date_patroli) years
        from v_dashboard_gt vdg ";

        if (Session('role') != "SUPERADMIN") {
            $SQL .= "  WHERE vdg.plant_name in (SELECT plant_name FROM admisecsgp_mstplant WHERE admisecsgp_mstsite_site_id = '" . Session('site_id') . "')";
        }

        $SQL .= " group by  MONTH(vdg.date_patroli) , YEAR(vdg.date_patroli) ";
        if (!empty($plant)) {
            $SQL .= ",vdg.plant_name";
        }
        $SQL .= ") X on X.bulan = m.MonthNum AND X.years = $year ";
        if (!empty($plant)) {
            $SQL .= " AND X.plants = '$plant' ";
        }


        $SQL .= "GROUP BY m.MonthNum , X.totals 
        ORDER BY  m.MonthNum ASC";

        $data = DB::select($SQL);

        $res = array();
        foreach ($data as $d) {
            $res[] = (int) $d->results;
        }
        return $res;
    }

    // performance patroli
    public static function performancePatroliPerPlant($year, $plant)
    {
        $result = array();
        $query = "WITH months(Monthly) AS
        (
            SELECT 1
            UNION ALL
            SELECT Monthly+1 
                FROM months
            WHERE Monthly < 12
        )
        SELECT m.Monthly , COALESCE (X.results /  (datediff(day,  CONCAT($year,'-',m.Monthly,'-01'), dateadd(month, 1,  CONCAT($year,'-',m.Monthly,'-01'))) * 3)  ,0)res   FROM months m
        LEFT JOIN (
        SELECT vdg.plant_name as plants ,  sum(vdg.persentase) as results ,  YEAR(date_patroli) tahun , 
        MONTH(date_patroli) bulan
        FROM v_dashboard_gt vdg 
        GROUP BY YEAR(date_patroli), MONTH(date_patroli)  , vdg.plant_name
        )X on X.bulan =  m.Monthly  AND X.tahun = $year  AND X.plants = '$plant'
        GROUP BY  m.Monthly , X.results ";
        $data = DB::select($query);
        foreach ($data as $dt) {
            $result[] = (float)$dt->res;
        }
        return $result;
    }



    public static function performancePatroliAllPlant($year, $plant)
    {
        $tl = Plants::where([
            ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
            ['status', '=', 1],
        ])->count();
        $all = Session('role') == 'SUPERADMIN' ? count(Self::getPlant()) : $tl;
        $result = array();
        $SQL = "WITH months(bulan) AS
        (
            SELECT 1
            UNION ALL
            SELECT bulan+1 
                FROM months
            WHERE bulan < 12
        )
        SELECT m.bulan Bulan , sum(X.persen)as persentase FROM months m
        LEFT JOIN (
        select sum(vdg.persentase) as persen , YEAR(vdg.date_patroli) as years , MONTH(vdg.date_patroli) months
        from v_dashboard_gt vdg";

        if (Session('role') != "SUPERADMIN") {
            $SQL .= "  WHERE vdg.plant_name in (SELECT plant_name FROM admisecsgp_mstplant WHERE admisecsgp_mstsite_site_id = '" . Session('site_id') . "')";
        }

        $SQL .= " group by YEAR(vdg.date_patroli) ,  MONTH(vdg.date_patroli)
        )X on X.months = m.bulan AND X.years = $year 
        GROUP BY m.bulan ";


        $res = DB::select($SQL);

        $i = 1;
        foreach ($res as $r) {
            $hariPembagi = cal_days_in_month(CAL_GREGORIAN, $i, $year);
            $pembagi = 3 * $hariPembagi;
            $result[] =  round($r->persentase / $pembagi / $all, 0);
            $i++;
        }
        return $result;
    }

    public static function getPerformancePatroliHarianAllPlant($year, $month, $plant)
    {
        $totalHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $result = array();

        $SQL = " WITH months(Days) AS
            (
                SELECT 1
                UNION ALL
                SELECT Days+1 
                    FROM months
                WHERE Days < $totalHari
            )
            SELECT m.Days , COALESCE (X.results / 3 ,0)res  FROM months m
            LEFT JOIN (
            SELECT vdg.plant_name as plants ,  sum(vdg.persentase) as results ,  YEAR(date_patroli) tahun , 
            MONTH(date_patroli) bulan , DAY(date_patroli) hari
            FROM v_dashboard_gt vdg 
            GROUP BY YEAR(date_patroli), MONTH(date_patroli) , DAY(date_patroli) , vdg.plant_name
            )X on X.hari =  m.Days  AND X.tahun = $year AND X.bulan = $month AND X.plants = '$plant'
            GROUP BY  m.Days , X.results";
        $query = DB::select($SQL);
        foreach ($query as $q) {
            $result[] =  (float) $q->res;
        }
        return $result;
    }


    public static function trendPatrolSetahun($year, $month, $plant)
    {
        $where = "";
        if ($plant == "" && Session('role') == 'ADMIN') {
            $where .=  "a.admisecsgp_mstsite_site_id = '" . Session('site_id') . "' and  month(ath.date_patroli)='" . $month . "'
            and year(ath.date_patroli )='" . $year . "' ";
        } else if ($plant == "" && Session('role') == 'SUPERADMIN') {
            $where .= "month(ath.date_patroli)='" . $month . "'
                and year(ath.date_patroli )='" . $year . "' ";
        } else {
            $where .=  "a.plant_name = '" . $plant . "' and  month(ath.date_patroli)='" . $month . "'
                and year(ath.date_patroli )='" . $year . "' ";
        }

        $result =  DB::select("SELECT ath.date_patroli , count(1) as terpatroli   ,
        (SELECT  COUNT(1)
            from admisecsgp_trans_zona_patroli zp
            inner join admisecsgp_mstckp ckp on ckp.admisecsgp_mstzone_zone_id  = zp.admisecsgp_mstzone_zone_id 
            where 
            zp.status_zona  = 1 
            and zp.date_patroli  = ath.date_patroli 
            and zp.admisecsgp_mstshift_shift_id = ath.admisecsgp_mstshift_shift_id 
            and zp.admisecsgp_mstplant_plant_id = a.plant_id 
            )as plant_patroli ,
        IIF( (SELECT  COUNT(1)
        from admisecsgp_trans_zona_patroli zp
        inner join admisecsgp_mstckp ckp on ckp.admisecsgp_mstzone_zone_id  = zp.admisecsgp_mstzone_zone_id 
        where 
        zp.status_zona  = 1 
        and zp.date_patroli  = ath.date_patroli 
        and zp.admisecsgp_mstshift_shift_id = ath.admisecsgp_mstshift_shift_id 
        and zp.admisecsgp_mstplant_plant_id = a.plant_id 
        )  != count(1)  ,0,1) as counting_patrol
            from admisecsgp_trans_headers ath
            join admisecsgp_mstzone am on ath.admisecsgp_mstzone_zone_id = am.zone_id
            join admisecsgp_mstplant a on am.admisecsgp_mstplant_plant_id = a.plant_id
        where $where and ath.type_patrol=0
        group by ath.admisecsgp_mstshift_shift_id  ,ath.date_patroli , a.plant_id, a.plant_name 
        order by ath.date_patroli  asc");
        return $result;
    }

    public static function getTrendPatroliHarian($year, $month, $plant)
    {
        $totalHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $data = array();

        // for ($i = 1; $i <= $totalHari; $i++) {
        //     $res = Self::trendPatroliHarian($year, $month, $plant, $i, 0);
        //     array_push($data, $res);
        // }

        $SQL = " WITH months(Days) AS
                        (
                            SELECT 1
                            UNION ALL
                            SELECT Days+1 
                                FROM months
                            WHERE Days < $totalHari
                        )
                SELECT m.Days Hari , COALESCE (SUM(X.totals),0) as results  FROM months m
                left join (
                select  sum(vdg.counts_patroli) totals , 
                vdg.plant_name as plants ,
                DAY(vdg.date_patroli)as hari ,  MONTH(vdg.date_patroli)as bulan  ,  YEAR(vdg.date_patroli) years
                from v_dashboard_gt vdg 
                group by  DAY(vdg.date_patroli) , YEAR(vdg.date_patroli) , MONTH(vdg.date_patroli)
                , vdg.plant_name
                ) X on X.hari = m.Days AND X.years = $year AND X.bulan = $month 
                AND X.plants = '$plant'
                GROUP BY m.Days , X.totals 
                ORDER BY  m.Days ASC";
        $res = DB::select($SQL);
        foreach ($res as $d) {
            $data[] = (int)$d->results;
        }
        return $data;
    }

    public static function trendPatroliHarian($year, $month, $plant, $day, $type)
    {
        $query = DB::select("SELECT ath.date_patroli  , a.plant_name  , count(1) as terpatroli   ,
        (SELECT  COUNT(1)
        from admisecsgp_trans_zona_patroli zp
        inner join admisecsgp_mstckp ckp on ckp.admisecsgp_mstzone_zone_id  = zp.admisecsgp_mstzone_zone_id 
        where 
        zp.status_zona  = 1 
        and zp.date_patroli  = ath.date_patroli 
        and zp.admisecsgp_mstshift_shift_id = ath.admisecsgp_mstshift_shift_id 
        and zp.admisecsgp_mstplant_plant_id = a.plant_id 
        )as plant_patroli ,
        IIF( (SELECT  COUNT(1)
        from admisecsgp_trans_zona_patroli zp
        inner join admisecsgp_mstckp ckp on ckp.admisecsgp_mstzone_zone_id  = zp.admisecsgp_mstzone_zone_id 
        where 
        zp.status_zona  = 1 
        and zp.date_patroli  = ath.date_patroli 
        and zp.admisecsgp_mstshift_shift_id = ath.admisecsgp_mstshift_shift_id 
        and zp.admisecsgp_mstplant_plant_id = a.plant_id 
        )  != count(1)  ,0,1) as counting_patrol
            from admisecsgp_trans_headers ath
            join admisecsgp_mstzone am on ath.admisecsgp_mstzone_zone_id = am.zone_id
            join admisecsgp_mstplant a on am.admisecsgp_mstplant_plant_id = a.plant_id
        where ath.type_patrol=$type and a.plant_name = '" . $plant . "' and DAY(ath.date_patroli)= '" . $day . "'  and  month(ath.date_patroli)='" . $month . "'
            and year(ath.date_patroli )='" . $year . "' 
        group by ath.admisecsgp_mstshift_shift_id  ,ath.date_patroli , a.plant_id, a.plant_name 
        order by ath.date_patroli  asc  ");

        $data = array();
        foreach ($query as $d) {
            $data[] = $d->counting_patrol;
        }

        return array_sum($data);
    }

    public static function perFormaPatroliHarian($year, $month, $plant, $day, $type)
    {
        $query = DB::select("SELECT ath.date_patroli  , a.plant_name  , count(1) as terpatroli   ,
        (SELECT  COUNT(1)
        from admisecsgp_trans_zona_patroli zp
        inner join admisecsgp_mstckp ckp on ckp.admisecsgp_mstzone_zone_id  = zp.admisecsgp_mstzone_zone_id 
        where 
        zp.status_zona  = 1 
        and zp.date_patroli  = ath.date_patroli 
        and zp.admisecsgp_mstshift_shift_id = ath.admisecsgp_mstshift_shift_id 
        and zp.admisecsgp_mstplant_plant_id = a.plant_id 
        )as plant_patroli ,
        IIF( (SELECT  COUNT(1)
        from admisecsgp_trans_zona_patroli zp
        inner join admisecsgp_mstckp ckp on ckp.admisecsgp_mstzone_zone_id  = zp.admisecsgp_mstzone_zone_id 
        where 
        zp.status_zona  = 1 
        and zp.date_patroli  = ath.date_patroli 
        and zp.admisecsgp_mstshift_shift_id = ath.admisecsgp_mstshift_shift_id 
        and zp.admisecsgp_mstplant_plant_id = a.plant_id 
        )  != count(1)  ,0,1) as counting_patrol
            from admisecsgp_trans_headers ath
            join admisecsgp_mstzone am on ath.admisecsgp_mstzone_zone_id = am.zone_id
            join admisecsgp_mstplant a on am.admisecsgp_mstplant_plant_id = a.plant_id
        where ath.type_patrol=$type and a.plant_name = '" . $plant . "' and DAY(ath.date_patroli)= '" . $day . "'  and  month(ath.date_patroli)='" . $month . "'
            and year(ath.date_patroli )='" . $year . "' 
        group by ath.admisecsgp_mstshift_shift_id  ,ath.date_patroli , a.plant_id, a.plant_name 
        order by ath.date_patroli  asc  ");

        $data = array();
        foreach ($query as $d) {
            $data[] = ($d->terpatroli / $d->plant_patroli) * 100;
        }
        return array_sum($data);
        // return $data;
    }


    public static function getTemuanPatroliAll($year)
    {
        $data = array();
        $where = "";

        if (Session('role') == 'ADMIN') {
            $where .= "AND vtg.admisecsgp_mstsite_site_id = '" . Session('site_id') . "' ";
        }
        $query =  "WITH months(Monthly) AS
        (
            SELECT 1
            UNION ALL
            SELECT Monthly+1 
                FROM months
            WHERE Monthly < 12
        )
        SELECT m.Monthly , COALESCE(SUM(X.total),0)totals FROM months m 
         LEFT JOIN (
           SELECT count(plant_name) total , vtg.plant_name , YEAR(date_patroli) years, MONTH(date_patroli) months
           FROM v_temuan_gt vtg
           GROUP BY vtg.plant_name, YEAR(date_patroli) , MONTH(date_patroli)
         )X on X.months = m.Monthly AND years=$year 
         $where
         GROUP BY  m.Monthly 
           ";
        $res = DB::select($query);
        foreach ($res as $qr) {
            $data[] = (float) $qr->totals;
        }

        return $data;
    }

    private static function queryTemuanAll($year, $month)
    {
        $where = "";

        if (Session('role') == 'ADMIN') {
            $where .= "pl.admisecsgp_mstsite_site_id = '" . Session('site_id') . "' and ";
        }
        $query =   DB::select("SELECT  ath.date_patroli , pl.plant_name , atd.status_temuan  , atd.description 
        from admisecsgp_trans_details atd 
        inner join admisecsgp_trans_headers ath on ath.trans_header_id  = atd.admisecsgp_trans_headers_trans_headers_id 
        inner join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id 
        inner join admisecsgp_mstplant pl on pl.plant_id  = zn.admisecsgp_mstplant_plant_id 
        where  
        $where
        MONTH(ath.date_patroli) = $month and YEAR (ath.date_patroli)= $year and atd.status_temuan  = 0 
        group by ath.date_patroli , pl.plant_name  ,  atd.status_temuan , atd.description 
        order by ath.date_patroli");
        return $query;
    }


    public static function getTemuanPerRegu($year, $month, $regu)
    {
        // $res = Self::queryTemuanRegu($year, $month, $rg);
        $query = "SELECT am.plant_name ,  COALESCE(SUM(X.res),0) hasil FROM admisecsgp_mstplant am 
        LEFT JOIN (
            SELECT COUNT(1) as  res , vtg.plant_name as plants , vtg.patrol_group as regu , year(vtg.date_patroli) tahun , 
            month(vtg.date_patroli)bulan 
            FROM v_temuangroup_gt vtg 
            GROUP BY vtg.plant_name , vtg.patrol_group , vtg.date_patroli 
        )X on X.plants = am.plant_name  AND X.regu = '" . $regu . "'  AND X.tahun = $year ";


        // if (!empty($month)) {
        //     $query .= " AND YEAR(X.bulan)  = $month ";
        // }

        $query .= "WHERE am.status  = 1 
        GROUP BY am.plant_name 
        ORDER BY am.plant_name  ASC";

        $res =  DB::select($query);
        $result = array();
        foreach ($res as $q) {
            $result[] = (int) $q->hasil;
        }
        return  $result;
    }

    public static function queryTemuanRegu($year, $month, $regu)
    {
        $query = DB::select("SELECT usr.patrol_group , pl.plant_name ,
        (select count(1) FROM admisecsgp_trans_details atd
        inner join admisecsgp_trans_headers ath ON ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
        WHERE MONTH(ath.date_patroli) = $month and YEAR(ath.date_patroli) = $year
        and atd.created_by  = usr.npk and atd.status_temuan  = 0 
        )as total
        FROM 
        admisecsgp_mstusr usr 
        inner join admisecsgp_mstplant pl ON pl.plant_id  = usr.admisecsgp_mstplant_plant_id 
        inner join admisecsgp_mstroleusr rl ON rl.role_id  = usr.admisecsgp_mstroleusr_role_id 
        where rl.[level]  = 'Security'   and usr.status  = 1 and usr.patrol_group = '" . $regu . "'
        group by usr.npk , usr.patrol_group  , pl.plant_name
        order by pl.plant_name 
        ");
        return $query;
    }
}
