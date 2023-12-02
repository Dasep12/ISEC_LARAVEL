<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\Company;
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

        try {
            $site = Site::find($req->site_id)->first();
            $cmp = Company::find($site->admisecsgp_mstcmp_company_id)->first();
            Users::create([
                'npk'                             => $req->npk,
                'name'                            => strtoupper($req->nama),
                'email'                           => $req->email,
                'patrol_group'                    => $req->group,
                'admisecsgp_mstroleusr_role_id'   => $req->level,
                'admisecsgp_mstsite_site_id'      => $req->site_id,
                'admisecsgp_mstplant_plant_id'    => $req->plant_id,
                'admisecsgp_mstcmp_company_id'    => $cmp->company_id,
                'password'                        => md5($req->password),
                'created_at'                      => date('Y-m-d H:i:s'),
                'created_by'                      => Session('npk'),
                'status'                          => $req->status,
                'user_name'                       => $req->user_name
            ]);

            DB::commit();
            return redirect()->route('users.master')->with(['success' => 'Data Berhasil di Simpan']);
        } catch (\Exception $e) {
            dd($e);
        }
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
        // dd($res);
        return view('guardtour::users/edit_master_users', [
            'uri'       => $uri,
            'data'      => Users::find($res),
            'site'      => Site::all(),
            'plant'     => Plants::all(),
            'role'      => Role::all()
        ]);
    }

    public function update(Request $req)
    {
        $id    = $req->npk;
        $users = Users::find($id);
        $users->name                             = $req->nama;
        $users->admisecsgp_mstroleusr_role_id    = $req->level;
        $users->admisecsgp_mstsite_site_id       = $req->site_id;
        $users->patrol_group                     = $req->group;
        $users->admisecsgp_mstplant_plant_id     = $req->plant_id;
        $users->status                           = $req->status;
        $users->email                            = $req->email;
        $users->user_name                        = $req->user_name;
        $users->updated_at                       = date('Y-m-d H:i:s');
        $users->updated_by                       = Session('npk');
        $users->save();
        return redirect()->route('users.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }

    public function getPlant(Request $req)
    {
        $id = $req->id;
        return response()->json(['plant' => Plants::where('admisecsgp_mstsite_site_id', $id)->get()]);
    }
}
