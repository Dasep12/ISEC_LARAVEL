<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\Checkpoint;
use Modules\GuardTour\Entities\Event;
use Modules\GuardTour\Entities\KategoriObjek;
use Modules\GuardTour\Entities\Settings;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::settings/master_settings', [
            'uri'        => $uri,
            'setting'   => Settings::all(),
        ]);
    }

    public function form_add()
    {
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::settings/add_master_settings', [
            'uri'         => $uri,
            'kategori'  => KategoriObjek::all()
        ]);
    }

    public function insert(Request $req)
    {
        Settings::create([
            ''
        ]);
        return redirect()->route('settings.master')->with(['success' => 'Data Berhasil di Simpan']);
    }

    public function destroy(Request $request)
    {
        $id = $request->d;
        Event::where('event_id', $id)->delete();
        return redirect()->route('settings.master')->with(['success' => 'Data Berhasil di Hapus']);
    }


    public function form_edit(Request $req)
    {
        $res = $req->d;
        $id = explode("&", $res);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::settings/edit_master_settings', [
            'uri'       => $uri,
            'data'      => Settings::where('id_setting', $id[0])->first(),
        ]);
    }

    public function update(Request $req)
    {
        $id      = $req->id;
        $setting = Settings::find($id);
        $setting->nama_setting  = strtoupper($req->nama_setting);
        $setting->status        = $req->status;
        $setting->type          = $req->type;
        $setting->unit          = $req->unit;
        $setting->updated_at    = date('Y-m-d H:i:s');
        $setting->updated_by    = Session('npk');
        $setting->save();
        return redirect()->route('settings.master')->with(['success' => 'Data Berhasil di Perbarui']);
    }
}
