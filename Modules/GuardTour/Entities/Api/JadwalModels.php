<?php

namespace Modules\GuardTour\Entities\api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\Users;
use URL;

class JadwalModels extends Model
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

	public static function getJadwal($today, $tomorrow, $user_id, $plant_id)
	{
		//fetch data by conditions
		$sql = "select id_jadwal_patroli,
        				s.nama_shift                                                                 as shift,
        			   	s.shift_id,
        			   	CONVERT(varchar,s.jam_masuk, 24) as jam_masuk,
        				IIF(s.nama_shift = 'LIBUR', CONVERT(varchar, s.jam_pulang, 24),
        				   CONVERT(varchar, DATEADD(MINUTE, " . -29 . ", s.jam_pulang), 24)) as jam_pulang,
        			   	p.plant_name,
        			   	p.plant_id                                                                   as plant_id  ,
                        CONVERT(varchar,date_patroli,105) as date 
        		from admisecsgp_trans_jadwal_patroli jp,
        			 admisecsgp_mstplant p,
        			 admisecsgp_mstshift s
        		where jp.admisecsgp_mstplant_plant_id = p.plant_id
        		  	and admisecsgp_mstshift_shift_id = s.shift_id
        			AND date_patroli between  '" . $today . "' AND '" . $tomorrow . "'
        			AND jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "'
        			AND admisecsgp_mstusr_npk = '" . $user_id . "'";
		$res = DB::select($sql);
		return $res;
	}

	public static function getCurrentShift($date)
	{
		$sql = "select *
				from (
						select shift_id,
							 nama_shift,
							 CAST('" . $date . "' AS DATETIME) + CAST(jam_masuk AS DATETIME)       as jam_masuk,
							 IIF(s.jam_masuk > s.jam_pulang,
								 DATEADD(day, 1, CAST('" . $date . "' AS DATETIME) + CAST(jam_pulang AS DATETIME)),
								 CAST('" . $date . "' AS DATETIME) + CAST(jam_pulang AS DATETIME)) as jam_pulang
					  	from admisecsgp_mstshift s
					  	where nama_shift != 'LIBUR') as shift
				WHERE getdate() between shift.jam_masuk and shift.jam_pulang";
		return DB::select($sql);
	}

	public static function getShift($date)
	{
		$sql = "select shift_id, nama_shift, jam_masuk, DATEADD(MINUTE, " . -29 . ", shift.jam_pulang) as jam_pulang
				from (
						select shift_id,
							 nama_shift,
							 CAST('" . $date . "' AS DATETIME) + CAST(jam_masuk AS DATETIME)       as jam_masuk,
							 IIF(s.jam_masuk > s.jam_pulang,
								 DATEADD(day, 1, CAST('" . $date . "' AS DATETIME) + CAST(jam_pulang AS DATETIME)),
								 CAST('" . $date . "' AS DATETIME) + CAST(jam_pulang AS DATETIME))
								 as jam_pulang
					  	from admisecsgp_mstshift s
					  	where nama_shift != 'LIBUR') as shift";
		return DB::select($sql);
	}

	public static function getDataPatroli($dateTime, $shift_id, $plant_id)
	{
		$dataPatroli = [];
		$zones = Self::getZones($dateTime, $shift_id, $plant_id);
		foreach ($zones as $zone) {
			$checkpoint = Self::getCheckPoint($zone->id);
			$checkpointObject = [];
			foreach ($checkpoint as $cp) {
				$objects = Self::getObjek($cp->id);
				foreach ($objects as $object) {
					$event = Self::getEvent($object->id);
					$object->event = $event;;
				}
				$checkpointObject[] = $cp;
				$cp->objects = $objects;
			}
			$zone->checkpoints = $checkpointObject;
			$dataPatroli[] = $zone;
		}
		return $dataPatroli;
	}

	private static function getZones($dateTime, $shift_id, $plant_id)
	{
		$sql = "select z.zone_name, zp.admisecsgp_mstzone_zone_id as id, am.plant_name as plant_name, zp.admisecsgp_mstplant_plant_id as plant_name
				from admisecsgp_trans_zona_patroli zp
				left join admisecsgp_mstzone z on z.zone_id = zp.admisecsgp_mstzone_zone_id
				left join admisecsgp_mstplant am on am.plant_id = zp.admisecsgp_mstplant_plant_id
				where admisecsgp_mstshift_shift_id = '" . $shift_id . "'
				  and date_patroli = '" . $dateTime . "'
				  and zp.admisecsgp_mstplant_plant_id = '" . $plant_id . "'
				  and status_zona = 1";

		return DB::select($sql);
	}

	private static function getCheckPoint($zone_id)
	{
		return DB::select("
				SELECT checkpoint_id as id,
					   check_name,
					   check_no as no_nfc,
					   admisecsgp_mstzone_zone_id as zone_id,
					   IIF(status=1,'AKTIF', 'INACTIVE') as status_checkpoint 
				from admisecsgp_mstckp 
				where 	status=1 
				and		admisecsgp_mstzone_zone_id ='" . $zone_id . "' ");
	}


	private static function getObjek($check)
	{
		return DB::select("
				select objek_id as id,
				       admisecsgp_mstckp_checkpoint_id as checkpoint_id,
					   nama_objek,
					   status  
				from admisecsgp_mstobj 
				where status='1'
				  and admisecsgp_mstckp_checkpoint_id  ='" . $check . "'");
	}

	private static function getEvent($objek)
	{
		return DB::select("
				SELECT ev.event_id as id,
					   ob.objek_id as object_id,
					   ev.event_name
				from admisecsgp_mstevent ev
						 join admisecsgp_mstkobj ko on ev.admisecsgp_mstkobj_kategori_id = ko.kategori_id
						 join admisecsgp_mstobj ob on ko.kategori_id = ob.admisecsgp_mstkobj_kategori_id
				where ob.objek_id = '" . $objek . "'
				  and ko.status = 1");
	}

	public static function getDataTemuan($id)
	{
		$url = URL::to('/') . '/';

		$data = DB::table('admisecsgp_trans_headers as h')
			->where('h.trans_header_id', $id)
			->select('*')
			->first();

		$sqlDetail = "select trans_detail_id,
					   admisecsgp_trans_headers_trans_headers_id,
					   admisecsgp_mstobj_objek_id,
					   conditions,
					   admisecsgp_mstevent_event_id,
					   description,
					   (CASE WHEN image_1 IS NOT NULL 
							 THEN concat('" . $url . "',image_1) 
							 ELSE NULL
						END) as image_1, 	
					   (CASE WHEN image_2 IS NOT NULL 
							 THEN concat('" . $url . "',image_2) 
							 ELSE NULL
						END) as image_2,
					   (CASE WHEN image_3 IS NOT NULL 
							 THEN concat('" . $url . "',image_3) 
							 ELSE NULL
						END) as image_3,
					   is_laporan_kejadian,
					   laporkan_pic,
					   is_tindakan_cepat,
					   status_temuan,
					   deskripsi_tindakan,
					   note_tindakan_cepat,
					   status,
					   created_at,
					   created_by,
					   updated_at,
					   updated_by,
					   sync_token
				from admisecsgp_trans_details where 
				admisecsgp_trans_headers_trans_headers_id ='" . $id . "'";
		$dataDetail = DB::select($sqlDetail);
		$data->detail_temuan = $dataDetail;
		return $data;
	}

	public static function getAllDataTemuan()
	{

		$sqlDetail = "select trans_detail_id, 
    					   sh.shift_id,
						   sh.nama_shift,
						   admisecsgp_mstobj_objek_id as object_id,
						   am.nama_objek,
						   ath.admisecsgp_mstckp_checkpoint_id as chekpoint_id,
						   description,
							(CASE WHEN image_1 IS NOT NULL
								 THEN concat('" . URL::to('/') . "',image_1)
								 ELSE NULL
							END) as image_1,   
						   ath.date_patroli
						from admisecsgp_trans_details
							 left join admisecsgp_trans_headers ath
									   on ath.trans_header_id = admisecsgp_trans_details.admisecsgp_trans_headers_trans_headers_id
							 left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
							 left join admisecsgp_mstobj am on admisecsgp_trans_details.admisecsgp_mstobj_objek_id = am.objek_id
					where status_temuan = 0";
		$dataDetail = DB::select($sqlDetail);
		return $dataDetail;
	}
}
