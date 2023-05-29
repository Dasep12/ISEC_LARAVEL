<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class JadwalPatroli extends Model
{
    use HasFactory;

    protected $fillable = ['id_jadwal_patroli', 'date_patroli', 'admisecsgp_mstplant_plant_id', 'admisecsgp_mstusr_npk', 'admisecsgp_mstshift_shift_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_trans_jadwal_patroli";
    protected $primaryKey = 'id_jadwal_patroli';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }

    public static function  cekJadwalPatroli($date, $plant)
    {
        return DB::table('admisecsgp_trans_jadwal_patroli as jp')
            ->where(
                [
                    [DB::raw("(FORMAT(date_patroli,'yyyy-MM'))"), '=', $date],
                    ['jp.admisecsgp_mstplant_plant_id', '=', $plant]
                ]
            )
            ->select('jp.date_patroli')
            ->first();
    }

    public static function cekPetugasPatroli($npk, $nama, $plant)
    {
        return DB::table('admisecsgp_mstusr as u')
            ->where([
                ['u.npk', '=', $npk],
                ['u.name', '=', "$nama"],
                ['u.admisecsgp_mstplant_plant_id', '=', "$plant"]
            ])
            ->select('npk')
            ->first();
    }

    public static function cekShift($shift)
    {
        return DB::table('admisecsgp_mstshift as s')
            ->where([
                ['s.nama_shift', '=', $shift],
            ])
            ->select('nama_shift')
            ->first();
    }

    public static function headerJadwalPatroli($date, $plant)
    {
        return DB::table('admisecsgp_trans_jadwal_patroli as jp')
            ->join('admisecsgp_mstusr as u', 'u.npk', 'jp.admisecsgp_mstusr_npk')
            ->join('admisecsgp_mstplant as p', 'p.plant_id', 'jp.admisecsgp_mstplant_plant_id')
            ->where([
                [DB::raw("(FORMAT(jp.date_patroli,'yyyy-MM'))"), '=', $date],
                ['jp.admisecsgp_mstplant_plant_id', '=', $plant]
            ])
            ->select('u.npk', 'u.name', 'p.plant_name')
            ->groupBy('u.npk', 'u.name', 'p.plant_name')
            ->get();
    }

    public static function shiftPatroli($date, $npk)
    {
        return DB::table('admisecsgp_trans_jadwal_patroli as jp')
            ->join('admisecsgp_mstshift as s', 's.shift_id', 'jp.admisecsgp_mstshift_shift_id')
            ->where([
                ['jp.date_patroli', '=', $date],
                ['jp.admisecsgp_mstusr_npk', '=', $npk]
            ])
            ->select('s.nama_shift as shift')
            ->first();
    }


    public  static function getPatroliPerTanggal($date, $plant)
    {
        return DB::table('admisecsgp_trans_jadwal_patroli as jp')
            ->join('admisecsgp_mstusr as u', 'u.npk', 'jp.admisecsgp_mstusr_npk')
            ->join('admisecsgp_mstplant as p', 'p.plant_id', 'jp.admisecsgp_mstplant_plant_id')
            ->join('admisecsgp_mstshift as s', 's.shift_id', 'jp.admisecsgp_mstshift_shift_id')
            ->where([
                [DB::raw("(FORMAT(jp.date_patroli,'yyyy-MM-dd'))"), '=', $date],
                ['jp.admisecsgp_mstplant_plant_id', '=', $plant]
            ])
            ->select('jp.id_jadwal_patroli as id', 'u.name', 'u.npk', 's.nama_shift', 'p.plant_name', 'jp.date_patroli', 's.shift_id')
            ->groupBy('jp.id_jadwal_patroli', 'u.name', 'u.npk', 's.nama_shift', 'p.plant_name', 'jp.date_patroli', 's.shift_id')
            ->get();
    }
}
