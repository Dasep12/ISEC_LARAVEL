<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleModel extends Model
{
    use HasFactory;

    public static function access_app($npk, $app)
    {
        // $username = $req->input('username');

        $res = DB::connection('sqlsrv')->select("SELECT COUNT(1) total_app
                FROM isecurity.dbo.admisec_roles_users aru
                INNER JOIN isecurity.dbo.admisec_modules_roles amr ON amr.roles_id=aru.roles_id
                INNER JOIN isecurity.dbo.admisec_modules amo ON amo.id=amr.modules_id 
                INNER JOIN isecurity.dbo.admisec_apps aap ON aap.id=amo.apps_id
            WHERE aru.npk=? AND aap.code=?", [$npk, $app]);

        return $res;
    }

    public static function access_modul($npk, $module)
    {
        // $username = $req->input('username');

        $res = DB::connection('sqlsrv')->select("SELECT aru.npk, amr.modules_id, amr.roles_id, amr.crt, amr.red, amr.edt, amr.dlt, amr.apr, amr.rjc
                    FROM isecurity.dbo.admisec_roles_users aru
                    INNER JOIN isecurity.dbo.admisec_modules_roles amr ON amr.roles_id=aru.roles_id
                 WHERE aru.npk=? AND amr.modules_id=(select id from isecurity.dbo.admisec_modules where code=?)", [$npk, $module]);

        return $res;
    }
}
