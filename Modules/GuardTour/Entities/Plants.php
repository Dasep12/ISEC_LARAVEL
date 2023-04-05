<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plants extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = "admisecsgp_mstplant";
    protected $primaryKey = 'company_id';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }
}
