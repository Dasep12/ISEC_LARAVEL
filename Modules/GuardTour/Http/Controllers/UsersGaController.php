<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Site;
use Modules\GuardTour\Entities\UsersGA;

class UsersGaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $user = new UsersGA();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::users_ga/master_users_ga', [
            'uri'     => $uri,
            'users'   => $user->details()->get()
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);

        return view('guardtour::users_ga/add_master_users_ga', [
            'uri'        => $uri,
            'plants'     => Plants::all(),
        ]);
    }

    public function insert(Request $req)
    {
        // $req->validate([
        //     'npk' => 'unique:admisecsgp_mstusr',
        // ], [
        //     'npk.unique' => 'npk sudah ada',
        // ]);
        UsersGA::create([
            'name'          => $req->nama,
            'email'         => $req->email,
            'type'                         => $req->type,
            'admisecsgp_mstplant_plant_id' => $req->plant_id,
            'status'                       => $req->status,
            'created_at'                   => date('Y-m-d H:i:s'),
            'created_by'                   => Session('npk')
        ]);
        return redirect()->route('users_ga.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        UsersGA::where('id', $id)->delete();
        return redirect()->route('users_ga.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        $user = new UsersGA();
        return view('guardtour::users_ga/edit_master_users_ga', [
            'uri'       => $uri,
            'data'      => $user->details()->where('id', $id[0])->first(),
            'plants'    => Plants::all(),
            'role'      => Plants::all(),
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->id;
        $users = UsersGA::find($id);
        $users->name                 = $req->nama;
        $users->type                 = $req->type;
        $users->email                 = $req->email;
        $users->admisecsgp_mstplant_plant_id = $req->plant_id;
        $users->status                     = $req->status;
        $users->updated_at                 = date('Y-m-d H:i:s');
        $users->updated_by                 = Session('npk');
        $users->save();
        return redirect()->route('users_ga.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }

    public function getPlant(Request $req)
    {
        $id = $req->id;
        return response()->json(['plant' => Plants::where('admisecsgp_mstsite_site_id', $id)->get()]);
    }
}
