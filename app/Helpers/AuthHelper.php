<?php

namespace App\Helpers;

use Session;
use Illuminate\Http\RedirectResponse;

use App\Models\RoleModel;

class AuthHelper
{
    public static function checksession($session)
    {
        $id = session('npk');

        if($id == null)
        {
            return redirect("/")->with(["error" => 'Sesi berakhir']);
        }
    }

    public static function is_super_admin()
    {
        if(strtoupper(session('role')) == 'SUPERADMIN') {
            return true;
        } else {
            return false;
        }
    }

    public static function is_app($apps)
    {
        $role = session('role');
        $npk = session('npk');

        // $access_app = $ci->Roles_m->access_app($npk, $apps)->row();
        $access_app = RoleModel::access_app($npk, $apps);

        if($access_app[0]->total_app > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_module($module)
    {
        $role = session('role');
        $npk = session('npk');

        $access_module = RoleModel::access_modul($npk, $module);

        if($access_module !== NULL) {
            return $access_module;
        } else {
            return false;
        }
    }
}