<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Produksi;


class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::produksi/master_produksi', [
            'uri'        => $uri,
            'produksi'   => Produksi::all(),
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::produksi/add_master_produksi', [
            'uri'         => $uri,
        ]);
    }

    public function insert(Request $req)
    {
        Produksi::create([
            'produksi_id'      => 'ADMP' . substr(uniqid(rand(), true), 4, 4),
            'status'           => $req->status,
            'name'             => strtoupper($req->name),
            'created_at'       => date('Y-m-d H:i:s'),
            'created_by'       => Session('npk'),
        ]);
        return redirect()->route('produksi.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Produksi::where('produksi_id', $id)->delete();
        return redirect()->route('produksi.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::produksi/edit_master_produksi', [
            'uri'       => $uri,
            'data'      => Produksi::where('produksi_id', $id[0])->first(),
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->produksi_id;
        $produksi = Produksi::find($id);
        $produksi->name                     = strtoupper($req->name);
        $produksi->status                   = $req->status;
        $produksi->updated_at               = date('Y-m-d H:i:s');
        $produksi->updated_by               = Session('npk');
        $produksi->save();
        return redirect()->route('produksi.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }
}
