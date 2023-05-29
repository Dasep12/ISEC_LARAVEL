<?php

namespace Modules\GuardTour\Entities\api_b;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\Users;

class AuthPatrolModels extends Model
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

    public static function getCurrentShiftPatrol($shift, $date)
    {
        $data =  DB::table('admisecsgp_mstshift as s')
            ->where([
                ['s.nama_shift', '=', $shift],
            ])
            ->select('s.nama_shift as shift', 's.shift_id', DB::raw("FORMAT(cast(s.jam_masuk as time), N'hh\:mm\:ss') as 'in'"),  DB::raw("FORMAT(cast(s.jam_pulang as time), N'hh\:mm\:ss') as 'out'"))
            ->first();

        $result = array(
            'shift'     => (int)$data->shift,
            'shift_id'  => $data->shift_id,
            'tanggal'   => $date,
            'in'        => $data->in,
            'out'       => $data->out,
        );
        return $result;
    }

    public static function getShiftPatrol($date, $npk)
    {
        return DB::table('admisecsgp_trans_jadwal_patroli as jp')
            ->join('admisecsgp_mstshift as s', 's.shift_id', 'jp.admisecsgp_mstshift_shift_id')
            ->where([
                ['jp.date_patroli', '=', $date],
                ['jp.admisecsgp_mstusr_npk', '=', $npk],
            ])
            ->select('s.nama_shift as shift', 's.shift_id', 'jp.date_patroli as tanggal',  DB::raw("FORMAT(cast(s.jam_masuk as time), N'hh\:mm\:ss') as 'in'"),  DB::raw("FORMAT(cast(s.jam_pulang as time), N'hh\:mm\:ss') as 'out'"))
            ->first();
    }


    public static function getAkun($npk, $password)
    {
        return DB::table('admisecsgp_mstusr')
            ->where([
                ['npk', '=', $npk],
                ['password', '=', $password],
            ])
            ->select('*');
    }

    public static function getUsers($npk)
    {
        return DB::table('admisecsgp_mstusr as u')
            ->join('admisecsgp_mstplant as p', 'p.plant_id', 'u.admisecsgp_mstplant_plant_id')
            ->where('u.npk', $npk)
            ->select('u.name', 'u.npk', 'p.plant_id', 'p.plant_name')
            ->first();
    }

    public static function getJadwalPatroli($date, $npk)
    {
        return DB::table('admisecsgp_trans_jadwal_patroli as jp')
            ->join('admisecsgp_mstshift as s', 'jp.admisecsgp_mstshift_shift_id', 's.shift_id')
            ->join('admisecsgp_mstusr as u', 'jp.admisecsgp_mstusr_npk', 'u.npk')
            ->where([
                ['jp.admisecsgp_mstusr_npk', '=', $npk],
                ['jp.date_patroli', '=', $date]
            ])
            ->select('jp.id_jadwal_patroli', 'jp.date_patroli as tanggal', 'u.name as nama', 'u.npk', 's.nama_shift as shift', 's.shift_id as id_shift', DB::raw("FORMAT(cast(s.jam_masuk as time), N'hh\:mm\:ss') as jam_masuk"), DB::raw("FORMAT(cast(s.jam_pulang as time), N'hh\:mm\:ss') as jam_pulang"));
    }
}
