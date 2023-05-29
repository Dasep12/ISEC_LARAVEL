<?php

namespace Modules\GuardTour\Entities\api_b;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\Users;

class PatroliModels extends Model
{
    use HasFactory;

    protected $fillable = ['npk', 'name', 'password', 'admisecsgp_mstroleusr_role_id', 'admisecsgp_mstplant_plant_id', 'admisecsgp_mstcmp_company_id', 'admisecsgp_mstsite_site_id', 'others', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'email', 'patrol_group', 'user_name'];
    protected $table = "admisecsgp_mstusr";
    protected $primaryKey = 'npk';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\Api\AuthModelsFactory::new();
    }

    public static function getZonaPatroli($date, $plant, $shift)
    {
        return  DB::table('admisecsgp_trans_zona_patroli as zp')
            ->join('admisecsgp_mstzone as z', 'z.zone_id', 'zp.admisecsgp_mstzone_zone_id')
            ->join('admisecsgp_mstshift as s', 's.shift_id', 'zp.admisecsgp_mstshift_shift_id')
            ->join('admisecsgp_mstplant as p', 'p.plant_id', 'zp.admisecsgp_mstplant_plant_id')
            ->join('admisecsgp_mstproduction as pr', 'pr.produksi_id', 'zp.admisecsgp_mstproduction_produksi_id')
            ->where([
                ['zp.date_patroli', '=', $date],
                ['zp.admisecsgp_mstshift_shift_id', '=', $shift],
                ['zp.admisecsgp_mstplant_plant_id', '=', $plant],
                ['zp.status_zona', '=', 1]
            ])
            ->select('z.zone_id as zona_id', 'zp.date_patroli', 'p.plant_name as plant', 'z.zone_name', 's.nama_shift as shift',  's.shift_id', 'pr.name as stat_produksi', 'zp.status_zona');
    }

    public static function getCheckpointPatroli($date, $plant, $shift)
    {
        return  DB::table('admisecsgp_trans_zona_patroli as zp')
            ->join('admisecsgp_mstzone as z', 'z.zone_id', 'zp.admisecsgp_mstzone_zone_id')
            ->join('admisecsgp_mstshift as s', 's.shift_id', 'zp.admisecsgp_mstshift_shift_id')
            ->join('admisecsgp_mstplant as p', 'p.plant_id', 'zp.admisecsgp_mstplant_plant_id')
            ->join('admisecsgp_mstckp as c', 'c.admisecsgp_mstzone_zone_id', 'z.zone_id')
            ->where([
                ['zp.date_patroli', '=', $date],
                ['zp.admisecsgp_mstshift_shift_id', '=', $shift],
                ['zp.admisecsgp_mstplant_plant_id', '=', $plant],
                ['zp.status_zona', '=', 1]
            ])
            ->select('c.checkpoint_id', 'c.check_no', 'c.check_name', 'c.check_no as no_nfc', 'zp.admisecsgp_mstzone_zone_id as id_zona');
    }

    public static function getObjekPatroli($plant)
    {
        return DB::select("SELECT  ob.objek_id , ob.nama_objek , ob.admisecsgp_mstckp_checkpoint_id AS id_checkpoint  ,
        (SELECT COUNT(1) FROM admisecsgp_trans_details 
                    WHERE status_temuan = 0 AND admisecsgp_mstobj_objek_id = ob.objek_id 
                ) AS temuan_status 
        
        FROM  admisecsgp_mstobj  ob 
        LEFT JOIN admisecsgp_mstckp ck ON  ob.admisecsgp_mstckp_checkpoint_id = ck.checkpoint_id 
        LEFT JOIN admisecsgp_mstzone zn  ON ck.admisecsgp_mstzone_zone_id = zn.zone_id 
        LEFT JOIN admisecsgp_mstplant pl ON  zn.admisecsgp_mstplant_plant_id = pl.plant_id
        LEFT JOIN admisecsgp_trans_details dtls ON dtls.admisecsgp_mstobj_objek_id = ob.objek_id
        WHERE pl.plant_id = '" . $plant . "'  AND
         ck.status  = 1 AND 
        ob.status = 1 AND 
        zn.status = 1 AND 
        pl.status = 1 
            GROUP BY ob.objek_id ,ob.nama_objek ,ob.admisecsgp_mstckp_checkpoint_id 
            ORDER BY temuan_status DESC");
    }

    public static function getEventPatroli($plant)
    {
        return DB::select("SELECT ob.objek_id as id_objek , ob.nama_objek   ,ev.event_name  , ev.event_id as id_event , kobj.kategori_name  ,
        kobj.kategori_id  as id_kategori
          FROM admisecsgp_mstevent ev 
          LEFT JOIN admisecsgp_mstkobj kobj ON kobj.kategori_id  = ev.admisecsgp_mstkobj_kategori_id 
          LEFT JOIN admisecsgp_mstobj ob ON ob.admisecsgp_mstkobj_kategori_id  = kobj.kategori_id 
          LEFT JOIN admisecsgp_mstckp ckp ON ckp.checkpoint_id  = ob.admisecsgp_mstckp_checkpoint_id 
          LEFT JOIN admisecsgp_mstzone zn ON zn.zone_id  = ckp.admisecsgp_mstzone_zone_id 
          LEFT JOIN admisecsgp_mstplant pl ON pl.plant_id  = zn.admisecsgp_mstplant_plant_id 
        WHERE 
         pl.plant_id  = '" . $plant . "'  AND 
         ev.status  = 1 
         ORDER BY ob.nama_objek  ASC");
    }

    public static function getTemuan($plant_id, $zona_id)
    {
        $query = DB::select("SELECT hds.trans_header_id  as id , hds.date_patroli AS tanggal , zn.zone_name AS zona , ck.check_name  ,
        ob.nama_objek AS objek ,
        ev.event_name AS event , dtl.image_1 , dtl.image_2 , dtl.image_3 , dtl.description
        FROM admisecsgp_trans_headers hds , admisecsgp_trans_details dtl ,
        admisecsgp_mstplant pl , admisecsgp_mstzone zn , admisecsgp_mstckp ck , admisecsgp_mstobj ob ,
        admisecsgp_mstevent ev
        WHERE
        hds.trans_header_id  = dtl.admisecsgp_trans_headers_trans_headers_id  
        AND dtl.status_temuan = 0 
        -- AND dtl.laporkan_pic  = 1 
        AND hds.admisecsgp_mstzone_zone_id  = zn.zone_id 
        AND zn.admisecsgp_mstplant_plant_id = pl.plant_id 
        AND hds.admisecsgp_mstckp_checkpoint_id  = ck.checkpoint_id
        AND pl.plant_id = '" . $plant_id . "' 
        AND hds.admisecsgp_mstzone_zone_id = '" . $zona_id . "' 
        AND dtl.admisecsgp_mstobj_objek_id  = ob.objek_id 
        AND ev.admisecsgp_mstkobj_kategori_id  = ob.admisecsgp_mstkobj_kategori_id 
        AND ev.event_id = dtl.admisecsgp_mstevent_event_id 
        ");
        return $query;
    }


    public static function showPersentase($plant_id, $date, $shift_id, $tipe_patrol)
    {

        $query = DB::select("
            SELECT count(1) total_ckp_f, tp.total_ckp_p, (count(1) * 100 / tp.total_ckp_p ) persentase
                from admisecsgp_trans_headers ath
                inner join (
                    select count(sckp.checkpoint_id) total_ckp_p, szn.date_patroli, szn.admisecsgp_mstshift_shift_id, 
                        szn.admisecsgp_mstplant_plant_id 
                        from admisecsgp_trans_zona_patroli szn 
                        inner join admisecsgp_mstckp sckp on szn.admisecsgp_mstzone_zone_id=sckp.admisecsgp_mstzone_zone_id
                    where szn.status=1 and szn.status_zona=1 and sckp.status=1
                    group by szn.date_patroli, szn.admisecsgp_mstshift_shift_id, szn.admisecsgp_mstplant_plant_id
                ) tp on tp.date_patroli=ath.date_patroli and tp.admisecsgp_mstshift_shift_id=ath.admisecsgp_mstshift_shift_id 
            where ath.date_patroli='" . $date . "' and ath.admisecsgp_mstshift_shift_id='" . $shift_id . "' 
                and tp.admisecsgp_mstplant_plant_id='" . $plant_id . "' and ath.type_patrol=$tipe_patrol
            group by tp.total_ckp_p
        ");

        return $query;
    }
}
