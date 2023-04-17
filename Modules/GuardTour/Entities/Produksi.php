<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Produksi extends Model
{
    use HasFactory;

    protected $fillable = ['produksi_id', 'name', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_mstproduction";
    protected $primaryKey = 'produksi_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }
}
