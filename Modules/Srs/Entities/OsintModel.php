<?php

namespace Modules\Srs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use AuthHelper;

class OsintModel extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\OsintModelFactory::new();
    }

    public static function getDetail($req)
    {
        $id = $req->input("id");
        
        $res = DB::connection('srsbi')->table('admisecosint_transaction as tr')
            ->select('tr.id','tr.activity_name','tr.date','asu.title as plant','lev.level as sdm_level','lev2.level as reputasi_level' ,'tr.created_by','ashd.name as media' ,'ashd1.name as jenis_media' ,'url1','url2', 'trg.name as target_issue' ,'rso.name as risk_source' ,'rsos.name as risk_source_sub','ngs.name as negative_sentiment' ,'rgn.name as regional_name' ,'lgt.name as legalitas_name' ,'lgts.name as legalitas_sub1_name' ,'frm.name as format_name' ,'implvl.level as impact_level', 'tr.risk_level' ,'tr.created_at')
            // ->from('admisecosint_transaction as tr')
            ->leftJoin('admiseciso_area_sub as asu', 'tr.plant_id', '=', 'asu.id')
            ->leftJoin('admisecosint_sub_header_data as suh', 'tr.sdm_sector_level_id','=','suh.sub_id')
            ->leftJoin('admisecosint_risk_level as lev', 'suh.level_id', '=', 'lev.id')
            ->leftJoin('admisecosint_sub_header_data as suh2', 'tr.reputasi_level_id', '=', 'suh2.sub_id')
            ->leftJoin('admisecosint_risk_level as lev2', 'suh2.level_id', '=','lev2.id')
            ->leftJoin('admisecosint_sub_header_data AS ashd', 'ashd.sub_id ', '=', 'tr.media_id')
            ->leftJoin('admisecosint_sub2_header_data AS ashd1', 'ashd1.id', '=','tr.sub1_media_id')
            ->leftJoin('admisecosint_sub_header_data AS trg', 'trg.sub_id', '=', 'tr.target_issue_id')
            ->leftJoin('admisecosint_sub_header_data AS rso', 'rso.sub_id ', '=', 'tr.risk_source')
            ->leftJoin('admisecosint_sub1_header_data AS rsos', 'rsos.id', '=', 'tr.sub_risk_source')
            ->leftJoin('admisecosint_sub_header_data AS ngs', 'ngs.sub_id', '=', 'tr.hatespeech_type_id')
            ->leftJoin('admisecosint_sub_header_data AS rgn', 'rgn.sub_id','=','tr.regional_id')
            ->leftJoin('admisecosint_sub_header_data AS lgt', 'lgt.sub_id','=','tr.legalitas_id')
            ->leftJoin('admisecosint_sub1_header_data AS lgts', 'lgts.id','=','tr.legalitas_sub1_id')
            ->leftJoin('admisecosint_sub_header_data AS frm', 'frm.sub_id','=','tr.format_id')
            ->leftJoin('admisecosint_risk_level AS implvl', 'implvl.id', '=' ,DB::connection('srsbi')->raw('(select level_id from admisecosint_sub_header_data where sub_id=tr.impact_level_id)'))
            ->where('tr.id', $id)
            ->first();

        return $res;
    }
}