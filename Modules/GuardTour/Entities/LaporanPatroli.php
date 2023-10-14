<?php

namespace Modules\GuardTour\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class LaporanPatroli extends Model
{
	use HasFactory;

	protected $fillable = ['id_jadwal_patroli', 'date_patroli', 'admisecsgp_mstplant_plant_id', 'admisecsgp_mstusr_npk', 'admisecsgp_mstshift_shift_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
	protected $table = "admisecsgp_trans_jadwal_patroli";
	protected $primaryKey = 'id_jadwal_patroli';
	public $incrementing = false;

	protected static function newFactory()
	{
		return \Modules\GuardTour\Database\factories\PlantsFactory::new();
	}


	// public static function getDataPatroli($plantId, $start, $end, $type)
	// {
	// 	$join = '';
	// 	if ($type == 0) {
	// 		$join = 'left';
	// 	}

	// 	$sql = "select jp.date_patroli,
	//    				   jp.id_jadwal_patroli,
	// 				   sh.nama_shift,
	// 				   usr.npk,
	// 				   usr.name,
	// 				   ISNULL(pl.plant_name, '-')         as plant_name,
	// 				   s.start_at,
	// 				   s.end_at,
	// 				   ISNULL(target_object, '-')         as target_object,
	// 				   ISNULL(s.total_object_temuan, '-') as total_object_temuan,
	// 				   ISNULL(s.total_object_normal, '-') as total_object_normal,
	// 				   ISNULL(s.total_ckp, 0)             as total_ckp,
	// 				   ISNULL(s.chekpoint_patroli, 0)     as chekpoint_patroli
	// 			from admisecsgp_trans_jadwal_patroli jp
	// 					 join admisecsgp_mstshift sh on sh.shift_id = jp.admisecsgp_mstshift_shift_id
	// 					 join admisecsgp_mstplant pl on jp.admisecsgp_mstplant_plant_id = pl.plant_id
	// 					 join admisecsgp_mstusr usr on jp.admisecsgp_mstusr_npk = usr.npk
	// 					 " . $join . " join (select *,
	// 								  (select count(am.checkpoint_id) as co
	// 								   from admisecsgp_trans_zona_patroli zp
	// 											join admisecsgp_mstzone z on z.zone_id = zp.admisecsgp_mstzone_zone_id
	// 											join admisecsgp_mstplant mp on mp.plant_id = zp.admisecsgp_mstplant_plant_id
	// 											join admisecsgp_mstckp am on z.zone_id = am.admisecsgp_mstzone_zone_id
	// 								   where zp.status_zona = 1
	// 									 and s.date_patroli = zp.date_patroli
	// 									 and mp.plant_id = s.plant_id
	// 									 and s.shift_id = zp.admisecsgp_mstshift_shift_id) as total_ckp
	// 						   from (select ath.admisecsgp_mstusr_npk                           as npk,
	// 										pl.plant_id,
	// 										min(ALL ath.checkin_checkpoint)                     as start_at,
	// 										max(ath.checkout_checkpoint)                        as end_at,
	// 										sh.shift_id,
	// 										count(atd.admisecsgp_mstobj_objek_id)               as target_object,
	// 										SUM(IIF(atd.status = 0, 1, 0))                      as total_object_temuan,
	// 										SUM(IIF(atd.status = 1, 1, 0))                      as total_object_normal,
	// 										count(distinct ath.admisecsgp_mstckp_checkpoint_id) as chekpoint_patroli,
	// 										ath.type_patrol,
	// 										min(cast(ath.checkin_checkpoint as date))          as date_patroli
	// 								 from admisecsgp_trans_headers ath
	// 										  left join admisecsgp_trans_details atd
	// 													on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
	// 										  left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
	// 										  left join admisecsgp_mstobj am on atd.admisecsgp_mstobj_objek_id = am.objek_id
	// 										  left join admisecsgp_mstckp ckp on ath.admisecsgp_mstckp_checkpoint_id = ckp.checkpoint_id
	// 										  left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
	// 										  left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
	// 								 where pl.plant_id = '" . $plantId . "'
	// 								 AND ath.date_patroli BETWEEN '" . $start . "' AND ' " . $end . " '
	// 								  AND ath.type_patrol = " . $type . "
	// 								 group by sh.nama_shift, pl.plant_name, ath.admisecsgp_mstusr_npk, pl.plant_id,
	// 										  shift_id, ath.type_patrol) as s) as s
	// 							   on s.date_patroli = jp.date_patroli
	// 								   and s.shift_id = jp.admisecsgp_mstshift_shift_id
	// 								   and s.plant_id = jp.admisecsgp_mstplant_plant_id
	// 								   and s.npk = jp.admisecsgp_mstusr_npk
	// 			where pl.plant_id = '" . $plantId . "'
	// 			  AND jp.date_patroli BETWEEN '" . $start . "' AND '" . $end . "'
	// 			  AND sh.nama_shift != 'LIBUR'
	// 			order by jp.admisecsgp_mstplant_plant_id, jp.date_patroli, jp.admisecsgp_mstshift_shift_id";
	// 	return DB::select($sql);
	// }

	public static function getDataDetailPatroli($idJdawal, $npk, $type)
	{
		$sql = "select jp.date_patroli,
					   jp.id_jadwal_patroli,
					   sh.nama_shift,
					   usr.npk,
					   usr.name,
					   ISNULL(pl.plant_name, '-')         as plant_name,
					   s.start_at,
					   s.end_at,
					   ISNULL(target_object, '-')         as target_object,
					   ISNULL(s.total_object_temuan, '-') as total_object_temuan,
					   ISNULL(s.total_object_normal, '-') as total_object_normal,
					   ISNULL(s.total_ckp, 0)             as total_ckp,
					   ISNULL(s.chekpoint_patroli, 0)     as chekpoint_patroli
				from admisecsgp_trans_jadwal_patroli jp
						 join admisecsgp_mstshift sh on sh.shift_id = jp.admisecsgp_mstshift_shift_id
						 join admisecsgp_mstplant pl on jp.admisecsgp_mstplant_plant_id = pl.plant_id
						 left join (select ath.date_patroli,
										   ath.admisecsgp_mstusr_npk                             as npk,
										   pl.plant_id,
										   min(ALL ath.checkin_checkpoint)                       as start_at,
										   max(ath.checkout_checkpoint)                          as end_at,
										   sh.shift_id,
										   count(atd.admisecsgp_mstobj_objek_id)                 as target_object,
										   SUM(IIF(atd.status = 0, 1, 0))                        as total_object_temuan,
										   SUM(IIF(atd.status = 1, 1, 0))                        as total_object_normal,
										   (select count(am.checkpoint_id) as co
											from admisecsgp_trans_zona_patroli zp
													 join admisecsgp_mstzone z on z.zone_id = zp.admisecsgp_mstzone_zone_id
													 join admisecsgp_mstplant mp on mp.plant_id = zp.admisecsgp_mstplant_plant_id
													 join admisecsgp_mstckp am on z.zone_id = am.admisecsgp_mstzone_zone_id
											where zp.status_zona = 1
											  and ath.date_patroli = zp.date_patroli
											  and mp.plant_id = pl.plant_id
											  and sh.shift_id = zp.admisecsgp_mstshift_shift_id) as total_ckp,
										   count(distinct ath.admisecsgp_mstckp_checkpoint_id)   as chekpoint_patroli
									from admisecsgp_trans_headers ath
											 left join admisecsgp_trans_details atd
													   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
											 left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
											 left join admisecsgp_mstobj am on atd.admisecsgp_mstobj_objek_id = am.objek_id
											 left join admisecsgp_mstckp ckp on ath.admisecsgp_mstckp_checkpoint_id = ckp.checkpoint_id
											 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
											 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
											 left join admisecsgp_trans_jadwal_patroli jp 
											     on pl.plant_id = jp.admisecsgp_mstplant_plant_id
											     and sh.shift_id = jp.admisecsgp_mstshift_shift_id 
											            and ath.admisecsgp_mstusr_npk = jp.admisecsgp_mstusr_npk 
											            and jp.admisecsgp_mstshift_shift_id = ath.admisecsgp_mstshift_shift_id	
									where jp.id_jadwal_patroli = '" . $idJdawal . "' and ath.admisecsgp_mstusr_npk = '" . $npk . "' AND ath.type_patrol = " . $type . "
									group by ath.date_patroli, sh.nama_shift, pl.plant_name, ath.admisecsgp_mstusr_npk, pl.plant_id,
											 shift_id) as s
								   on s.date_patroli = jp.date_patroli
									   and s.shift_id = jp.admisecsgp_mstshift_shift_id
									   and s.plant_id = jp.admisecsgp_mstplant_plant_id
									   and s.npk = jp.admisecsgp_mstusr_npk
						 join admisecsgp_mstusr usr on jp.admisecsgp_mstusr_npk = usr.npk
						 where jp.id_jadwal_patroli = '" . $idJdawal . "'
				order by jp.admisecsgp_mstplant_plant_id, jp.date_patroli, jp.admisecsgp_mstshift_shift_id";
		return DB::select($sql);
	}

	public static function getDataPatroli($plantId, $start, $end, $type)
	{
		$whereType = "";
		if ($type == 1) {
			$whereType .= "AND trs.type_patrol = 1";
		}
		$data  = DB::select("SELECT a.date_patroli ,a.admisecsgp_mstusr_npk npk ,usr.name name ,c.nama_shift ,pln.plant_name 
        ,tzn.total_ckp as  total_ckp  ,COALESCE(trs.total_trans_ckp,0) as   chekpoint_patroli,
        COALESCE((trs.total_trans_ckp * 100 / tzn.total_ckp),0) persentase , 
        COALESCE(sum(trs.objek_totals),0) as total_temuan , trs.start_at , trs.end_at
        FROM admisecsgp_trans_jadwal_patroli a
        LEFT JOIN admisecsgp_mstusr usr ON usr.npk=a.admisecsgp_mstusr_npk 
        LEFT JOIN admisecsgp_mstplant pln ON pln.plant_id=a.admisecsgp_mstplant_plant_id 
        LEFT JOIN admisecsgp_mstshift c ON c.shift_id=a.admisecsgp_mstshift_shift_id 
        LEFT OUTER JOIN (
            select count(1) total_ckp ,znp.date_patroli ,znp.admisecsgp_mstplant_plant_id ,znp.admisecsgp_mstshift_shift_id 
                from admisecsgp_trans_zona_patroli znp
                inner join admisecsgp_mstzone zon on zon.zone_id=znp.admisecsgp_mstzone_zone_id 
                inner join admisecsgp_mstckp ckp ON ckp.admisecsgp_mstzone_zone_id=znp.admisecsgp_mstzone_zone_id
                 where znp.status=1 and znp.status_zona=1
            group by znp.date_patroli , znp.admisecsgp_mstplant_plant_id ,znp.admisecsgp_mstshift_shift_id 
        ) tzn ON tzn.date_patroli=a.date_patroli 
            and tzn.admisecsgp_mstplant_plant_id=a.admisecsgp_mstplant_plant_id
            and tzn.admisecsgp_mstshift_shift_id=a.admisecsgp_mstshift_shift_id
        LEFT OUTER JOIN (
            select count(1) total_trans_ckp ,ath.date_patroli
                ,ath.admisecsgp_mstshift_shift_id ,ath.admisecsgp_mstusr_npk , sum(Obj.total_objek) as objek_totals , 
               min(ALL ath.checkin_checkpoint) as start_at,  max(ALL ath.checkin_checkpoint) as end_at , ath.type_patrol
                FROM admisecsgp_trans_headers ath 
                left outer join ( 
                	select count(*) as total_objek , admisecsgp_trans_headers_trans_headers_id as headers_id
                	from admisecsgp_trans_details 
                	where status_temuan = 0
                	group by admisecsgp_trans_headers_trans_headers_id 
                ) Obj on Obj.headers_id = ath.trans_header_id
                WHERE ath.type_patrol = '$type' 
            group by ath.date_patroli
                ,ath.admisecsgp_mstshift_shift_id ,ath.admisecsgp_mstusr_npk , ath.type_patrol
        )trs ON trs.date_patroli=a.date_patroli
                and trs.admisecsgp_mstshift_shift_id=a.admisecsgp_mstshift_shift_id 
                and trs.admisecsgp_mstusr_npk=a.admisecsgp_mstusr_npk 
    WHERE a.date_patroli between '$start' AND  '$end'
    	AND a.admisecsgp_mstplant_plant_id='$plantId'
        AND a.admisecsgp_mstshift_shift_id!='ADMSH5652'
		$whereType
        GROUP BY a.date_patroli ,a.admisecsgp_mstusr_npk , usr.name  ,c.nama_shift , pln.plant_name 
        ,tzn.total_ckp ,trs.total_trans_ckp  ,trs.start_at , trs.end_at 
    ORDER BY a.date_patroli ASC, c.nama_shift ASC ,pln.plant_name ASC");
		return $data;
	}


	public static function  timelineDetail($idJdawal, $npk, $type)
	{

		$sql = "select ath.checkin_checkpoint as start_at ,
		ath.checkout_checkpoint  as end_at ,
		ath.trans_header_id,
		ckp.check_name,
		DATEDIFF(minute, ath.checkin_checkpoint, ath.checkout_checkpoint) as durasi,
					   (select count(*) as total_temuan
						from admisecsgp_trans_details dt
						where dt.admisecsgp_trans_headers_trans_headers_id = ath.trans_header_id
						  and dt.status = 0)                                             as total_temuan
				from admisecsgp_trans_headers ath
				join admisecsgp_trans_jadwal_patroli jp on jp.date_patroli  = ath.date_patroli 
				and jp.admisecsgp_mstshift_shift_id  = ath.admisecsgp_mstshift_shift_id 
				join admisecsgp_mstckp ckp on ckp.checkpoint_id  = ath.admisecsgp_mstckp_checkpoint_id 
				where jp.id_jadwal_patroli = '" . $idJdawal . "' and
				ath.type_patrol = '" . $type . "'  and ath.admisecsgp_mstusr_npk = '" . $npk . "'
				
				order by ath.checkin_checkpoint";
		return DB::select($sql);
	}

	public static function getPatroliPlant($plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where = "where a.plant_id ='" . $plant_id . "'";
		}
		$sql = "select plant_name, plant_id, count(plant_name) total_patroli, month
					from (select a.plant_id, plant_name, FORMAT(ath.date_patroli, 'MM') as month
						  from admisecsgp_trans_headers ath
								   join admisecsgp_mstzone am on ath.admisecsgp_mstzone_zone_id = am.zone_id
								   join admisecsgp_mstplant a on am.admisecsgp_mstplant_plant_id = a.plant_id
						  " . $where . " 
						  group by ath.admisecsgp_mstusr_npk, ath.type_patrol, a.plant_id, plant_name, date_patroli) s
					group by plant_name, plant_id, month;";
		return DB::select($sql);
	}

	public static function getPatroliPlantByUser($year, $month, $plantId = null)
	{
		$where = '';
		if ($plantId != null) {
			$where = "and a.plant_id ='" . $plantId . "'";
		}

		$sql = "select count(p.patrol_group) as total_patroli,
					   plant_name,
					   p.patrol_group
				from (select usr.patrol_group,
							 pl.plant_id, plant_name
					  from admisecsgp_trans_headers ath
							   left join admisecsgp_trans_details atd on
							  ath.trans_header_id =
							  atd.admisecsgp_trans_headers_trans_headers_id
							   left join admisecsgp_mstshift sh on
						  sh.shift_id = ath.admisecsgp_mstshift_shift_id
							   left join admisecsgp_mstzone zn on
						  ath.admisecsgp_mstzone_zone_id = zn.zone_id
							   left join admisecsgp_mstplant pl on
						  zn.admisecsgp_mstplant_plant_id = pl.plant_id
							   left join admisecsgp_mstusr usr on
						  usr.npk = ath.admisecsgp_mstusr_npk
					  where MONTH(ath.date_patroli) = " . $month . "
						and YEAR(ath.date_patroli) = " . $year . "
						" . $where . "
					  group by sh.nama_shift,
							   pl.plant_name,
							   ath.admisecsgp_mstusr_npk,
							   pl.plant_id,
							   shift_id,
							   ath.type_patrol,
							   usr.patrol_group) as p
				group by p.patrol_group, plant_name";

		return DB::select($sql);
	}

	public static function getDataPatroliByMonth($year, $month, $plantId)
	{
		$sql = "select DAY(s.start_at)                as day,
					   usr.patrol_group,
					   ISNULL(pl.plant_name, '-')     as plant_name,
					   ISNULL(s.total_ckp, 0)         as total_ckp,
					   ISNULL(s.chekpoint_patroli, 0) as chekpoint_patroli
				from admisecsgp_trans_jadwal_patroli jp
						 join admisecsgp_mstshift sh on sh.shift_id = jp.admisecsgp_mstshift_shift_id
						 join admisecsgp_mstplant pl on jp.admisecsgp_mstplant_plant_id = pl.plant_id
						 join admisecsgp_mstusr usr on jp.admisecsgp_mstusr_npk = usr.npk
						 join (select *,
									  (select count(am.checkpoint_id) as co
									   from admisecsgp_trans_zona_patroli zp
												join admisecsgp_mstzone z on z.zone_id = zp.admisecsgp_mstzone_zone_id
												join admisecsgp_mstplant mp on mp.plant_id = zp.admisecsgp_mstplant_plant_id
												join admisecsgp_mstckp am on z.zone_id = am.admisecsgp_mstzone_zone_id
									   where zp.status_zona = 1
										 and s.date_patroli = zp.date_patroli
										 and mp.plant_id = s.plant_id
										 and s.shift_id = zp.admisecsgp_mstshift_shift_id) as total_ckp
							   from (select ath.admisecsgp_mstusr_npk                           as npk,
											pl.plant_id,
											min(ALL ath.checkin_checkpoint)                     as start_at,
											max(ath.checkout_checkpoint)                        as end_at,
											sh.shift_id,
											count(atd.admisecsgp_mstobj_objek_id)               as target_object,
											SUM(IIF(atd.status = 0, 1, 0))                      as total_object_temuan,
											SUM(IIF(atd.status = 1, 1, 0))                      as total_object_normal,
											count(distinct ath.admisecsgp_mstckp_checkpoint_id) as chekpoint_patroli,
											ath.type_patrol,
											min(cast(ath.checkin_checkpoint as date))          as date_patroli
									 from admisecsgp_trans_headers ath
											  left join admisecsgp_trans_details atd
														on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
											  left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
											  left join admisecsgp_mstobj am on atd.admisecsgp_mstobj_objek_id = am.objek_id
											  left join admisecsgp_mstckp ckp on ath.admisecsgp_mstckp_checkpoint_id = ckp.checkpoint_id
											  left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
											  left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
									 where pl.plant_id = '" . $plantId . "'
									   and MONTH(ath.date_patroli) = " . $month . "
									   and YEAR(ath.date_patroli) = " . $year . "
									 group by sh.nama_shift, pl.plant_name, ath.admisecsgp_mstusr_npk, pl.plant_id,
											  shift_id, ath.type_patrol) as s) as s
							  on s.date_patroli = jp.date_patroli and s.shift_id = jp.admisecsgp_mstshift_shift_id and
								 s.plant_id = jp.admisecsgp_mstplant_plant_id and s.npk = jp.admisecsgp_mstusr_npk
				where pl.plant_id = '" . $plantId . "'
				  and MONTH(jp.date_patroli) = " . $month . "
				  and YEAR(jp.date_patroli) = " . $year . "
				order by jp.admisecsgp_mstplant_plant_id, jp.date_patroli, jp.admisecsgp_mstshift_shift_id";
		return DB::select($sql);
	}


	public static function getDataTemuan($plant_id = null, $status_temuan = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where .= "and pl.admisecsgp_mstsite_site_id ='" . $plant_id . "' ";
		}
		if ($status_temuan != null) {
			if ($status_temuan == 'open') {
				$where .= "and atd.status_temuan !=1";
			} else {
				$where .= "and atd.status_temuan = 1";
			}
		}

		$sqlDetail = " select usr.name                            as pelaksana,
							   pl.plant_name,
							   pl.plant_id,
							   zn.zone_name,
							   zn.zone_id,
							   ckp.checkpoint_id,
							   ckp.check_name                      as checkpoint_name,
							   sh.shift_id,
							   sh.nama_shift,
							   admisecsgp_mstobj_objek_id          as object_id,
							   am.nama_objek,
							   ath.admisecsgp_mstckp_checkpoint_id as chekpoint_id,
							   description,
							   image_1,
							   image_2,
							   image_3,							   
							   ath.date_patroli                      as date_patroli,
							   atd.trans_detail_id,
							   atd.status,
							   atd.status_temuan,
							   atd.note_tindakan_cepat,
							   atd.deskripsi_tindakan,
							   atd.updated_at
						from admisecsgp_trans_details atd
								 left join admisecsgp_trans_headers ath
										   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
								 left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
								 left join admisecsgp_mstobj am on atd.admisecsgp_mstobj_objek_id = am.objek_id
								 left join admisecsgp_mstckp ckp on ath.admisecsgp_mstckp_checkpoint_id = ckp.checkpoint_id
								 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
								 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
								 left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
						where atd.status = 0  and atd.is_tindakan_cepat !=1 " . $where . "
						order by atd.status_temuan, atd.created_at desc;";
		// return $this->db->query($sqlDetail)->result();
		return DB::select($sqlDetail);
	}

	public static function getDataTemuanTindakanCepat($plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where = "and pl.plant_id ='" . $plant_id . "'";
		}


		$sqlDetail = "  select usr.name                            as pelaksana,
							   pl.plant_name,
							   pl.plant_id,
							   zn.zone_name,
							   zn.zone_id,
							   ckp.checkpoint_id,
							   ckp.check_name                      as checkpoint_name,
							   sh.shift_id,
							   sh.nama_shift,
							   admisecsgp_mstobj_objek_id          as object_id,
							   am.nama_objek,
							   ath.admisecsgp_mstckp_checkpoint_id as chekpoint_id,
							   description,
							   image_1,
							   image_2,
							   image_3,							   
							   ath.date_patroli                      as date_patroli,
							   atd.trans_detail_id,
							   atd.status,
							   atd.status_temuan,
  							   atd.note_tindakan_cepat
						from admisecsgp_trans_details atd
								 left join admisecsgp_trans_headers ath
										   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
								 left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
								 left join admisecsgp_mstobj am on atd.admisecsgp_mstobj_objek_id = am.objek_id
								 left join admisecsgp_mstckp ckp on ath.admisecsgp_mstckp_checkpoint_id = ckp.checkpoint_id
								 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
								 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
								 left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
						where atd.status = 0 and atd.is_tindakan_cepat=1 and atd.created_at BETWEEN GETDATE()-7 AND GETDATE() " . $where . " 
						order by atd.status_temuan, atd.created_at desc;";
		return DB::select($sqlDetail);
	}
}
