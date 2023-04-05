<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'comp_name', 'address1', 'comp_phone', 'status', 'created_by', 'created_at', 'others'];
    protected $table = "admisecsgp_mstcmp";
    protected $primaryKey = 'company_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\CompanyFactory::new();
    }
}
