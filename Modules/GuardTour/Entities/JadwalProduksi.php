<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class JadwalProduksi extends Model
{
    use HasFactory;

    protected $fillable = ['id_zona_patroli', 'date_patroli', 'admisecsgp_mstplant_plant_id', 'admisecsgp_mstzone_zone_id', 'admisecsgp_mstshift_shift_id', 'admisecsgp_mstproduction_produksi_id', 'status', 'status_zona', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_trans_zona_patroli";
    protected $primaryKey = 'id_zona_patroli';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }


    public static function  cekJadwalProduksi($date, $plant)
    {
        return DB::table('admisecsgp_trans_zona_patroli as zp')
            ->where(
                [
                    [DB::raw("(FORMAT(date_patroli,'yyyy-MM'))"), '=', $date],
                    ['zp.admisecsgp_mstplant_plant_id', '=', $plant]
                ]
            )
            ->select('zp.date_patroli')
            ->first();
    }

    public static function headerJadwalProduksi($date, $plant)
    {
        return DB::table('admisecsgp_trans_zona_patroli as zp')
            ->join('admisecsgp_mstplant as p', 'p.plant_id', 'zp.admisecsgp_mstplant_plant_id')
            ->join('admisecsgp_mstzone as z', 'z.zone_id', 'zp.admisecsgp_mstzone_zone_id')
            ->join('admisecsgp_mstshift as s', 's.shift_id', 'zp.admisecsgp_mstshift_shift_id')
            ->where([
                [DB::raw("(FORMAT(zp.date_patroli,'yyyy-MM'))"), '=', $date],
                ['zp.admisecsgp_mstplant_plant_id', '=', $plant],
            ])
            ->select('p.plant_name as plant', 'zp.admisecsgp_mstplant_plant_id as plant_id', 'z.zone_name as zone', 'zp.admisecsgp_mstzone_zone_id as zona_id', 's.nama_shift as shift', 'zp.admisecsgp_mstshift_shift_id as shift_id')
            ->groupBy('p.plant_name', 'zp.admisecsgp_mstplant_plant_id', 'z.zone_name', 'zp.admisecsgp_mstzone_zone_id', 's.nama_shift', 'zp.admisecsgp_mstshift_shift_id')
            ->orderBy('zp.admisecsgp_mstshift_shift_id', 'asc')
            ->get();
    }

    public static function jadwalProduksi($date, $plant, $zona, $shift)
    {
        return  DB::select("SELECT jp.id_zona_patroli as id, jp.date_patroli AS tanggal , zn.zone_name  ,  sh.nama_shift ,jp.status_zona
          FROM admisecsgp_trans_zona_patroli jp , admisecsgp_mstshift sh  , 
        admisecsgp_mstzone zn 
        WHERE  jp.admisecsgp_mstshift_shift_id = sh.shift_id AND zn.zone_id = admisecsgp_mstzone_zone_id AND jp.admisecsgp_mstplant_plant_id = '" . $plant . "' AND admisecsgp_mstzone_zone_id = '" . $zona . "' AND jp.admisecsgp_mstshift_shift_id = '" . $shift . "'
        AND jp.admisecsgp_mstshift_shift_id = sh.shift_id AND  
        jp.date_patroli = '" . $date . "' and jp.status = 1 ");
    }
}
