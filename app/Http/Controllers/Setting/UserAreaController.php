<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting\UserAreaModel;

use AuthHelper,FormHelper;

class UserAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function index(): View
    {
        $user = DB::connection('sqlsrv')
            ->table('admisecsgp_mstusr')
            ->select('npk', 'name')
            ->where('status',1)
            ->get();
        $site = DB::connection('sqlsrv')
            ->table('admisecsgp_mstsite')
            ->select('site_id', 'site_name')
            ->where('status',1)
            ->get();
        
        $data = [
            'link' => '',
            'user' => $user,
            'site' => $site,
            'contents' => 'setting.userArea',
        ];
        
        return view('template/template_first', $data);
    }

    public function listTable(Request $request)
    {
        $get_json_data = UserAreaModel::listTable($request);
         
        echo json_encode($get_json_data);
    }

    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'npk' => 'required',
            'site' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect()->back()->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak lengkap');
        }
        else
        {
            $res = UserAreaModel::insertData($req);

            if($res == '00')
            {
                return redirect()->back()->with('success', '<i class="icon fas fa-check"></i> Berhasil menghapus data');
            }
            else
            {
                return redirect()->back()->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            }

        }
    }

    public function delete(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect()->back()->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak lengkap');
        }
        else
        {
            $res = UserAreaModel::deleteData($req);

            if($res == '00')
            {
                return redirect()->back()->with('success', '<i class="icon fas fa-check"></i> Berhasil menghapus data');
            }
            else
            {
                return redirect()->back()->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            }

        }
    }
    

}