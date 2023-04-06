<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = ['zone_id', 'zone_name', 'kode_zona', 'kode_plant', 'admisecsgp_mstplant_plant_id', 'others', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_mstzone";
    protected $primaryKey = 'zone_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }


    public function details()
    {
        return DB::table('admisecsgp_mstzone')
            ->join('admisecsgp_mstplant', 'admisecsgp_mstzone.admisecsgp_mstplant_plant_id', '=', 'admisecsgp_mstplant.plant_id')
            ->join('admisecsgp_mstsite', 'admisecsgp_mstplant.admisecsgp_mstsite_site_id', '=', 'admisecsgp_mstsite.site_id')
            ->select('admisecsgp_mstzone.*', 'admisecsgp_mstplant.plant_name', 'admisecsgp_mstsite.site_name')->get();
    }

    public function plantDetails()
    {
        return $this->hasOne(Plants::class, 'plant_id', 'admisecsgp_mstplant_plant_id');
    }
}
