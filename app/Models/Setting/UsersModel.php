<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\RoleModel;
use AuthHelper;

class UsersModel extends Model
{
    use HasFactory;

    protected $fillable = ['npk', 'name', 'password', 'admisecsgp_mstroleusr_role_id', 'admisecsgp_mstplant_plant_id', 'admisecsgp_mstcmp_company_id', 'admisecsgp_mstsite_site_id', 'others', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'email', 'patrol_group', 'user_name'];
    protected $table = "admisecsgp_mstusr";
    protected $primaryKey = 'npk';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\PlantsFactory::new();
    }


    public static function listUsers()
    {
        return DB::table('admisecsgp_mstusr as us')
            ->join('admisecsgp_mstplant as pl', 'us.admisecsgp_mstplant_plant_id', '=', 'pl.plant_id')
            ->join('admisecsgp_mstsite as st', 'us.admisecsgp_mstsite_site_id', '=', 'st.site_id')
            ->join('admisecsgp_mstroleusr as rl', 'us.admisecsgp_mstroleusr_role_id', '=', 'rl.role_id')
            ->select('us.*', 'pl.plant_name', 'st.site_name', 'rl.level');
    }
}
