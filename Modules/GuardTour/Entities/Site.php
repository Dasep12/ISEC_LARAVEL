<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['site_id', 'admisecsgp_mstcmp_company_id', 'site_name', 'status', 'others', 'created_by', 'created_at', 'others', 'updated_at', 'updated_by'];
    protected $table = "admisecsgp_mstsite";
    protected $primaryKey = 'site_id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\SiteFactory::new();
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id', 'admisecsgp_mstcmp_company_id');
    }
}
