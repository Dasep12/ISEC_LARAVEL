<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Checkpoint;
use Modules\GuardTour\Entities\KategoriObjek;
use Modules\GuardTour\Entities\Objek;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Zona;

class ObjekController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        $objek = new Objek();
        return view('guardtour::objek/master_objek', [
            'uri'        => $uri,
            'objek'   => $objek->details()->get(),

        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        $plant = new Plants();
        return view('guardtour::objek/add_master_objek', [
            'uri'         => $uri,
            'plant'    => $plant->details()->where('admisecsgp_mstcmp_company_id', Session('comp_id'))->get(),
            'kategori'  => KategoriObjek::all()
        ]);
    }

    public function insert(Request $req)
    {
        $req->validate([
            'nama_objek' => 'unique:admisecsgp_mstobj',
        ], [
            'nama_objek.unique' => 'nama kategori sudah ada',
        ]);
        Objek::create([
            'objek_id'                          => 'ADMO' . substr(uniqid(rand(), true), 4, 4),
            'nama_objek'                        => strtoupper($req->nama_objek),
            'admisecsgp_mstckp_checkpoint_id'   => $req->check_id,
            'admisecsgp_mstkobj_kategori_id'    => $req->kategori_id,
            'status'                            => $req->status,
            'others'                            => $req->others,
            'created_at'                        => date('Y-m-d H:i:s'),
            'created_by'                        => Session('npk'),
        ]);
        return redirect()->route('objek.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Objek::where('objek_id', $id)->delete();
        return redirect()->route('objek.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        $plant = new Plants();
        $objek = new Objek();
        return view('guardtour::objek/edit_master_objek', [
            'uri'       => $uri,
            'data'      => $objek->details()->where('objek_id', $id[0])->first(),
            'plant'     => $plant->details()->where('admisecsgp_mstcmp_company_id', Session('comp_id'))->get(),
            'kategori'  => KategoriObjek::all()

        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->objek_id;
        $objek = Objek::find($id);
        $objek->nama_objek                       = strtoupper($req->nama_objek);
        $objek->admisecsgp_mstckp_checkpoint_id  = $req->check_id;
        $objek->admisecsgp_mstkobj_kategori_id   = $req->kategori_id;
        $objek->status                           = $req->status;
        $objek->others                           = $req->others;
        $objek->updated_at                       = date('Y-m-d H:i:s');
        $objek->updated_by                       = Session('npk');
        $objek->save();
        return redirect()->route('objek.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }

    public function getZona(Request $req)
    {
        $id = $req->id;
        return response()->json(['zona' => Zona::where('admisecsgp_mstplant_plant_id', $id)->get()]);
    }

    public function getCheckpoint(Request $req)
    {
        $id = $req->id;
        return response()->json(['check' => Checkpoint::where('admisecsgp_mstzone_zone_id', $id)->get()]);
    }
}
