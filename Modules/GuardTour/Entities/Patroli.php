<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Patroli extends Model
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
}
