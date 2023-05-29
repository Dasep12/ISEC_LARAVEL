<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = ['id_setting', 'nama_setting', 'nilai_setting', 'type', 'unit', 'status', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_setting";
    protected $primaryKey = 'id_setting';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }
}
