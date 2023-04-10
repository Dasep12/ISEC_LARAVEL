<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Company;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Site;



class PlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $plant = new Plants;
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::plant/master_plant', [
            'uri'    => $uri,
            'plant' => $plant->details()->where('admisecsgp_mstcmp_company_id', Session('comp_id'))->get()
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);

        return view('guardtour::plant/add_master_plant', [
            'uri'       => $uri,
            'company'   => Company::all()
        ]);
    }

    public function insert(Request $req)
    {
        $req->validate([
            'plant_name' => 'unique:admisecsgp_mstplant',
        ], [
            'plant_name.unique' => 'nama plant sudah ada',
        ]);
        Plants::create([
            'plant_id'                    => 'ADMP' . substr(uniqid(rand(), true), 4, 4),
            'admisecsgp_mstsite_site_id'  => $req->site_id,
            'plant_name'                  => strtoupper($req->plant_name),
            'kode_plant'                  => strtoupper($req->kodeplant),
            'created_at'                  => date('Y-m-d H:i:s'),
            'created_by'                  => 229529,
            'status'                      => $req->status,
            'others'                      => $req->others,
        ]);
        return redirect()->route('plant.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Plants::where('plant_id', $id)->delete();
        return redirect()->route('plant.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::plant/edit_master_plant', [
            'uri'       => $uri,
            'data'      => Plants::with('siteDetails')->where('plant_id', $id[0])->first(),
            'company'   => Company::all()
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->plant_id;
        $plant = Plants::find($id);
        $plant->plant_name                 = $req->plant_name;
        $plant->kode_plant                 = $req->kode_plant;
        $plant->admisecsgp_mstsite_site_id = $req->site_id;
        $plant->status                     = $req->status;
        $plant->others                     = $req->others;
        $plant->save();
        return redirect()->route('plant.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }

    public function getWilayah(Request $req)
    {
        $id = $req->id;
        return response()->json(['wilayah' => Site::where('admisecsgp_mstcmp_company_id', $id)->get()]);
    }
}
