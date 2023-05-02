<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Role;



class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::role/master_role', [
            'uri'     => $uri,
            'role'   => Role::all(),

        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::role/add_master_role', [
            'uri'         => $uri,
            'kategori'  => KategoriObjek::all()
        ]);
    }

    public function insert(Request $req)
    {
        Event::create([
            'event_id'                       => 'ADMEV' . substr(uniqid(rand(), true), 4, 4),
            'status'                         => $req->status,
            'event_name'                     => strtoupper($req->event_name),
            'admisecsgp_mstkobj_kategori_id' => $req->kategori_id,
            'created_at'                     => date('Y-m-d H:i:s'),
            'created_by'                     => Session('npk'),
        ]);
        return redirect()->route('event.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Event::where('event_id', $id)->delete();
        return redirect()->route('event.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        $event = new Event();
        return view('guardtour::role/edit_master_role', [
            'uri'       => $uri,
            'data'      => $event->details()->where('event_id', $id[0])->first(),
            'kategori'  => KategoriObjek::all()
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->event_id;
        $event = Event::find($id);
        $event->event_name                     = strtoupper($req->event_name);
        $event->status                         = $req->status;
        $event->admisecsgp_mstkobj_kategori_id = $req->kategori_id;
        $event->updated_at                     = date('Y-m-d H:i:s');
        $event->updated_by                     = Session('npk');
        $event->save();
        return redirect()->route('event.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }
}
