<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

use App\Models\AuthModel;

class AuthController extends Controller
{
    public function index(): View
    {
        // $request->session()->flash('error', 'Password salah');

        return view('login');
    }

    public function check(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return redirect("/")->with(["error" => $validator]);
        }

        $res = collect(AuthModel::check($request));

        if($res->isEmpty())
        {
            return redirect("/")->with(["error" => $validator]);
        }

        if(md5($request->input('password')) !== $res[0]->password)
        {
            return back()->with(["error" => 'Password tidak sesuai'])->onlyInput('username');
        }

        session([
            'id_token' => $res[0]->npk,
            'npk' => $res[0]->npk,
            'name' => $res[0]->name,
            'role' => $res[0]->level,
            'site_id' => $res[0]->admisecsgp_mstsite_site_id,
            'plant_id' => $res[0]->admisecsgp_mstplant_plant_id,
            'wil_id' => $res[0]->id_wilayah,
            'log_key' => 'isLoginIsec',
        ]);

        // dd($res);
        
        // $request->session()->flash('error', 'Password salah');
        
        return redirect('/menu');
    }
}
