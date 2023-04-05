<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Company;

class CompanyController extends Controller
{
    //
    public function master()
    {
        $company = Company::all();
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::company/master_cmp', [
            'uri'  => $uri,
            'company' => $company
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::company/add_master_company', [
            'uri'  => $uri,
        ]);
    }

    public function insert(Request $req)
    {
        $name = $req->comp_name;
        $telp = $req->comp_phone;
        $status = $req->status;
        $address = $req->address1;
        $req->validate([
            'comp_name' => 'unique:admisecsgp_mstcmp',
        ], [
            'comp_name.unique' => 'Nama Perusahaan Sudah Ada    '
        ]);
        Company::create([
            'company_id'      => 'ADMCMP' . substr(uniqid(rand(), true), 4, 4),
            'comp_name'       => $name,
            'comp_phone'      => $telp,
            'address1'        => $address,
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by'      => 229529,
            'status'          => $status
        ]);
        return redirect()->route('company.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Company::where('company_id', $id)->delete();
        return redirect()->route('company.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        $company = Company::where('company_id', $id[0])->first();
        return view('guardtour::company/edit_master_company', [
            'uri'  => $uri,
            'data' => $company
        ]);
    }

    public function update(Request $req)
    {
        $id = $req->comp_id;
        $company = Company::find($id);
        $company->comp_name  = $req->comp_name;
        $company->comp_phone = $req->comp_phone;
        $company->address1    = $req->address1;
        $company->status   = $req->status;
        $company->save();
        return redirect()->route('company.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }
}
