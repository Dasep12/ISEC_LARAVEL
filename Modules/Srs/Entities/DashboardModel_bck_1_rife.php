<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use AuthHelper;

class DashboardModel extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\DashboardModelFactory::new();
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

    public static function risk()
    {
        $q = "
            SELECT ris.title
                from srs_bi.dbo.admiseciso_risk_sub ris
                where ris.risk_categ_id=?
             ORDER BY ris.title ASC
            ";

        $res = DB::connection('sqlsrv')->select($q, [1]);

        return $res;
    }

    public static function target_assets()
    {
        $q = "
            SELECT aas.title
                FROM srs_bi.dbo.admiseciso_assets_sub aas
                WHERE aas.assets_categ_id=?
            ORDER BY aas.title ASC
            ";

        $res = DB::connection('sqlsrv')->select($q, [1]);

        return $res;
    }

    public static function grap_risk($req)
    {
        if($req->isMethod('post'))
        {
            $area = $req->input('area_fil');
            $year = $req->input('year_fil');
            $month = $req->input('month_fil');

            $q = "
                SELECT TOP 10 ris.id, ris.title, ISNULL(tis.total, 0) total
                    FROM srs_bi.dbo.admiseciso_risk_sub ris
                    LEFT JOIN ( 
                        select count(1) total, stis.risk_id
                            from srs_bi.dbo.admiseciso_transaction stis where stis.status=1 and stis.disable=0";
                            if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                            if(!empty($area)) $q .= " stis.area_id=$area ";
                            if(!empty($area) && !empty($year)) $q .= ' AND ';
                            if(!empty($year)) $q .= " year(stis.event_date)=$year ";
                            if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                            if(!empty($month)) $q .= " month(stis.event_date)=$month ";
                        $q .= " group by stis.risk_id
                    ) tis on tis.risk_id=ris.id 
                WHERE ris.risk_categ_id=? AND ris.status=?
                ORDER BY tis.total DESC
                ";

        }
        else
        {
            $year_now = date('Y');

            $q = "
                SELECT TOP 10 ris.id, ris.title, ISNULL(tis.total, 0) total
                    FROM srs_bi.dbo.admiseciso_risk_sub ris
                    LEFT JOIN ( 
                        select count(1) total, stis.risk_id
                            from srs_bi.dbo.admiseciso_transaction stis 
                        WHERE year(stis.event_date)='$year_now' and stis.status=1 and stis.disable=0
                        GROUP BY stis.risk_id
                    ) tis on tis.risk_id=ris.id 
                WHERE ris.risk_categ_id=? AND ris.status=?
                ORDER BY tis.total DESC
            ";
        }

        $res = DB::connection('sqlsrv')->select($q, [1,1]);

        return $res;
    }

    public static function grap_risk_source($req)
    {
        if($req->isMethod('post'))
        {
            $area = $req->input('area_fil');
            $year = $req->input('year_fil');
            $month = $req->input('month_fil');

            $q = "
                SELECT rso.id, rso.title, ISNULL(tis.total, 0) total
                    FROM srs_bi.dbo.admiseciso_risksource_sub rso
                    left join ( 
                        select count(1) total, stis.risk_source_id
                            from srs_bi.dbo.admiseciso_transaction stis WHERE stis.status=1 and stis.disable=0";
                            if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                            if(!empty($area)) $q .= " stis.area_id=$area ";
                            if(!empty($area) && !empty($year)) $q .= ' AND ';
                            if(!empty($year)) $q .= " year(stis.event_date)=$year ";
                            if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                            if(!empty($month)) $q .= " month(stis.event_date)=$month ";
                        $q .= " group by stis.risk_source_id
                    ) tis on tis.risk_source_id=rso.id 
                WHERE rso.risksource_categ_id=?
                ORDER BY tis.total DESC
                ";
        }
        else
        {
            $year_now = date('Y');

            $q = "
                SELECT rso.id, rso.title, ISNULL(tis.total, 0) total
                    FROM srs_bi.dbo.admiseciso_risksource_sub rso
                    left join ( 
                        select count(1) total, stis.risk_source_id
                            from srs_bi.dbo.admiseciso_transaction stis
                            where year(stis.event_date)='$year_now' AND stis.status=1 and stis.disable=0
                        group by stis.risk_source_id
                    ) tis on tis.risk_source_id=rso.id 
                WHERE rso.risksource_categ_id=?
                ORDER BY tis.total DESC
                ";
        }

        $res = DB::connection('sqlsrv')->select($q, [1]);

        return $res;
    }

    public static function grap_trans_month($req)
    {
        if($req->isMethod('post'))
        {
            $area = $req->input('area_fil');
            $year = $req->input('year_fil');
            $month = $req->input('month_fil');

            $q = "
                WITH months(MonthNum) AS
                (
                    SELECT 1
                    UNION ALL
                    SELECT MonthNum+1 
                        FROM months
                    WHERE MonthNum < 12
                )
                SELECT m.MonthNum month_num, count(t.id) total
                    FROM months m
                    LEFT OUTER JOIN srs_bi.dbo.admiseciso_transaction AS t ON MONTH(t.event_date)=m.MonthNum AND t.disable=0 AND t.status=1";
                    if(!empty($area) || !empty($year)) $q .= ' AND ';
                    if(!empty($area)) $q .= " t.area_id=$area ";
                    if(!empty($area) && !empty($year)) $q .= ' AND ';
                    if(!empty($year)) $q .= " year(t.event_date)=$year ";
            $q .= " GROUP BY m.MonthNum ";
        }
        else
        {
            $year_now = date('Y');

            $q = "
                WITH months(MonthNum) AS
                (
                    SELECT 1
                    UNION ALL
                    SELECT MonthNum+1 
                        FROM months
                    WHERE MonthNum < 12
                )
                SELECT m.MonthNum month_num, count(t.id) total
                    FROM months m
                LEFT OUTER JOIN srs_bi.dbo.admiseciso_transaction AS t ON MONTH(t.event_date)=m.MonthNum AND YEAR(t.event_date)='$year_now' AND t.disable=0 AND t.status=1
                GROUP BY m.MonthNum
            ";
        }

        $res = DB::connection('sqlsrv')->select($q);

        return $res;
    }

    public static function grap_trans_area($req)
    {
        if($req->isMethod('post'))
        {
            $year = $req->input('year_fil');
            $month = $req->input('month_fil');

            $q = "
                SELECT aar.title, ISNULL(tis.total, 0) total
                    FROM srs_bi.dbo.admiseciso_area_sub aar
                    LEFT JOIN ( 
                        select count(1) total, stis.area_id
                            from srs_bi.dbo.admiseciso_transaction stis where stis.disable=0 AND stis.status=1";
                            if(!empty($year) || !empty($month)) $q .= ' AND ';
                            if(!empty($year)) $q .= " year(stis.event_date)=$year ";
                            if(!empty($year) && !empty($month)) $q .= ' AND ';
                            if(!empty($month)) $q .= " month(stis.event_date)=$month ";
                        $q .= " group by stis.area_id
                    ) tis on tis.area_id=aar.id 
                WHERE aar.area_categ_id=?
                ORDER BY aar.title ASC";

        }
        else
        {
            $year_now = date('Y');

            $q = "
                SELECT aar.title, ISNULL(tis.total, 0) total
                FROM srs_bi.dbo.admiseciso_area_sub aar
                LEFT JOIN ( 
                    select count(1) total, stis.area_id 
                        from srs_bi.dbo.admiseciso_transaction stis
                        where year(stis.event_date)='$year_now' AND stis.disable=0 AND stis.status=1
                    group by stis.area_id
                ) tis ON tis.area_id=aar.id 
             WHERE aar.area_categ_id=?
             ORDER BY aar.title ASC
            ";
        }

        $res = DB::connection('sqlsrv')->select($q, [1]);

        return $res;
    }

    public static function grap_trans($req)
    {
        if($req->isMethod('post'))
        {
            $area = $req->input('area_fil');
            $year = $req->input('year_fil');
            $month = $req->input('month_fil');

            $q = "
                SELECT count(1) total
                    FROM srs_bi.dbo.admiseciso_transaction tis WHERE tis.disable=0 AND tis.status=1";
                if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                if(!empty($area)) $q .= " tis.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " year(tis.event_date)=$year ";
                if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                if(!empty($month)) $q .= " month(tis.event_date)=$month ";

        }
        else
        {
            $year_now = date('Y');

            $q = "
                SELECT count(1) total
                    FROM srs_bi.dbo.admiseciso_transaction tis
                WHERE year(tis.event_date)='$year_now' AND tis.status=1
            ";
        }

        $res = DB::connection('sqlsrv')->select($q);

        return $res;
    }

    public static function grap_target_assets($req)
    {
        if($req->isMethod('post'))
        {
            $area = $req->input('area_fil');
            $year = $req->input('year_fil');
            $month = $req->input('month_fil');

            $q = "
                SELECT ass.id, ass.title, ISNULL(tis.total, 0) total
                    FROM srs_bi.dbo.admiseciso_assets_sub ass
                    LEFT JOIN ( 
                        select count(1) total, stis.assets_id
                            from srs_bi.dbo.admiseciso_transaction stis where stis.disable=0 and stis.status=1";
                            if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                            if(!empty($area)) $q .= " stis.area_id=$area ";
                            if(!empty($area) && !empty($year)) $q .= ' AND ';
                            if(!empty($year)) $q .= " year(stis.event_date)=$year ";
                            if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                            if(!empty($month)) $q .= " month(stis.event_date)=$month ";
                        $q .= " group by stis.assets_id
                    ) tis on tis.assets_id=ass.id 
                WHERE ass.assets_categ_id=1
                ORDER BY tis.total DESC
                ";

        }
        else
        {
            $year_now = date('Y');

            $q = "
                SELECT ass.id, ass.title, ISNULL(tis.total, 0) total
                    FROM srs_bi.dbo.admiseciso_assets_sub ass
                    LEFT JOIN ( 
                        select count(1) total, stis.assets_id
                            from srs_bi.dbo.admiseciso_transaction stis
                            where year(stis.event_date)='$year_now' and stis.disable=0 and stis.status=1
                        group by stis.assets_id 
                    ) tis on tis.assets_id=ass.id 
                WHERE ass.assets_categ_id=1
                ORDER BY tis.total DESC
            ";
        }

        $res = DB::connection('sqlsrv')->select($q);

        return $res;
    }

    public static function grap_srs($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        
        $q = "SELECT FORMAT(COALESCE((COALESCE(max(arl.[level]),0) * 0.2) + (COALESCE(max(iml.impact_level),0) * 0.8),0),'N2') max_iso
                from srs_bi.dbo.admiseciso_transaction tio
                inner join srs_bi.dbo.admiseciso_risk_level arl ON arl.id=tio.risk_level_id 
                inner join (
                    select siml.area_id, siml.impact_level ,siml.status ,siml.disable ,siml.event_date
                        from srs_bi.dbo.admiseciso_transaction siml
                    group by siml.area_id, siml.impact_level ,siml.status ,siml.disable ,siml.event_date
                ) iml on iml.area_id=tio.area_id and iml.status=tio.status AND iml.disable=tio.disable AND iml.event_date=tio.event_date 
            WHERE tio.disable=0 AND tio.status=1
            ";

        if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
        if(!empty($area)) $q .= " tio.area_id=$area ";
        if(!empty($area) && !empty($year)) $q .= ' AND ';
        if(!empty($year)) $q .= " year(tio.event_date)=$year ";
        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
        if(!empty($month)) $q .= " month(tio.event_date)=$month ";

        $res = DB::connection('sqlsrv')->select($q);

        return $res;
    }

    public static function grap_soi($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');

        $q = "SELECT FORMAT(COALESCE(( AVG(soi.people) + AVG(soi.device) + AVG(soi.[system]) +
                + AVG(soi.network) ) / 4 , 0 ), 'N2') avg_soi
                FROM srs_bi.dbo.admisecsoi_transaction soi
            WHERE soi.disable=0 and soi.status=1
            ";
        if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
        if(!empty($area)) $q .= " soi.area_id=$area ";
        if(!empty($area) && !empty($year)) $q .= ' AND ';
        if(!empty($year)) $q .= " soi.year='$year' ";
        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
        if(!empty($month)) $q .= " soi.month='$month' ";

        $res = DB::connection('sqlsrv')->select($q);

        return $res;
    }

    public static function grap_soi_avg_month($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $label = $req->input('label_fil');

        $q = "
            WITH months(MonthNum) AS
            (
                SELECT 1
                UNION ALL
                SELECT MonthNum+1 
                    FROM months
                WHERE MonthNum < 12
            )
            SELECT m.MonthNum month_num, ISNULL(FORMAT(AVG(tra.avg_system),'N2'),0) avg_system 
                    ,ISNULL(FORMAT(AVG(tra.avg_people),'N2'),0) avg_people ,ISNULL(FORMAT(AVG(tra.avg_device),'N2'),0) avg_device 
                    ,ISNULL(FORMAT(AVG(tra.avg_network),'N2'),0) avg_network
                FROM months m
                LEFT OUTER JOIN (
                    select str.[month] ,str.[year] ,str.area_id ,AVG(str.system) avg_system ,AVG(str.people) avg_people
                            ,AVG(str.device) avg_device ,AVG(str.network) avg_network
                        FROM srs_bi.dbo.admisecsoi_transaction str
                        where str.disable=0 and str.status=1
                    group by str.[month] ,str.[year] ,str.area_id
                ) AS tra ON tra.[month]=m.MonthNum";
                if(!empty($area) || !empty($year)) $q .= ' AND ';
                if(!empty($area)) $q .= " tra.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " tra.year=$year ";
        $q .= " GROUP BY m.MonthNum ";

        $res = DB::connection('sqlsrv')->select($q);

        return $res;
    }

    public static function grap_soi_avgpilar($req)
    {
        if($req->isMethod('post'))
        {
            $year = $req->input('year_fil');
            $month = $req->input('month_fil');

            $q = "
                SELECT FORMAT(ISNULL(AVG(stis.people), 0), 'N2') avg_people ,FORMAT(ISNULL(AVG(stis.[system]), 0), 'N2') avg_system
                    ,FORMAT(ISNULL(AVG(stis.[device]), 0), 'N2') avg_device, FORMAT(ISNULL(AVG(stis.[network]), 0), 'N2') avg_network
                    FROM srs_bi.dbo.admisecsoi_transaction stis 
                WHERE stis.disable=0 AND stis.status=1";
                if(!empty($year) || !empty($month)) $q .= ' AND ';
                if(!empty($year)) $q .= " stis.[year]=$year ";
                if(!empty($year) && !empty($month)) $q .= ' AND ';
                if(!empty($month)) $q .= " stis.[month]=$month ";
        }
        else
        {
            $year_now = date('Y');

            $q = "
                SELECT FORMAT(ISNULL(AVG(stis.people), 0), 'N2') avg_people ,FORMAT(ISNULL(AVG(stis.[system]), 0), 'N2') avg_system
                    ,FORMAT(ISNULL(AVG(stis.[device]), 0), 'N2') avg_device, FORMAT(ISNULL(AVG(stis.[network]), 0), 'N2') avg_network
                    FROM srs_bi.dbo.admisecsoi_transaction stis 
                WHERE stis.disable=0 AND stis.status=1 and stis.[year]='$year_now'
            ";
        }

        $res = DB::connection('sqlsrv')->select($q);

        return $res;
    }

    public static function grap_soi_avg_montharea($req)
    {
        $year = $req->input('year_fil', true);
        $year = empty($year) ? date('Y') : $year;

        $q = "
            WITH months(MonthNum) AS
            (
                SELECT 1
                UNION ALL
                SELECT MonthNum+1 
                    FROM months
                WHERE MonthNum < 12
            )
            SELECT 
                    -- m.MonthNum month_num,
                    ara.title label ,FORMAT(ISNULL(avg(sotr.total), 0 ), 'N2') data
                FROM months m
                INNER JOIN (
                    select aas.area_categ_id ,aas.id ,aas.title
                        from srs_bi.dbo.admiseciso_area_sub aas
                    group by aas.area_categ_id ,aas.title ,aas.id 
                ) AS ara ON ara.area_categ_id=1
                LEFT JOIN (
                    select sotr.[year] ,sotr.[month] ,sotr.area_id, ( AVG(sotr.people) + AVG(sotr.device) 
                            + AVG(sotr.[system]) + AVG(sotr.network) ) / 4 total
                        from srs_bi.dbo.admisecsoi_transaction sotr
                    group by sotr.[year] ,sotr.[month] ,sotr.area_id
                ) sotr ON sotr.year=$year AND sotr.area_id=ara.id AND sotr.[month]=m.MonthNum GROUP BY m.MonthNum ,ara.title ,ara.id ORDER BY m.MonthNum ASC";

        $res = DB::connection('sqlsrv')->select($q);

        return $res;
    }
}
