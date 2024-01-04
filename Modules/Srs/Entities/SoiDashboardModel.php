<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use AuthHelper;

class SoiDashboardModel extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\SoiDashboardModelFactory::new();
    }

    public static function area()
    {
        $user_npk = AuthHelper::user_npk();
        $user_wilayah = AuthHelper::user_wilayah();
        
        $q = "SELECT id, title 
                    FROM admiseciso_area_sub 
                WHERE area_categ_id='1' AND status=1";
        
        // if(AuthHelper::is_author('ALLAREA'))
        // {
        //     $q .= " AND wil_id='$user_wilayah'";
        // }
        
        // if(AuthHelper::is_section_head() || AuthHelper::is_building_manager())
        // {
            // $q .= " AND id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
            // INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
            // INNER JOIN admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
            // WHERE aau.npk=$user_npk)";

            $q .= " AND id IN (
                SELECT ajp.area_id from isecurity.dbo.admisec_area_users aau
                    INNER JOIN dbo.admisec_area_join_plant ajp ON aau.plant_id=ajp.plant_id 
                WHERE aau.npk=$npk)";
        // }

        $q .= " ORDER BY title ASC";
        
        $res = DB::connection('srsbi')->select($q, [1,1]);
        return $res;
    }

    public static function soiAvgPilar($req)
    {
        $npk = AuthHelper::user_npk();

        if($req->isMethod('post'))
        {
            $area = $req->input('area_filter', true);
            $year = $req->input('year_filter', true);
            $month = $req->input('month_filter', true);

            $q = "
                SELECT FORMAT(ISNULL(AVG(stis.people), 0), 'N2') avg_people ,FORMAT(ISNULL(AVG(stis.[system]), 0), 'N2') avg_system
                    ,FORMAT(ISNULL(AVG(stis.[device]), 0), 'N2') avg_device, FORMAT(ISNULL(AVG(stis.[network]), 0), 'N2') avg_network
                    FROM admisecsoi_transaction stis 
                WHERE stis.disable=0 AND stis.status=1";

                // $q .= " AND stis.area_id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
                // INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
                // INNER JOIN admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
                // WHERE aau.npk=$npk)";
                
                $q .= " AND stis.area_id IN (
                    SELECT ajp.area_id from isecurity.dbo.admisec_area_users aau
                        INNER JOIN dbo.admisec_area_join_plant ajp ON aau.plant_id=ajp.plant_id 
                    WHERE aau.npk=$npk)";

                if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                if(!empty($area)) $q .= " stis.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
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
                    FROM admisecsoi_transaction stis 
                WHERE stis.disable=0 AND stis.status=1 and stis.[year]='$year_now'
            ";

            // $q .= " AND stis.area_id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
            // INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
            // INNER JOIN admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
            // WHERE aau.npk=$npk)";
                
            $q .= " AND stis.area_id IN (
                SELECT ajp.area_id from isecurity.dbo.admisec_area_users aau
                    INNER JOIN dbo.admisec_area_join_plant ajp ON aau.plant_id=ajp.plant_id 
                WHERE aau.npk=$npk)";
        }

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }

    public static function threatSoi($req)
    {
        $area = $req->input('area_filter', true);
        $year = $req->input('year_filter', true);
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_filter', true);
        $npk = AuthHelper::user_npk();

        $q = "
            SELECT s.avg_soi ,i.max_iso
            FROM 
            (
                SELECT FORMAT(COALESCE(( AVG(soi.people) + AVG(soi.device) + AVG(soi.[system]) +
                    + AVG(soi.network) ) / 4 , 0 ), 'N2') avg_soi
                    FROM dbo.admisecsoi_transaction soi
                WHERE soi.disable=0 and soi.status=1
            ";

                // $q .= " AND soi.area_id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
                // INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
                // INNER JOIN admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
                // WHERE aau.npk=$npk)";
                
                $q .= " AND soi.area_id IN (
                    SELECT ajp.area_id from isecurity.dbo.admisec_area_users aau
                        INNER JOIN dbo.admisec_area_join_plant ajp ON aau.plant_id=ajp.plant_id 
                    WHERE aau.npk=$npk)";

                if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                if(!empty($area)) $q .= " soi.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " soi.year=$year ";
                if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                if(!empty($month)) $q .= " soi.month=$month ";

            $q .= ") AS s
            ,(
                SELECT FORMAT(COALESCE((COALESCE(max(arl.[level]),0) * 0.2) + 
                        (COALESCE(max(iml.impact_level),0) * 0.8),0),'N2') max_iso
                    from dbo.admiseciso_transaction tio
                    inner join admiseciso_risk_level arl ON arl.id=tio.risk_level_id 
                    inner join (
                        select siml.area_id, siml.impact_level ,siml.status ,siml.disable ,siml.event_date
                            from dbo.admiseciso_transaction siml
                        group by siml.area_id, siml.impact_level ,siml.status ,siml.disable ,siml.event_date
                    ) iml on iml.area_id=tio.area_id and iml.status=tio.status AND iml.disable=tio.disable AND iml.event_date=tio.event_date 
                WHERE tio.disable=0 AND tio.status=1 ";

                // $q .= " AND tio.area_id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
                // INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
                // INNER JOIN admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
                // WHERE aau.npk=$npk)";

                $q .= " AND tio.area_id IN (
                    SELECT ajp.area_id from isecurity.dbo.admisec_area_users aau
                        INNER JOIN dbo.admisec_area_join_plant ajp ON aau.plant_id=ajp.plant_id 
                    WHERE aau.npk=$npk)";

                if(!empty($area) || !empty($year) || !empty($month)) $q .= ' AND ';
                if(!empty($area)) $q .= " tio.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " year(tio.event_date)=$year ";
                if((!empty($area) || !empty($year)) && !empty($month)) $q .= ' AND ';
                if(!empty($month)) $q .= " month(tio.event_date)=$month ";

            $q .= ") AS i
        ";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }

    public static function soiAvgMonth($req)
    {
        $area = $req->input('area_filter', true);
        $year = $req->input('year_filter', true);
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_filter', true);
        $label = $req->input('label_fil', true);
        $npk = AuthHelper::user_npk();

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
                        FROM admisecsoi_transaction str
                        where str.disable=0 and str.status=1 
                        group by str.[month] ,str.[year] ,str.area_id
                ) AS tra ON tra.[month]=m.MonthNum";
                
                // $q .= " AND tra.area_id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
                // INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
                // INNER JOIN admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
                // WHERE aau.npk=$npk)";

                $q .= " AND tra.area_id IN (
                    SELECT ajp.area_id from isecurity.dbo.admisec_area_users aau
                        INNER JOIN dbo.admisec_area_join_plant ajp ON aau.plant_id=ajp.plant_id 
                    WHERE aau.npk=$npk)";


                if(!empty($area) || !empty($year)) $q .= ' AND ';
                if(!empty($area)) $q .= " tra.area_id=$area ";
                if(!empty($area) && !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " tra.year=$year ";
        $q .= " GROUP BY m.MonthNum ";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
    

    public static function soiAvgAreaMonth($req)
    {
        $area = $req->input('area_filter', true);
        $year = $req->input('year_filter', true);
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_filter', true);
        $npk = AuthHelper::user_npk();

        $q = "
            WITH months(MonthsNum) AS
            (
                SELECT 1
                UNION ALL
                SELECT MonthsNum+1 
                    FROM months
                WHERE MonthsNum < 12
            )
            SELECT m.MonthsNum month_num ,area.title area
                    ,FORMAT(COALESCE(( AVG(people) + AVG(device) + AVG([system]) +
                            + AVG(network) ) / 4 , 0),'N2') avgsoi
                FROM months m
                INNER JOIN admiseciso_area_sub area on area.area_categ_id=1 and (area.id != 29";

                // $q .= " AND area.id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
                //     INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
                //     INNER JOIN admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
                //     WHERE aau.npk=$npk))";

                $q .= " AND area.id IN (
                    SELECT ajp.area_id from isecurity.dbo.admisec_area_users aau
                        INNER JOIN dbo.admisec_area_join_plant ajp ON aau.plant_id=ajp.plant_id 
                    WHERE aau.npk=$npk))";

                $q .= "LEFT OUTER JOIN (
                    select soi.[year] ,soi.[month] ,soi.area_id ,soi.people ,soi.device ,soi.[system] ,soi.network
                        from admisecsoi_transaction soi
                        where soi.disable=0 AND soi.status=1
                        group by soi.[year] ,soi.[month] ,soi.area_id ,soi.people ,soi.device ,soi.[system] ,soi.network
                ) AS s ON s.area_id=area.id AND s.[month]=MonthsNum 
            ";

                if(!empty($area) || !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " s.[year]=$year ";

        $q .= "  
                GROUP BY m.MonthsNum ,area.title
                ORDER BY m.MonthsNum
            ";
            
        $res = DB::connection('srsbi')->select($q);
        return $res;
    }

    public static function soiAvgAreaPillar($req)
    {
        $area = $req->input('area_filter', true);
        $year = $req->input('year_filter', true);
        $year = empty($year) ? date('Y') : $year;
        $month = $req->input('month_filter', true);
        $npk = AuthHelper::user_npk();

        $q = "
                SELECT area.title area
                    ,FORMAT(AVG(COALESCE(people,0)),'N2') peoples
                    ,FORMAT(AVG(COALESCE(device,0)),'N2') devices
                    ,FORMAT(AVG(COALESCE(network,0)),'N2') networks
                    ,FORMAT(AVG(COALESCE([system],0)),'N2') systems
                    FROM dbo.admiseciso_area_sub area
                    LEFT OUTER JOIN (
                        select soi.[year] ,soi.[month] ,soi.area_id ,soi.people ,soi.device ,soi.[system] ,soi.network
                            from dbo.admisecsoi_transaction soi
                            where soi.disable=0 AND soi.status=1
                        group by soi.[year] ,soi.[month] ,soi.area_id ,soi.people ,soi.device ,soi.[system] ,soi.network
                    ) AS s ON s.area_id=area.id 
                WHERE s.[year]=$year AND area.area_categ_id=1 AND area.id != 29
                --  AND s.[month]=MonthsNum
            ";

                $q .= " AND area.id IN (select aas.id from isecurity.dbo.admisec_area_users aau 
                    INNER JOIN isecurity.dbo.admisecsgp_mstsite ams ON ams.site_id=aau.site_id 
                    INNER JOIN admiseciso_area_sub aas ON aas.wil_id=ams.id_wilayah 
                    WHERE aau.npk=$npk)";

                if(!empty($area) || !empty($year)) $q .= ' AND ';
                if(!empty($year)) $q .= " s.[year]=$year ";

        $q .= "
                GROUP BY area.title
            ";

        $res = DB::connection('srsbi')->select($q);
        return $res;
    }
}