<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\KategoriObjek;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Zona;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::kategoriobjek/master_kobjek', [
            'uri'        => $uri,
            'kategori'   => KategoriObjek::all()
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::kategoriobjek/add_master_kobjek', [
            'uri'         => $uri,
        ]);
    }

    public function insert(Request $req)
    {
        $req->validate([
            'kategori_name' => 'unique:admisecsgp_mstkobj',
        ], [
            'kategori_name.unique' => 'nama kategori sudah ada',
        ]);
        KategoriObjek::create([
            'kategori_id'                 => 'ADMKO' . substr(uniqid(rand(), true), 4, 4),
            'status'                      => $req->status,
            'others'                      => $req->others,
            'kategori_name'               => strtoupper($req->kategori_name),
            'created_at'                  => date('Y-m-d H:i:s'),
            'created_by'                  => Session('npk'),
        ]);
        return redirect()->route('kategori_objek.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        KategoriObjek::where('kategori_id', $id)->delete();
        return redirect()->route('kategori_objek.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::kategoriobjek/edit_master_kobjek', [
            'uri'       => $uri,
            'data'      => KategoriObjek::where('kategori_id', $id[0])->first(),
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->kategori_id;
        $kategori = KategoriObjek::find($id);
        $kategori->kategori_name              = $req->kategori_name;
        $kategori->status                     = $req->status;
        $kategori->others                     = $req->others;
        $kategori->updated_at                 = date('Y-m-d H:i:s');
        $kategori->updated_by                 = Session('npk');
        $kategori->save();
        return redirect()->route('kategori_objek.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }
}
