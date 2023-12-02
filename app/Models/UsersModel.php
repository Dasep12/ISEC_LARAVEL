<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersModel extends Model
{
    use HasFactory;

    public static function getUsers()
    {


        $res = DB::select("SELECT  u.name, u.npk, u.email, u.patrol_group, u.admisecsgp_mstroleusr_role_id , r.level , c.comp_name , s.site_name , p.plant_name  , u.status , u.admisecsgp_mstsite_site_id as site_id , u.user_name
        FROM admisecsgp_mstusr u , admisecsgp_mstroleusr r , admisecsgp_mstcmp c , admisecsgp_mstsite s
        , admisecsgp_mstplant p
        WHERE u.admisecsgp_mstroleusr_role_id = r.role_id and c.company_id = s.admisecsgp_mstcmp_company_id and u.admisecsgp_mstsite_site_id = s.site_id and p.plant_id = u.admisecsgp_mstplant_plant_id");

        return $res;
    }
}
