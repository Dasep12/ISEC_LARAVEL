<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting\UsersModel;
use Modules\GuardTour\Entities\Company;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Role;
use Modules\GuardTour\Entities\Site;
use Modules\GuardTour\Entities\Users;
use Modules\GuardTour\Http\Controllers\SiteController;

class UserControllers extends Controller
{
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function index(): View
    {

        $data = [
            'link'     => '',
            'contents' => 'setting.users',
            'users'    => UsersModel::listUsers()->get()
        ];

        return view('template/template_first', $data);
    }

    public function form_add(): View
    {

        $data = [
            'link'     => '',
            'contents' => 'setting.add_users',
            'site'     => Site::all(),
            'role'      => Role::all(),
            'users'    => UsersModel::listUsers()->get()
        ];

        return view('template/template_first', $data);
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
            return redirect('setting/users')->with(['success' => 'Data Berhasil di Simpan']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Data Gagal di Simpan']);
        }
    }

    public function form_edit(Request $req)
    {
        $res = $req->id;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        $data = [
            'contents'  => 'setting.edit_users',
            'users'     => UsersModel::find($res),
            'uri'       => $uri,
            'data'      => Users::find($res),
            'site'      => Site::all(),
            'plant'     => Plants::where('status', 1)->get(),
            'role'      => Role::all(),
            'link'     => '',
        ];
        return view('template/template_first', $data);
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

        if ($req->password != null || !empty($req->password)) {
            $users->password = md5($req->password);
        }

        DB::beginTransaction();
        try {
            $users->save();
            DB::commit();
            return redirect('setting/users')->with(['success' => 'Data Berhasil di Perbarui']);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with(['success' => 'Data Berhasil di Perbarui']);
            DB::rollBack();
        }
    }

    public function delete(Request $request)
    {
        $id = $request->d;
        DB::beginTransaction();
        try {
            Users::where('npk', $id)->delete();
            DB::commit();
            return redirect('setting/users')->with(['success' => 'Data Berhasil di Hapus']);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with(['success' => 'Data Gagal di Hapus']);
            DB::rollBack();
        }
    }
}
