<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class LaporanPatroli extends Model
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
}
