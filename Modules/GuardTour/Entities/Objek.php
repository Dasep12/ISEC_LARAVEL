<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Objek extends Model
{
    use HasFactory;

    protected $fillable = ['objek_id', 'nama_objek', 'admisecsgp_mstckp_checkpoint_id', 'admisecsgp_mstkobj_kategori_id', 'status', 'others', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_mstobj";
    protected $primaryKey = 'objek_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }

    public function details()
    {
        return DB::table('admisecsgp_mstobj as o ')
            ->join('admisecsgp_mstckp as c', 'c.checkpoint_id', '=', 'o.admisecsgp_mstckp_checkpoint_id')
            ->join('admisecsgp_mstzone as z', 'z.zone_id', '=', 'c.admisecsgp_mstzone_zone_id')
            ->join('admisecsgp_mstplant as p', 'p.plant_id', '=', 'z.admisecsgp_mstplant_plant_id')
            ->join('admisecsgp_mstkobj as ko', 'ko.kategori_id', '=', 'o.admisecsgp_mstkobj_kategori_id')
            ->select('o.*', 'c.check_name', 'z.zone_name', 'z.zone_id', 'p.plant_id', 'p.plant_name', 'ko.kategori_name', 'c.checkpoint_id');
    }
}
