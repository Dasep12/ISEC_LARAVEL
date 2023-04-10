<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Company;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Zona;
use Modules\GuardTour\Entities\Site;



class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $zona = new Zona;
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::zona/master_zona', [
            'uri'    => $uri,
            'zona' => $zona->details()->where('admisecsgp_mstcmp_company_id', Session('comp_id'))->get()
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);

        return view('guardtour::zona/add_master_zona', [
            'uri'       => $uri,
            'site'      => Site::where('admisecsgp_mstcmp_company_id', Session('comp_id'))->get()
        ]);
    }

    public function insert(Request $req)
    {
        $req->validate([
            'kode_zona' => 'unique:admisecsgp_mstzone',
        ], [
            'kode_zona.unique' => 'kode zona sudah ada',
        ]);
        Zona::create([
            'zone_id'                          => 'ADMZ' . substr(uniqid(rand(), true), 4, 4),
            'admisecsgp_mstplant_plant_id'     => $req->plant_id,
            'zone_name'                        => strtoupper($req->zone_name),
            'kode_zona'                        => strtoupper($req->kode_zona),
            'others'                           => strtoupper($req->others),
            'status'                           => $req->status,
            'created_at'                       => date('Y-m-d H:i:s'),
            'created_by'                       => Session('npk'),
        ]);
        return redirect()->route('zona.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Zona::where('zone_id', $id)->delete();
        return redirect()->route('zona.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::zona/edit_master_zona', [
            'uri'       => $uri,
            'data'      => Zona::with('plantDetails')->where('zone_id', $id[0])->first(),
            'site'      => Site::all()
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->zone_id;
        $zona = Zona::find($id);
        $zona->zone_name                 = $req->zone_name;
        $zona->kode_zona                 = $req->kode_zona;
        $zona->admisecsgp_mstplant_plant_id = $req->plant_id;
        $zona->status                     = $req->status;
        $zona->others                     = $req->others;
        $zona->updated_at                 = date('Y-m-d H:i:s');
        $zona->updated_by                 = Session('npk');
        $zona->save();
        return redirect()->route('zona.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }

    public function getPlant(Request $req)
    {
        $id = $req->id;
        return response()->json(['plant' => Plants::where('admisecsgp_mstsite_site_id', $id)->get()]);
    }
}
