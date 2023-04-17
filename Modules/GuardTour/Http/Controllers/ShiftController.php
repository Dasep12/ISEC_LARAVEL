<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Shift;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::shift/master_shift', [
            'uri'        => $uri,
            'shift'   => Shift::all()
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::shift/add_master_shift', [
            'uri'         => $uri,
        ]);
    }

    public function insert(Request $req)
    {
        $req->validate([
            'nama_shift' => 'unique:admisecsgp_mstshift',
        ], [
            'nama_shift.unique' => 'nama shift sudah ada',
        ]);
        Shift::create([
            'shift_id'         => 'ADMSH' . substr(uniqid(rand(), true), 4, 4),
            'status'           => $req->status,
            'nama_shift'       => $req->shift,
            'jam_masuk'        => $req->jam_masuk,
            'jam_pulang'       => $req->jam_pulang,
            'created_at'                  => date('Y-m-d H:i:s'),
            'created_by'                  => Session('npk'),
        ]);
        return redirect()->route('shift.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Shift::where('shift_id', $id)->delete();
        return redirect()->route('shift.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::shift/edit_master_shift', [
            'uri'       => $uri,
            'data'      => Shift::where('shift_id', $id[0])->first(),
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->shift_id;
        $shift = Shift::find($id);
        $shift->status            = $req->status;
        $shift->nama_shift        = $req->shift;
        $shift->jam_masuk         = $req->jam_masuk;
        $shift->jam_pulang        = $req->jam_pulang;
        $shift->updated_at        = date('Y-m-d H:i:s');
        $shift->updated_by        = Session('npk');
        $shift->save();
        return redirect()->route('shift.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }
}
