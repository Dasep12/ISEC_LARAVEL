<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Checkpoint;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Zona;



class CheckpointController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $check = new Checkpoint;
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::checkpoint/master_checkpoint', [
            'uri'        => $uri,
            'checkpoint' => $check->details()
        ]);
    }

    public function form_add()
    {
        $plant = new Plants();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::checkpoint/add_master_checkpoint', [
            'uri'         => $uri,
            'plants'      => $plant->details()->where('admisecsgp_mstcmp_company_id', Session('comp_id'))->get()
        ]);
    }

    public function insert(Request $req)
    {
        $req->validate([
            'check_no' => 'unique:admisecsgp_mstckp',
        ], [
            'check_no.unique' => 'kode nfc checkpoint sudah ada',
        ]);
        Checkpoint::create([
            'checkpoint_id'                   => 'ADMC' . substr(uniqid(rand(), true), 4, 4),
            'admisecsgp_mstzone_zone_id'      => $req->zone_id,
            'check_name'                      => strtoupper($req->check_name),
            'check_no'                        => $req->check_no,
            'durasi_batas_atas'               => $req->durasi_batas_atas,
            'durasi_batas_bawah'              => $req->durasi_batas_bawah,
            'others'                          => $req->others,
            'status'                          => $req->status,
            'created_at'                      => date('Y-m-d H:i:s'),
            'created_by'                      => Session('npk'),
        ]);
        return redirect()->route('checkpoint.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Checkpoint::where('checkpoint_id', $id)->delete();
        return redirect()->route('checkpoint.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $plant = new Plants();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::checkpoint/edit_master_checkpoint', [
            'uri'       => $uri,
            'plant_id'  => $req->z,
            'data'      => Checkpoint::with('zoneDetails')->where('checkpoint_id', $id[0])->first(),
            'plants'    => $plant->details()->where('admisecsgp_mstcmp_company_id', Session('comp_id'))->get(),
            'zona'      => Zona::where('admisecsgp_mstplant_plant_id', $req->z)->get()
        ]);
        // dd(Checkpoint::with('zoneDetails')->where('checkpoint_id', $id[0])->first());
    }

    public function update(Request $req)
    {
        $id    = $req->checkpoint_id;
        $check = Checkpoint::find($id);
        $check->check_name                 = $req->check_name;
        $check->check_no                   = $req->check_no;
        $check->admisecsgp_mstzone_zone_id = $req->zone_id;
        $check->status                     = $req->status;
        $check->others                     = $req->others;
        $check->durasi_batas_atas          = $req->durasi_batas_atas;
        $check->durasi_batas_bawah         = $req->durasi_batas_bawah;
        $check->updated_at                 = date('Y-m-d H:i:s');
        $check->updated_by                 = Session('npk');
        $check->save();
        return redirect()->route('checkpoint.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }

    public function getZona(Request $req)
    {
        $id = $req->id;
        return response()->json(['zona' => Zona::where('admisecsgp_mstplant_plant_id', $id)->get()]);
    }
}
