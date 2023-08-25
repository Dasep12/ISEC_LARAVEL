<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuthModel extends Model
{
    use HasFactory;

    public static function check($req)
    {
        $username = $req->input('username');
        // $password = md5($req->input('password'));

        // $res = DB::connection('sqlsrv')->select('select TOP 1 name from isecurity.dbo.admisecsgp_mstusr where user_name = ?', [$username]);

        $res = DB::connection('sqlsrv')->select("SELECT usr.npk , usr.name , usr.password , ru.level  , usr.admisecsgp_mstsite_site_id , usr.admisecsgp_mstplant_plant_id  , st.id_wilayah, st.admisecsgp_mstcmp_company_id
        FROM admisecsgp_mstusr usr , admisecsgp_mstroleusr  ru , admisecsgp_mstsite st 
        WHERE ru.role_id = usr.admisecsgp_mstroleusr_role_id and usr.admisecsgp_mstsite_site_id = st.site_id and usr.name=?", [$username]);

        return $res;
    }
}
