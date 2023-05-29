<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class KategoriObjek extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_id', 'kategori_name', 'others', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_mstkobj";
    protected $primaryKey = 'kategori_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }
}
