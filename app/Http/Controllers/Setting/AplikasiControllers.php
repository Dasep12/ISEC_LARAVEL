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

class AplikasiControllers extends Controller
{
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function index(): View
    {

        $query = DB::select("SELECT * FROM admisec_apps");
        $data = [
            'link'     => '',
            'contents' => 'setting.master_aplikasi.master',
            'aplikasi'     => $query
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

        try {

            $data = [
                'name' => $req->name_apps,
                'code' => $req->code_apps,
                'status' => 1,
                'created_by' => Session('npk'),
            ];

            DB::table('admisec_apps')->insert($data);

            DB::commit();
            return redirect('setting/masterApp')->with(['success' => 'Data Berhasil di Simpan']);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with(['failed' => 'Data Gagal di Simpan']);
        }
    }




    public function update(Request $req)
    {
        $id    = $req->id_apps;


        DB::beginTransaction();
        try {
            DB::update("UPDATE admisec_apps SET name = '$req->name_apps1' , code = '$req->code_apps1' WHERE id = '$id' ");
            DB::commit();
            return redirect('setting/masterApp')->with(['success' => 'Data Berhasil di Perbarui']);
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
            DB::delete("DELETE FROM admisec_apps WHERE id = '$id' ");
            DB::commit();
            return redirect('setting/masterApp')->with(['success' => 'Data Berhasil di Hapus']);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with(['success' => 'Data Gagal di Hapus']);
            DB::rollBack();
        }
    }
}
