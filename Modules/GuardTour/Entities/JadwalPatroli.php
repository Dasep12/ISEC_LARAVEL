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
}
