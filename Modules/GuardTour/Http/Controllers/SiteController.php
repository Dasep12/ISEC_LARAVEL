<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Company;
use Modules\GuardTour\Entities\Site;

class SiteController extends Controller
{
    //
    public function master()
    {
        $site = Site::with('company')->orderBy('site_name')->get();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::site/master_site', [
            'uri'  => $uri,
            'site' => $site
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);

        return view('guardtour::site/add_master_site', [
            'uri'       => $uri,
            'company'   => Company::all()
        ]);
    }

    public function insert(Request $req)
    {
        $req->validate([
            'site_name' => 'unique:admisecsgp_mstsite',
            'site_id'   => 'unique:admisecsgp_mstsite'
        ], [
            'site_name.unique' => 'nama wilayah sudah ada',
            'site_id.unique' => 'id sudah ada'
        ]);
        Site::create([
            'site_id'                           => 'ADMST' . substr(uniqid(rand(), true), 4, 4),
            'admisecsgp_mstcmp_company_id'      => $req->comp_id,
            'site_name'                         => strtoupper($req->site_name),
            'others'                            => $req->others,
            'created_at'                        => date('Y-m-d H:i:s'),
            'created_by'                        => 229529,
            'status'                            => $req->status
        ]);
        return redirect()->route('site.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Site::where('site_id', $id)->delete();
        return redirect()->route('site.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::site/edit_master_site', [
            'uri'       => $uri,
            'data'      => Site::where('site_id', $id[0])->first(),
            'company'   => Company::all()
        ]);
    }

    public function update(Request $req)
    {
        $id = $req->site_id;
        $site = Site::find($id);
        $site->site_name  = $req->site_name;
        $site->admisecsgp_mstcmp_company_id = $req->comp_id;
        $site->status   = $req->status;
        $site->others   = $req->others;
        $site->save();
        return redirect()->route('site.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }
}
