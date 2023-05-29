<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'level', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'description'];
    protected $table = "admisecsgp_mstroleusr";
    protected $primaryKey = 'role_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }
}
