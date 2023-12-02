<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Modules\GuardTour\Entities\Plants;
use Modules\GuardTour\Entities\Role;
use Modules\GuardTour\Entities\Site;

class UsersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('log')->only('index');
        // $this->middleware('subscribed')->except('store');
        $this->middleware('is_login_isec');
    }

    public function index(): View
    {

        $data = [
            'link'  => '',
            'users' => UsersModel::getUsers(),
        ];

        return view('users/user', $data);
    }

    public function register()
    {
        $data = [
            'link'      => '',
            'users'     => UsersModel::getUsers(),
            'wilayah'   => Site::all(),
            'role'      => Role::all(),
            'groups'     => ["REGU_A", "REGU_B", "REGU_C", "REGU_D"]
        ];

        return view('users/register', $data);
    }

    public function getPlants(Request $req)
    {

        $data = Plants::where("admisecsgp_mstsite_site_id", $req->site_id)->get();
        return response()->json($data);
    }

    public function input(Request $req): RedirectResponse
    {

        $req->validate([
            'npk'         => 'required|unique:admisecsgp_mstusr',
        ]);

        $npk            = $req->input("npk");
        $name           = strtoupper($req->input("nama"));
        $email          = $req->input("email");
        $group          = $req->input("group");
        $id_role        = $req->input("level");
        $id_site        = $req->input("site_id");
        $id_plant       = $req->input("plant_id");
        $status         = $req->input("status");
        $password       = md5($req->input("password"));
        $user_name      = $req->input("user_name");
        DB::beginTransaction();
        try {

            $cari_company   = DB::select("select site_id , admisecsgp_mstcmp_company_id from admisecsgp_mstsite where site_id='" . $id_site  . "'");
            $id_comp = $cari_company[0]->admisecsgp_mstcmp_company_id;
            $data = [
                'npk'                             => $npk,
                'name'                            => $name,
                'email'                           => $email,
                'patrol_group'                    => $group,
                'admisecsgp_mstroleusr_role_id'   => $id_role,
                'admisecsgp_mstsite_site_id'      => $id_site,
                'admisecsgp_mstplant_plant_id'    => $id_plant,
                'admisecsgp_mstcmp_company_id'    => $id_comp,
                'password'                        => $password,
                'created_at'                      => date('Y-m-d H:i:s'),
                'created_by'                      => Session('npk'),
                'status'                          => $status,
                'user_name'                       => $user_name
            ];
            DB::table('admisecsgp_mstusr')->insert($data);
            DB::commit();
            return back()->with(["success" => 'Berhasil menambah data']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with(["failed" => 'Gagal menambah data']);
            // dd($e);
        }
    }
}
