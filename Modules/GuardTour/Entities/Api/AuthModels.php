<?php

namespace Modules\GuardTour\Entities\api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\Users;

class AuthModels extends Model
{
    use HasFactory;

    protected $fillable = ['npk', 'name', 'password', 'admisecsgp_mstroleusr_role_id', 'admisecsgp_mstplant_plant_id', 'admisecsgp_mstcmp_company_id', 'admisecsgp_mstsite_site_id', 'others', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'email', 'patrol_group', 'user_name'];
    protected $table = "admisecsgp_mstusr";
    protected $primaryKey = 'npk';
    public $incrementing = false;

    protected static function newFactory()
    {
        return \Modules\GuardTour\Database\factories\Api\AuthModelsFactory::new();
    }

    public static function getRows($params = array())
    {
        //fetch data by conditions
        $where = array();
        if (array_key_exists("conditions", $params)) {
            foreach ($params['conditions'] as $key => $value) {
                $wh = array($key, '=', $value);
                $where[] = $wh;
            }
        }
        $res =  DB::table('admisecsgp_mstusr as u')
            ->where($where)
            ->select('u.*')
            ->get();

        return $res->count() > 0 ? $res->first() : false;
    }

    public static function getUsers($params)
    {
        //fetch data by conditions
        $res =  DB::table('admisecsgp_mstusr as u')
            ->where('npk', $params)
            ->select('u.*')
            ->first();
        return $res;
    }

    public static function getToken($key)
    {
        $res =  DB::table('admisecsgp_apikeys as k')
            ->where('key', $key)
            ->select('k.*')
            ->first();

        if ($res) {
            return $res->key;
        }
        return false;
    }

    public static function checkKey($key)
    {
        $res =  DB::table('admisecsgp_apikeys as k')
            ->where('key', $key)
            ->select('k.*')
            ->first();
        return $res;
    }
}
