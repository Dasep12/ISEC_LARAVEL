<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Role;
use Modules\GuardTour\Entities\Site;
use Modules\GuardTour\Entities\Users;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $user = new Users();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::users/master_users', [
            'uri'     => $uri,
            'users'   => $user->details()->get()
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);

        return view('guardtour::users/add_master_users', [
            'uri'       => $uri,
            'site'      => Site::all(),
            'role'      => Role::all()
        ]);
    }

    public function insert(Request $req)
    {
        $req->validate([
            'npk' => 'unique:admisecsgp_mstusr',
        ], [
            'npk.unique' => 'npk sudah ada',
        ]);
        Users::create([
            'npk'                             => $req->npk,
            'name'                            => $req->name,
            'email'                           => $req->email,
            'patrol_group'                    => $req->group,
            'admisecsgp_mstroleusr_role_id'   => $req->id_role,
            'admisecsgp_mstsite_site_id'      => $req->id_site,
            'admisecsgp_mstplant_plant_id'    => $req->id_plant,
            'admisecsgp_mstcmp_company_id'    => $req->id_comp,
            'password'                        => $req->password,
            'created_at'                      => date('Y-m-d H:i:s'),
            'created_by'                      => $this->session->userdata('id_token'),
            'status'                          => $req->status,
            'user_name'                       => $req->user_name
        ]);
        return redirect()->route('users.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Users::where('npk', $id)->delete();
        return redirect()->route('users.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::users/edit_master_users', [
            'uri'       => $uri,
            'data'      => Users::with('plantDetails')->where('npk', $id[0])->first(),
            'site'      => Site::all()
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->npk;
        $zona = Users::find($id);
        $zona->zone_name                 = $req->zone_name;
        $zona->kode_users                 = $req->kode_users;
        $zona->admisecsgp_mstplant_plant_id = $req->plant_id;
        $zona->status                     = $req->status;
        $zona->others                     = $req->others;
        $zona->updated_at                 = date('Y-m-d H:i:s');
        $zona->updated_by                 = Session('npk');
        $zona->save();
        return redirect()->route('users.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }

    public function getPlant(Request $req)
    {
        $id = $req->id;
        return response()->json(['plant' => Plants::where('admisecsgp_mstsite_site_id', $id)->get()]);
    }
}
