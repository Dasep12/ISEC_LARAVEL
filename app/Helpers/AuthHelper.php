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
        $role = self::user_npk();
        $npk = session('npk');

        $access_module = RoleModel::access_modul($npk, $module);

        if($access_module !== NULL) {
            return $access_module;
        } else {
            return false;
        }
    }
    
    public static function is_access_privilege($module, $privilege) {
        $role = session('role');
        $npk = session('npk');

        $access_module = RoleModel::access_modul($npk, $module)[0];

		if($privilege == 'crt' && $access_module->$privilege == 1) {
			return true;
		}
		
		return false;
    }

    // if ( ! function_exists('is_section_manager')) {
    //     function is_section_manager() {
    //         $CI  =& get_instance();
    //         if(strtoupper($CI->session->userdata('role')) == 'ADMINSHM') {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     }
    // }

    public static function is_author($area='')
    {
        $npk = self::user_npk();

        $access_app = RoleModel::access_roles($npk, 'ADMINSRS');

        if($access_app == NULL) {
            return false;
        }

        if(($area !== '' && $area == 'ALLAREA') && $npk == '7295')
        {
            return false;
        }
        
        return true;
    }

    public static function is_section_head($area='')
    {
        $npk = self::user_npk();

        if(strtoupper(self::user_role()) == 'ADMINSH') {
            return true;
        } else {
            return false;
        }
    }

    public static function is_building_manager($area='')
    {
        $npk = self::user_npk();

        if(strtoupper(self::user_role()) == 'BUILDINGMANAGER') {
            return true;
        } else {
            return false;
        }
    }

    public static function user_npk()
    {
        return session('npk');
    }

    public static function user_role()
    {
        return session('role');
    }

    public static function user_wilayah()
    {
        return session('wil_id');
    }
}