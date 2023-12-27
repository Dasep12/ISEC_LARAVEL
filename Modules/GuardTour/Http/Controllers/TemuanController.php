<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\LaporanPatroli;
use Modules\GuardTour\Entities\Plants;

class TemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $plant =  Session('role') == 'SUPERADMIN' ? Plants::where('status', 1)->get() : Plants::where([
            ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
            ['status', '=', 1],
        ])->get();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::laporan_temuan/form_temuan', [
            'uri'        => $uri,
            'plant'      => $plant
        ]);
    }

    public function list_temuan()
    {
        $data = LaporanPatroli::getDataTemuan();
        return response()->json($data);
    }


    public function abnormality()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::laporan_temuan/form_abnormality', [
            'uri'        => $uri,
        ]);
    }

    public function updateAbnormality(Request $req)
    {
        $idx = $req->idDetailTrans;
        $catatan = $req->catatan_tindakan;
        $updated = date('Y-m-d H:i:s');
        $sess = Session('npk');

        DB::beginTransaction();
        try {
            DB::update("UPDATE admisecsgp_trans_details SET status = 1 , updated_at = '$updated' , updated_by='$sess' , deskripsi_tindakan='$catatan' WHERE trans_detail_id = '$idx' ");
            DB::commit();
            return redirect()->back()->with(['success' => 'Data Berhasil di Update']);
        } catch (\Exeption $e) {
            DB::rollback();
            return redirect()->back()->with(['success' => 'Data Gagal di Update']);
        }
    }


    public function list_temuan_tindakan_cepat()
    {
        $data = LaporanPatroli::getDataTemuanTindakanCepat();
        return response()->json($data);
    }

    public function total_temuan()
    {
        $data['total_temuan'] = count(LaporanPatroli::getDataTemuan(null, 'open'));
        return response()->json($data);
    }
}
