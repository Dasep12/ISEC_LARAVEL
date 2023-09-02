<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use AuthHelper;

class HumintDashboardV2Model extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\DashboardHumintV2ModelFactory::new();
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

    public static function risk()
    {
        $q = "
            SELECT ris.title
                from dbo.admiseciso_risk_sub ris
                where ris.risk_categ_id=?
             ORDER BY ris.title ASC
            ";

        $res = DB::connection('srsbi')->select($q, [1]);

        return $res;
    }

    public static function target_assets()
    {
        $q = "
            SELECT aas.title
                FROM dbo.admiseciso_assets_sub aas
                WHERE aas.assets_categ_id=?
            ORDER BY aas.title ASC
            ";

        $res = DB::connection('srsbi')->select($q, [1]);

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
                    FROM dbo.admiseciso_risk_sub ris
                    LEFT JOIN ( 
                        select count(1) total, stis.risk_id
                            from dbo.admiseciso_transaction stis where stis.status=1 and stis.disable=0";
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
                    FROM dbo.admiseciso_risk_sub ris
                    LEFT JOIN ( 
                        select count(1) total, stis.risk_id
                            from dbo.admiseciso_transaction stis 
                        WHERE year(stis.event_date)='$year_now' and stis.status=1 and stis.disable=0
                        GROUP BY stis.risk_id
                    ) tis on tis.risk_id=ris.id 
                WHERE ris.risk_categ_id=? AND ris.status=?
                ORDER BY tis.total DESC
            ";
        }

        $res = DB::connection('srsbi')->select($q, [1,1]);

        return $res;
    }
    
    public static function grapDetailRisk($req, $sub_name)
    {
        if($req->isMethod('post'))
        {
            $area = $req->input('area_fil', true);
            $year = $req->input('year_fil', true);
            $year = empty($year) ? date('Y') : $year;
            $month = $req->input('month_fil', true);
            // $label = $req->input('label_fil', true);
            $id = $req->input('id_fil', true);

            $q = "
                WITH months(MonthNum) AS
                (
                    SELECT 1
                    UNION ALL
                    SELECT MonthNum+1 
                        FROM months
                    WHERE MonthNum < 12
                )
                SELECT m.MonthNum month_num ,count(t.id) total
                    FROM months m
                    LEFT OUTER JOIN (
                        select str.id ,str.event_date ,str.area_id
                            from dbo.admiseciso_transaction str
                            where str.".$sub_name."=(select id from dbo.admiseciso_risk_sub where  id=$id) and str.disable=0 and str.status=1
                        group by str.id ,str.event_date ,str.area_id
                    ) AS t ON MONTH(t.event_date)=m.MonthNum ";
                    if(!empty($area) || !empty($year)) $q .= ' AND ';
                    if(!empty($area)) $q .= " t.area_id=$area ";
                    if(!empty($area) && !empty($year)) $q .= ' AND ';
                    if(!empty($year)) $q .= " year(t.event_date)=$year ";
            $q .= " GROUP BY m.MonthNum ";
            // lower(title)=lower('".$label."'))
        }

        $res = DB::connection('srsbi')->select($q, [0,1]);

        return $res;
    }

    public static function grapDetailRiskSub($req, $sub_name)
    {
        $area = $req->input('area_fil', true);
        $year = $req->input('year_fil', true);
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil', true);
        $id = $req->input('id_fil', true);

        $q = "
            SELECT rsu.id ,rsu.title ,ISNULL(t.total,0) total
                FROM dbo.admiseciso_risk_sub rsu
                LEFT OUTER JOIN (
                    SELECT count(1) total ,atr.".$sub_name."
                        from dbo.admiseciso_transaction atr 
                        where atr.disable=? AND atr.status=?";
                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " atr.area_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(atr.event_date)=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(atr.event_date)=$month ";
                    $q .= "group by atr.".$sub_name."
                ) t ON t.".$sub_name."=rsu.id
            WHERE rsu.risk_categ_id=(select risk_categtarget_id from dbo.admiseciso_risk_sub where id=$id)
            GROUP BY rsu.id ,rsu.title ,t.total
            ORDER BY t.total DESC
            ";
            // lower(title)=lower('".$label."')

            $res = DB::connection('srsbi')->select($q, [0,1]);

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
                    FROM dbo.admiseciso_risksource_sub rso
                    left join ( 
                        select count(1) total, stis.risk_source_id
                            from dbo.admiseciso_transaction stis WHERE stis.status=1 and stis.disable=0";
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
                    FROM dbo.admiseciso_risksource_sub rso
                    left join ( 
                        select count(1) total, stis.risk_source_id
                            from dbo.admiseciso_transaction stis
                            where year(stis.event_date)='$year_now' AND stis.status=1 and stis.disable=0
                        group by stis.risk_source_id
                    ) tis on tis.risk_source_id=rso.id 
                WHERE rso.risksource_categ_id=?
                ORDER BY tis.total DESC
                ";
        }

        $res = DB::connection('srsbi')->select($q, [1]);

        return $res;
    }

    public static function grapDetailRiskSource($req, $sub_name)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $label = $req->input('label_fil');
        $id = $req->input('id_fil');

        $q = "
            WITH months(MonthNum) AS
            (
                SELECT 1
                UNION ALL
                SELECT MonthNum+1 
                    FROM months
                WHERE MonthNum < 12
            )
            SELECT m.MonthNum month_num ,count(t.total) total
                FROM months m
                LEFT OUTER JOIN (
                    select count(str.id) total ,str.event_date ,str.area_id
                        from dbo.admiseciso_transaction str
                        where str.".$sub_name."=(select id from dbo.admiseciso_risksource_sub where id=$id) and str.disable=0 and str.status=1
                    group by str.id ,str.event_date ,str.area_id
                ) AS t ON MONTH(t.event_date)=m.MonthNum ";
                if(!empty($area) || !empty($year)) $q .= ' AND ';
                if(!empty($area)) $q .= " t.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " year(t.event_date)=$year ";
        $q .= " GROUP BY m.MonthNum, t.total ORDER BY t.total DESC";
        // lower(title)=lower('".$label."')

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    public static function grapDetailRiskSourceSub($req, $sub_name)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        $id = $req->input('id_fil');

        $q = "
            SELECT rsu.id ,rsu.title ,ISNULL(t.total,0) total
                FROM dbo.admiseciso_risksource_sub rsu
                LEFT OUTER JOIN (
                    SELECT count(1) total ,atr.".$sub_name."
                        from dbo.admiseciso_transaction atr 
                        where atr.disable=0 AND atr.status=1";
                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " atr.area_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(atr.event_date)=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(atr.event_date)=$month ";
                    $q .= "group by atr.".$sub_name."
                ) t ON t.".$sub_name."=rsu.id
            WHERE rsu.risksource_categ_id=(select risksource_categtarget_id from dbo.admiseciso_risksource_sub where id=$id)
            GROUP BY rsu.id ,rsu.title ,t.total
            ORDER BY t.total DESC
            ";

        $res = DB::connection('srsbi')->select($q);

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
                    LEFT OUTER JOIN dbo.admiseciso_transaction AS t ON MONTH(t.event_date)=m.MonthNum AND t.disable=0 AND t.status=1";
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
                LEFT OUTER JOIN dbo.admiseciso_transaction AS t ON MONTH(t.event_date)=m.MonthNum AND YEAR(t.event_date)='$year_now' AND t.disable=0 AND t.status=1
                GROUP BY m.MonthNum
            ";
        }

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    public static function grap_trans_area($req)
    {
        if($req->isMethod('post'))
        {
            $year = $req->input('year_fil');
            $month = $req->input('month_fil');
            $area = $req->input('area_fil');

            $q = "
                SELECT aar.title, ISNULL(tis.total, 0) total
                FROM dbo.admiseciso_area_sub aar
                LEFT JOIN ( 
                    select count(1) total, stis.area_id
                        from dbo.admiseciso_transaction stis where stis.disable=0 AND stis.status=1";
                        if(!empty($year) || !empty($month) || !empty($area)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(stis.event_date)=$year ";
                        // if(!empty($year) && !empty($month)) $q .= ' AND ';
                        // if(!empty($month)) $q .= " month(stis.event_date)=$month ";
                    $q .= " group by stis.area_id
                ) tis on tis.area_id=aar.id 
            WHERE aar.area_categ_id=1 AND aar.status=1";
                if(!empty($area)) $q .= ' AND ';
                if(!empty($area)) $q .= " aar.id=$area ";
            $q .= "ORDER BY aar.title ASC";
        }
        else
        {
            $year_now = date('Y');
            
            $q = "
                SELECT aar.title, ISNULL(tis.total, 0) total
                FROM dbo.admiseciso_area_sub aar
                LEFT JOIN ( 
                    select count(1) total, stis.area_id 
                        from dbo.admiseciso_transaction stis
                        where year(stis.event_date)='$year_now' AND stis.disable=0 AND stis.status=1
                    group by stis.area_id
                ) tis ON tis.area_id=aar.id 
             WHERE aar.area_categ_id=1 aar.status=1
             ORDER BY aar.title ASC
            ";
        }

        $res = DB::connection('srsbi')->select($q, [1]);

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
                    FROM dbo.admiseciso_transaction tis WHERE tis.disable=0 AND tis.status=1";
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
                    FROM dbo.admiseciso_transaction tis
                WHERE year(tis.event_date)='$year_now' AND tis.status=1
            ";
        }

        $res = DB::connection('srsbi')->select($q);

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
                    FROM dbo.admiseciso_assets_sub ass
                    LEFT JOIN ( 
                        select count(1) total, stis.assets_id
                            from dbo.admiseciso_transaction stis where stis.disable=0 and stis.status=1";
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
                    FROM dbo.admiseciso_assets_sub ass
                    LEFT JOIN ( 
                        select count(1) total, stis.assets_id
                            from dbo.admiseciso_transaction stis
                            where year(stis.event_date)='$year_now' and stis.disable=0 and stis.status=1
                        group by stis.assets_id 
                    ) tis on tis.assets_id=ass.id 
                WHERE ass.assets_categ_id=1
                ORDER BY tis.total DESC
            ";
        }

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    public static function grapDetailAssets($req, $sub_name)
    {
        $area = $req->input('area_fil', true);
        $year = $req->input('year_fil', true);
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil', true);
        $id = $req->input('id_fil', true);

        $q = "
            WITH months(MonthNum) AS
            (
                SELECT 1
                UNION ALL
                SELECT MonthNum+1 
                    FROM months
                WHERE MonthNum < 12
            )
            SELECT m.MonthNum month_num ,count(t.id) total
                FROM months m
                LEFT OUTER JOIN (
                    select str.id ,str.event_date ,str.area_id
                        from dbo.admiseciso_transaction str
                        where str.".$sub_name."=( select top 1 id from dbo.admiseciso_assets_sub where id=$id ) and str.disable=? and str.status=?
                    group by str.id ,str.event_date ,str.area_id
                ) AS t ON MONTH(t.event_date)=m.MonthNum ";
                if(!empty($area) || !empty($year)) $q .= ' AND ';
                if(!empty($area)) $q .= " t.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " year(t.event_date)=$year ";
        $q .= " GROUP BY m.MonthNum ";
        // where trim(lower(title))=trim(lower('".$label."')) )

        $res = DB::connection('srsbi')->select($q, [0,1]);

        return $res;
    }

    public static function grapDetailAssetsSub($req, $sub_name)
    {
        $area = $req->input('area_fil', true);
        $year = $req->input('year_fil', true);
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil', true);
        $label = $req->input('label_fil', true);
        $id = $req->input('id_fil', true);

        $q = "
            SELECT rsu.id ,rsu.title ,ISNULL(t.total,0) total
                FROM dbo.admiseciso_assets_sub rsu
                LEFT OUTER JOIN (
                    SELECT count(1) total ,atr.".$sub_name."
                        from dbo.admiseciso_transaction atr 
                        where atr.disable=? AND atr.status=?";
                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " atr.area_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(atr.event_date)=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(atr.event_date)=$month ";
                    $q .= "group by atr.".$sub_name."
                ) t ON t.".$sub_name."=rsu.id
            WHERE rsu.assets_categ_id=(select top 1 assets_categtarget_id from dbo.admiseciso_assets_sub where id=$id)
            GROUP BY rsu.id ,rsu.title ,t.total
            ORDER BY t.total DESC
            ";
            // lower(title)=lower('".$label."'))

        $res = DB::connection('srsbi')->select($q, [0,1]);

        return $res;
    }

    public static function grap_srs($req)
    {
        $area = $req->input('area_fil');
        $year = $req->input('year_fil');
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_fil');
        
        $q = "SELECT FORMAT(COALESCE((COALESCE(max(arl.[level]),0) * 0.2) + (COALESCE(max(iml.impact_level),0) * 0.8),0),'N2') max_iso
                from dbo.admiseciso_transaction tio
                inner join dbo.admiseciso_risk_level arl ON arl.id=tio.risk_level_id 
                inner join (
                    select siml.area_id, siml.impact_level ,siml.status ,siml.disable ,siml.event_date
                        from dbo.admiseciso_transaction siml
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

        $res = DB::connection('srsbi')->select($q);

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
                FROM dbo.admisecsoi_transaction soi
            WHERE soi.disable=0 and soi.status=1
            ";
        if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
        if(!empty($area)) $q .= " soi.area_id=$area ";
        if(!empty($area) && !empty($year)) $q .= ' AND ';
        if(!empty($year)) $q .= " soi.year='$year' ";
        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
        if(!empty($month)) $q .= " soi.month='$month' ";

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    public static function grapTrendSoi($req)
    {
        $area = $req->input('area_fil', true);
        $year = $req->input('year_fil', true);
        $year = empty($year) ? date('Y') : $year;

        $q = "
            WITH months(MonthsNum) AS
            (
                SELECT 1
                UNION ALL
                SELECT MonthsNum+1 
                    FROM months
                WHERE MonthsNum < 12
            )
            SELECT m.MonthsNum month_num 
                    ,FORMAT((ISNULL(max(maxlevel),0) * 0.2 + ISNULL(max(maxiso),0) * 0.8),'N2') maxiso
                    ,FORMAT(COALESCE(( AVG(people) + AVG(device) + AVG([system]) +
                            + AVG(network) ) / 4 , 0),'N2') avgsoi
                FROM months m
                LEFT OUTER JOIN (
                    SELECT tio.event_date ,arl.[level] maxlevel ,iml.impact_level maxiso
                    FROM admiseciso_transaction tio
                        inner join dbo.admiseciso_risk_level arl ON arl.id=tio.risk_level_id 
                        inner join (
                            select siml.impact_level ,siml.status ,siml.disable ,siml.event_date
                                from admiseciso_transaction siml
                            group by siml.impact_level ,siml.status ,siml.disable ,siml.event_date
                        ) iml on iml.status=tio.status AND iml.disable=tio.disable 
                        AND iml.event_date=tio.event_date
                    WHERE tio.disable=0 AND tio.status=1 ";

                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " tio.area_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(tio.event_date)=$year ";

                    $q .=" GROUP BY tio.event_date ,arl.[level] ,iml.impact_level
                ) AS i ON year(i.event_date)=$year and month(i.event_date)=MonthsNum
                LEFT OUTER JOIN (
                    select soi.[year] ,soi.[month] ,soi.people ,soi.device ,soi.[system] ,soi.network
                        from admisecsoi_transaction soi
                        where soi.disable=0 AND soi.status=1 ";

                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " soi.area_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " soi.[year]=$year ";

                    $q .= "group by soi.[year] ,soi.[month] ,soi.people ,soi.device ,soi.[system] ,soi.network
                ) AS s ON s.[year]=$year and s.[month]=MonthsNum
            GROUP BY m.MonthsNum 
            ORDER BY m.MonthsNum
        ";

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    public static function grapTopIndex($req)
    {
        $area = $req->input('area_fil', true);
        $year = $req->input('year_fil', true);
        $year = $year ? $year : date('Y');
        $month = $req->input('month_fil', true);
        $month = date("n", strtotime($month));

        $q = "
            SELECT rso.id, rso.title, ISNULL(tis.total, 0) total
                ,case 
                    when rso.type_source is null 
                    then (select type_source from dbo.admiseciso_risksource_sub where id=tis.risksource_sub1_id)
                    else rso.type_source
                    end as type_source
                FROM dbo.admiseciso_risksource_sub rso
                left join ( 
                    select count(1) total, stis.risk_source_id ,stis.risksource_sub1_id
                        from dbo.admiseciso_transaction stis WHERE stis.status=1 and stis.disable=0 ";
                        if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                        if(!empty($area)) $q .= " stis.area_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(stis.event_date)=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(stis.event_date)=$month ";
                    $q .= " group by stis.risk_source_id ,stis.risksource_sub1_id
                ) tis on tis.risk_source_id=rso.id 
            WHERE rso.risksource_categ_id=1
            GROUP BY rso.id ,rso.title ,tis.risksource_sub1_id ,rso.type_source ,total
            ORDER BY tis.total DESC
        ";

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }
    
    public function grapRisksourceSoi()
    {
        $area = $req->input('area_fil', true);
        $year = $req->input('year_fil', true);
        $year = $year ? $year : date('Y');
        $month = $req->input('month_fil', true);

        $q = "
            SELECT rso.id, rso.type_source, rso.title, ISNULL(tis.total, 0) total
                FROM admiseciso_risksource_sub rso
                left join ( 
                    select count(1) total, stis.risk_source_id
                        from admiseciso_transaction stis WHERE stis.status=1 and stis.disable=0";
                        if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                        if(!empty($area)) $q .= " stis.area_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(stis.event_date)=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(stis.event_date)=$month ";
                    $q .= " group by stis.risk_source_id
                ) tis on tis.risk_source_id=rso.id 
            WHERE rso.risksource_categ_id=1
            ORDER BY tis.total DESC
        ";

        $res = DB::connection('srsbi')->select($q);

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
                        FROM dbo.admisecsoi_transaction str
                        where str.disable=0 and str.status=1
                    group by str.[month] ,str.[year] ,str.area_id
                ) AS tra ON tra.[month]=m.MonthNum";
                if(!empty($area) || !empty($year)) $q .= ' AND ';
                if(!empty($area)) $q .= " tra.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " tra.year=$year ";
        $q .= " GROUP BY m.MonthNum ";

        $res = DB::connection('srsbi')->select($q);

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
                    FROM dbo.admisecsoi_transaction stis 
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
                    FROM dbo.admisecsoi_transaction stis 
                WHERE stis.disable=0 AND stis.status=1 and stis.[year]='$year_now'
            ";
        }

        $res = DB::connection('srsbi')->select($q);

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
                        from dbo.admiseciso_area_sub aas
                    group by aas.area_categ_id ,aas.title ,aas.id 
                ) AS ara ON ara.area_categ_id=1
                LEFT JOIN (
                    select sotr.[year] ,sotr.[month] ,sotr.area_id, ( AVG(sotr.people) + AVG(sotr.device) 
                            + AVG(sotr.[system]) + AVG(sotr.network) ) / 4 total
                        from dbo.admisecsoi_transaction sotr
                    group by sotr.[year] ,sotr.[month] ,sotr.area_id
                ) sotr ON sotr.year=$year AND sotr.area_id=ara.id AND sotr.[month]=m.MonthNum GROUP BY m.MonthNum ,ara.title ,ara.id ORDER BY m.MonthNum ASC";

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }
}
