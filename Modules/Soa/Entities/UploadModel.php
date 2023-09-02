<?php

namespace Modules\Soa\Entities;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use GuzzleHttp\Psr7\Request;

class UploadModel extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\UploadModelFactory::new();
    }

    public static function getPerPlant()
    {
        $sql = "SELECT id, title FROM admisecdrep_sub WHERE categ_id='9' AND disable=0";
        $res = DB::connection('soabi')->select($sql);
        return $res;
    }

    public static function getPerPlantId($title)
    {
        $sql = "SELECT id, title FROM admisecdrep_sub WHERE categ_id='9' and title='" . $title . "' AND disable=0";
        $res = DB::connection('soabi')->select($sql);
        return $res;
    }
}
