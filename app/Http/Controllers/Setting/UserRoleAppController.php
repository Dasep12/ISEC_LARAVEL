<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting\UserRoleAppModel;

use AuthHelper,FormHelper;

class UserRoleAppController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function index(): View
    {
        
        $data = [
            'link' => '',
            'contents' => 'setting.userRoleApp',
        ];
        
        return view('template/template_first', $data);
    }

    public function listTable(Request $request)
    {
        $get_json_data = UserRoleAppModel::listTable($request);
         
        echo json_encode($get_json_data);
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
            $res = UserRoleAppModel::deleteData($req);

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