<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Plants extends Model
{
    use HasFactory;

    protected $fillable = ['plant_id', 'plant_name', 'kode_plant', 'admisecsgp_mstsite_site_id', 'others', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'plant_code'];
    protected $table = "admisecsgp_mstplant";
    protected $primaryKey = 'plant_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }


    public function details()
    {
        return DB::table('admisecsgp_mstplant')
            ->join('admisecsgp_mstsite', 'admisecsgp_mstplant.admisecsgp_mstsite_site_id', '=', 'admisecsgp_mstsite.site_id')
            ->join('admisecsgp_mstcmp', 'admisecsgp_mstsite.admisecsgp_mstcmp_company_id', '=', 'admisecsgp_mstcmp.company_id')
            ->select('admisecsgp_mstplant.*', 'admisecsgp_mstsite.site_name', 'admisecsgp_mstcmp.comp_name');
    }


    public function siteDetails()
    {
        return $this->hasOne(Site::class, 'site_id', 'admisecsgp_mstsite_site_id');
    }
}
