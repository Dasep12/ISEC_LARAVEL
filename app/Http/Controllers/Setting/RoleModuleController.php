<?php

namespace App\Http\Controllers\setting;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting\RoleModuleModel;

use AuthHelper,FormHelper;

class RoleModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function index(): View
    {
        
        $data = [
            'link' => '',
            'contents' => 'setting.roleModule',
        ];
        
        return view('template/template_first', $data);
    }

    public function listTable(Request $request)
    {
        $get_json_data = RoleModuleModel::listTable($request);
         
        echo json_encode($get_json_data);
    }

    public function edit(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $id = $req->input('id');

            $get_json_data = DB::connection('sqlsrv')
                ->table('admisec_modules_roles')
                ->select('id','crt','red','edt','dlt','apr','rjc')
                ->where('id', $id)
                ->first();
            
            echo json_encode($get_json_data);
        }
    }

    public function roleUpdate(Request $req)
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
            $id = $req->input('id');
            $field = array();
            $field['crt'] = ($create = $req->input('create') == 'on') ?  1 : 0;
            $field['red'] = ($read = $req->input('read') == 'on') ? 1 : 0;
            $field['edt'] = ($edit = $req->input('edit') == 'on') ? 1 : 0;
            $field['dlt'] = ($delete = $req->input('delete') == 'on') ? 1 : 0;
            $field['apr'] = ($approve = $req->input('approve') == 'on') ? 1 : 0;
            $field['rjc'] = ($reject = $req->input('reject') == 'on') ? 1 : 0;
            // dd($field);

            $res = DB::connection('sqlsrv')
            ->table('admisec_modules_roles')
            ->where('id',$id)
            ->update($field);

            if($res)
            {
                return redirect()->back()->with('success', '<i class="icon fas fa-check"></i> Berhasil perbarui data');
            }
            else
            {
                return redirect()->back()->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal perbarui data');
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
            $res = RoleModuleModel::deleteData($req);

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