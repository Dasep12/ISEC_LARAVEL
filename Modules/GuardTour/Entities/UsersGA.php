<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class UsersGA extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'email', 'admisecsgp_mstplant_plant_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'type'];
    protected $table = "admisecsgp_mstusr_ga";
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }


    public function details()
    {
        return DB::table('admisecsgp_mstusr_ga as us')
            ->join('admisecsgp_mstplant as pl', 'us.admisecsgp_mstplant_plant_id', '=', 'pl.plant_id')
            ->select('us.*', 'pl.plant_name');
    }
}
