<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'event_name', 'admisecsgp_mstkobj_kategori_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_mstevent";
    protected $primaryKey = 'event_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }


    public function details()
    {
        return DB::table('admisecsgp_mstevent as ev')
            ->join('admisecsgp_mstkobj as ko', 'ko.kategori_id', '=', 'ev.admisecsgp_mstkobj_kategori_id')
            ->select('ev.*', 'ko.kategori_name');
    }

    public function kategoriDetails()
    {
        return $this->hasOne(KategoriObjek::class, 'kategori_id', 'admisecsgp_mstkobj_kategori_id');
    }
}
