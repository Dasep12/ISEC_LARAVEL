<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use AuthHelper;

class OsintDashboardModel extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\OsintDashboardModelFactory::new();
    }
    
    public static function getDataAllOsint($req)
    {
        $area = $req->input('area');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;

        $q = "DECLARE @date DATE = GETDATE()
            ;WITH MonthsCTE AS (
                SELECT 1 [Month], DATEADD(DAY, -DATEPART(DAY, @date)+1, @date) as 'MonthStart'
                UNION ALL
                SELECT [Month] + 1, DATEADD(MONTH, 1, MonthStart)
                FROM MonthsCTE 
                WHERE [Month] < 12 )

            SELECT Month ,
            (select count(at2.id) from admisecosint_transaction at2 
            where at2.status=1 AND MONTH(at2.date) = Month ";

        if(!empty($year)) $q .= " AND year(at2.date)=$year ";

        $q .= " 
            ) as total
            FROM MonthsCTE";

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    public static function getArea($req)
    {
        $year = $req->input('year');

        $q = "
            SELECT shd.id ,shd.title ,(select count(at2.media_id) from admisecosint_transaction at2 
                where at2.plant_id = shd.id ";

                if(!empty($year)) $q .= " AND year(at2.date)= $year ";

            $q .= " ) as total 
            FROM admiseciso_area_sub shd
            WHERE shd.area_categ_id = 1 and shd.status=1
        ";

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }
    
    public static function detailEventList($req)
    {
        $area = $req->input('area');
        $year = $req->input('year');
        $year = $year ? $year : date('Y');
        $month = $req->input('month');
        $sub_risk_source = $req->input('sub_risk_source');
        $risksource_sub1_id = $req->input('risksource_sub1_id');
        $risksource_sub2_id = $req->input('risksource_sub2_id');
        $target_issue_id = $req->input('target_issue_id');
        $sub_target_issue1_id = $req->input('sub_target_issue1_id');
        $sub_target_issue2_id = $req->input('sub_target_issue2_id');
        $negative_sentiment_id = $req->input('negative_sentiment_id');
        $media_id = $req->input('media_id');
        $sub_media_id = $req->input('sub_media_id');
        $format_id = $req->input('format_id');
        $risk_id = $req->input('risk_id');
        $risk_sub1_id = $req->input('risk_sub1_id');
        $risk_sub2_id = $req->input('risk_sub2_id');

        $q = "
            SELECT trs.id ,trs.activity_name event_name ,trs.[date] event_date
                FROM dbo.admisecosint_transaction trs
            WHERE trs.status=1";

            // RISK SOURCE
            if(!empty($sub_risk_source) || !empty($risksource_sub1_id) || !empty($risksource_sub2_id)) $q .= ' AND ';
            if(!empty($sub_risk_source)) $q .= "trs.sub_risk_source=$sub_risk_source ";
            if(!empty($risksource_sub1_id)) $q .= "trs.risksource_sub1_id=$risksource_sub1_id ";
            if(!empty($risksource_sub2_id)) $q .= "trs.risksource_sub2_id=$risksource_sub2_id ";
            // RISK SOURCE            

            // TARGET ASSET
            if(!empty($target_issue_id) || !empty($sub_target_issue1_id) || !empty($sub_target_issue2_id)) $q .= ' AND ';
            if(!empty($target_issue_id)) $q .= "trs.target_issue_id=$target_issue_id ";
            if(!empty($sub_target_issue1_id)) $q .= "trs.sub_target_issue1_id=$sub_target_issue1_id ";
            if(!empty($sub_target_issue2_id)) $q .= "trs.sub_target_issue2_id=$sub_target_issue2_id ";
            // TARGET ASSET //

            // NEGATIVE SENTIMENT
            if(!empty($negative_sentiment_id)) $q .= ' AND ';
            if(!empty($negative_sentiment_id)) $q .= "trs.hatespeech_type_id=$negative_sentiment_id ";
            // NEGATIVE SENTIMENT //

            // MEDIA
            if(!empty($media_id) || !empty($sub_media_id)) $q .= ' AND ';
            if(!empty($media_id)) $q .= "trs.media_id=$media_id ";
            if(!empty($sub_media_id)) $q .= "trs.sub_media_id=$sub_media_id ";
            // MEDIA //

            // FORMAT
            if(!empty($format_id) || !empty($format_id)) $q .= ' AND ';
            if(!empty($format_id)) $q .= "trs.format_id=$format_id ";
            // FORMAT //

            // RISK
            if(!empty($risk_id) || !empty($risk_sub1_id) || !empty($risk_sub2_id) || !empty($risk_sub3_id)) $q .= ' AND ';
            if(!empty($risk_id)) $q .= "trs.risk_id=$risk_id ";
            if(!empty($risk_sub1_id)) $q .= "trs.risk_sub1_id=$risk_sub1_id ";
            if(!empty($risk_sub2_id)) $q .= "trs.risk_sub2_id=$risk_sub2_id ";
            if(!empty($risk_sub3_id)) $q .= "trs.risk_sub3_id=$risk_sub3_id ";
            // RISK //

            if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
            if(!empty($area)) $q .= " trs.plant_id=$area ";
            if(!empty($area) && !empty($year)) $q .= ' AND ';
            if(!empty($year)) $q .= " year(trs.[date])=$year ";
            if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
            if(!empty($month)) $q .= " month(trs.[date])=$month ";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
    
    public static function getInternalSource($req)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;

        $q = "SELECT shd.id ,shd.name  ,
        (select count(at2.sub_risk_source) from admisecosint_transaction at2 
        where at2.sub_risk_source  = shd.id  ";

            if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
            if(!empty($area)) $q .= " at2.area_id=$area ";
            if(!empty($area) && !empty($year)) $q .= ' AND ';
            if(!empty($year)) $q .= " year(at2.date)=$year ";
            if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
            if(!empty($month)) $q .= " month(at2.date)=$month ";

        $q .= " ) as total 
            from admisecosint_sub1_header_data shd
            where  shd.sub_header_data  = 7 
            order by total desc 
        ";
        
        $res = DB::connection('srsbi')->select($q);
        return $res;
    }

    public static function detailIntSourceSub1($req, $sub_name)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;
        $id = $req->input('id', true);

        $q = "
            SELECT shd.id ,shd.name ,ISNULL(t.total,0) total
            FROM dbo.admisecosint_sub2_header_data shd
            LEFT OUTER JOIN (
                select count(1) total ,atr.{$sub_name}
                    from dbo.admisecosint_transaction atr where atr.status=1";
                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " atr.plant_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(atr.[date])=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(atr.[date])=$month ";
                    $q .= "group by atr.{$sub_name}
                ) t ON t.{$sub_name}=shd.id 
            WHERE shd.sub1_header_id={$id}
            GROUP BY shd.id ,shd.name ,t.total
            ORDER BY total DESC";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
    
    public static function detailMonth($req, $sub_name)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;
        $id = $req->input('id', true);

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
                    select count(str.id) total ,str.{$sub_name} ,str.[date] ,str.plant_id ,str.status
                        from dbo.admisecosint_transaction str
                    group by str.id ,str.{$sub_name} ,str.[date] ,str.plant_id ,str.status
                ) AS t ON MONTH(t.[date])=m.MonthNum AND t.status=1";

                if(!empty($id)) $q .= ' AND ';
                if(!empty($id)) $q .= " t.{$sub_name}={$id} ";

                if(!empty($area) || !empty($year)) $q .= ' AND ';
                if(!empty($area)) $q .= " t.plant_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " year(t.[date])=$year ";

        $q .= "GROUP BY m.MonthNum, t.total ORDER BY m.MonthNum ASC";
        
        $res = DB::connection('srsbi')->select($q);
        return $res;
    }

    public static function getExternalSource($req)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;

        $q = "SELECT shd.id ,shd.name  ,
        (select count(at2.sub_risk_source) from admisecosint_transaction at2 
        where at2.sub_risk_source  = shd.id ";

            if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
            if(!empty($area)) $q .= " at2.area_id=$area ";
            if(!empty($area) && !empty($year)) $q .= ' AND ';
            if(!empty($year)) $q .= " year(at2.date)=$year ";
            if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
            if(!empty($month)) $q .= " month(at2.date)=$month ";

        $q .= " ) as total 
        from admisecosint_sub1_header_data shd
        where  shd.sub_header_data  = 8 
        order by total desc 
        ";
        
        $res = DB::connection('srsbi')->select($q);

        return $res;
    }
    
    public static function getTargetAssets($req)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;
        
        $q = "SELECT shd.sub_id ,shd.name  ,
            (select count(at2.target_issue_id) from admisecosint_transaction at2 
            where at2.target_issue_id  = shd.sub_id ";

                if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                if(!empty($area)) $q .= " at2.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " year(at2.date)=$year ";
                if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                if(!empty($month)) $q .= " month(at2.date)=$month ";

            $q .= " ) as total 
            from admisecosint_sub_header_data shd
            where  shd.header_data_id  = 2
            order by total desc";

        $res = DB::connection('srsbi')->select($q);

        return $res;
    }

    public static function detailSub1($req, $sub_name)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;
        $id = $req->input('id', true);

        $q = "
            SELECT shd.id ,shd.name ,ISNULL(t.total,0) total
            FROM dbo.admisecosint_sub1_header_data shd
            LEFT OUTER JOIN (
                select count(1) total ,atr.{$sub_name}
                    from dbo.admisecosint_transaction atr where atr.status=1";
                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " atr.plant_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(atr.[date])=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(atr.[date])=$month ";
                    $q .= "group by atr.{$sub_name}
                ) t ON t.{$sub_name}=shd.id 
            WHERE shd.sub_header_data={$id}
            GROUP BY shd.id ,shd.name ,t.total
            ORDER BY total DESC";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
    
    public static function detailSub2($req, $sub_name)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;
        $id = $req->input('id', true);

        $q = "
            SELECT shd.id ,shd.name ,ISNULL(t.total,0) total
            FROM dbo.admisecosint_sub2_header_data shd
            LEFT OUTER JOIN (
                select count(1) total ,atr.{$sub_name}
                    from dbo.admisecosint_transaction atr where atr.status=1";
                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " atr.plant_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(atr.[date])=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(atr.[date])=$month ";
                    $q .= "group by atr.{$sub_name}
                ) AS t ON t.{$sub_name}=shd.id 
            WHERE shd.sub1_header_id={$id}
            GROUP BY shd.id ,shd.name ,t.total
            ORDER BY total DESC";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
    
    public static function getNegativeSentiment($req)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;

        $q = "SELECT shd.sub_id id ,shd.name  ,
            (select count(1) from admisecosint_transaction at2 
            where at2.hatespeech_type_id = shd.sub_id ";

                if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                if(!empty($area)) $q .= " at2.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " year(at2.date)=$year ";
                if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                if(!empty($month)) $q .= " month(at2.date)=$month ";

            $q .= " ) as total 
            from admisecosint_sub_header_data shd
            where  shd.header_data_id  = 5
            order by total desc 
        ";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
    
    public static function getMedia($req)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;

        $q = "SELECT shd.sub_id id ,shd.name  ,
        (select count(at2.media_id) from admisecosint_transaction at2 
        where at2.media_id  = shd.sub_id ";

            if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
            if(!empty($area)) $q .= " at2.area_id=$area ";
            if(!empty($area) && !empty($year)) $q .= ' AND ';
            if(!empty($year)) $q .= " year(at2.date)=$year ";
            if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
            if(!empty($month)) $q .= " month(at2.date)=$month ";

        $q .= " ) as total 
        from admisecosint_sub_header_data shd
        where  shd.header_data_id  = 4 and shd.status=1
        order by total desc";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
    
    public static function getFormat($req)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;

        $q = "SELECT shd.sub_id id ,shd.name  ,
            (select count(at2.media_id) from admisecosint_transaction at2 
            where at2.format_id = shd.sub_id ";

            if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
            if(!empty($area)) $q .= " at2.area_id=$area ";
            if(!empty($area) && !empty($year)) $q .= ' AND ';
            if(!empty($year)) $q .= " year(at2.date)=$year ";
            if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
            if(!empty($month)) $q .= " month(at2.date)=$month ";

        $q .= " ) as total 
            from admisecosint_sub_header_data shd
            where shd.header_data_id = 12 and shd.status=1
            order by total desc";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }

    public static function detailFormatSub1($req, $sub_name)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
        $year = empty($year) ? date('Y') : $year;
        $id = $req->input('id', true);

        $q = "
            SELECT shd.id ,shd.name ,ISNULL(t.total,0) total
            FROM dbo.admisecosint_sub1_header_data shd
            LEFT OUTER JOIN (
                select count(1) total ,atr.{$sub_name}
                    from dbo.admisecosint_transaction atr where atr.status=1";
                        if(!empty($area) || !empty($year)) $q .= ' AND ';
                        if(!empty($area)) $q .= " atr.plant_id=$area ";
                        if(!empty($area) && !empty($year)) $q .= ' AND ';
                        if(!empty($year)) $q .= " year(atr.[date])=$year ";
                        if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                        if(!empty($month)) $q .= " month(atr.[date])=$month ";
                    $q .= "group by atr.{$sub_name}
                ) t ON t.{$sub_name}=shd.id 
            WHERE shd.sub_header_data={$id}
            GROUP BY shd.id ,shd.name ,t.total
            ORDER BY total DESC";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
    
    public static function totalLevelAvg($req)
    {
        $area = $req->input('area');
        $month = $req->input('month');
        $year = $req->input('year');
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
                ,FORMAT(AVG(COALESCE(s.total_level,0)),'N2') total_level_avg
                FROM months m
                LEFT OUTER JOIN (
                    select osi.[date] ,osi.total_level
                        from dbo.admisecosint_transaction osi
                        where osi.status=1
                    group by osi.[date] ,osi.total_level
                ) AS s ON month(s.[date])=MonthsNum ";

                if(!empty($year)) $q .= " AND year(s.[date])=$year ";

            $q .= " GROUP BY m.MonthsNum
            ORDER BY m.MonthsNum
        ";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }

}