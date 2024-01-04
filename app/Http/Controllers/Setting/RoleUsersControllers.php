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

class RoleUsersControllers extends Controller
{
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function index(): View
    {

        $query = DB::select("SELECT * FROM admisecsgp_mstroleusr");
        $data = [
            'link'     => '',
            'contents' => 'setting.master_role_user.master',
            'role'     => $query
        ];

        return view('template/template_first', $data);
    }


    public function insert(Request $req)
    {

        try {
            $id_role        = 'ADMRL' . substr(uniqid(rand(), true), 4, 4);
            $data = [
                'role_id' => $id_role,
                'level'   => $req->level,
                'status' => $req->status,
                'created_by' => Session('npk'),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            DB::table('admisecsgp_mstroleusr')->insert($data);
            DB::commit();
            return redirect('setting/roleUser')->with(['success' => 'Data Berhasil di Simpan']);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with(['failed' => 'Data Gagal di Simpan']);
        }
    }


    public function update(Request $req)
    {
        $id    = $req->idx;


        DB::beginTransaction();
        try {
            DB::update("UPDATE admisecsgp_mstroleusr SET level = '$req->level2' , updated_by = '" . Session('npk') . "' , updated_at = '" . date('Y-m-d H:i:s') . "' WHERE role_id = '$id' ");
            DB::commit();
            return redirect('setting/roleUser')->with(['success' => 'Data Berhasil di Perbarui']);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with(['success' => 'Data Gagal di Perbarui']);
            // DB::rollBack();
        }
    }

    public function delete(Request $request)
    {
        $id = $request->d;
        DB::beginTransaction();
        try {
            DB::delete("DELETE FROM admisecsgp_mstroleusr WHERE role_id = '$id' ");
            DB::commit();
            return redirect('setting/roleUser')->with(['success' => 'Data Berhasil di Hapus']);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with(['success' => 'Data Gagal di Hapus']);
            DB::rollBack();
        }
    }
}
