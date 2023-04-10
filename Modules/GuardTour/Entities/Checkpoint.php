<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Checkpoint extends Model
{
    use HasFactory;

    protected $fillable = ['checkpoint_id', 'check_name', 'check_no', 'admisecsgp_mstzone_zone_id', 'others', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'durasi_batas_atas', 'durasi_batas_bawah'];
    protected $table = "admisecsgp_mstckp";
    protected $primaryKey = 'checkpoint_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }


    public function details()
    {
        return DB::table('admisecsgp_mstckp')
            ->join('admisecsgp_mstzone', 'admisecsgp_mstckp.admisecsgp_mstzone_zone_id', '=', 'admisecsgp_mstzone.zone_id')
            ->join('admisecsgp_mstplant', 'admisecsgp_mstzone.admisecsgp_mstplant_plant_id', '=', 'admisecsgp_mstplant.plant_id')
            ->select('admisecsgp_mstckp.*', 'admisecsgp_mstplant.plant_name', 'admisecsgp_mstzone.zone_name', 'admisecsgp_mstplant.plant_id')->get();
    }

    public function zoneDetails()
    {
        return $this->hasOne(Zona::class, 'zone_id', 'admisecsgp_mstzone_zone_id');
    }
}
