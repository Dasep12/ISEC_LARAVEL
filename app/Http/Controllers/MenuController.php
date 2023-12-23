<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

use AuthHelper,FormHelper;

use Modules\Srs\Entities\DashboardModel;
use Modules\Srs\Entities\DashboardV2Model;

class MenuController extends Controller
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
        AuthHelper::checksession(session()->all());

        $data_area = DashboardV2Model::area();
        $current_year = date('Y');

        // FILTER AREA
        $opt_are_fil = array('' => '-- Choose --');
        foreach ($data_area as $key => $are) {
            $opt_are_fil[$are->id] = $are->title;
        }

        // FILTER BULAN
        $opt_mon= array('' => '-- Choose --');
        for($i = 1; $i <= 12; $i++) {
            $opt_mon[$i] = date("F", mktime(0, 0, 0, $i, 10));
        }

        // FILTER TAHUN
        // $firstYear = (int)date('Y') - 3; // - 84
        $firstYear = 2022;
        $lastYear = $firstYear + 5; // + 2
        $opt_yea = array('' => '-- Choose --');
        for($i=$firstYear;$i<=$lastYear;$i++)
        {
            $opt_yea[$i] = $i;
        }
        
        $data = [
            'link' => '',
            'contents' => 'default',
            'select_area_filter' => FormHelper::formDropdown('area_fil', $opt_are_fil, '','id="areaFilter" class="form-control" required'),
            'select_year_filter' => FormHelper::formDropdown('year_filter', $opt_yea, $current_year,'id="yearFilter" class="form-control" required'),
            'select_month_filter' => FormHelper::formDropdown('month_filter', $opt_mon,'','id="monthFilter" class="form-control" required'),
        ];
        
        return view('template/template_first', $data);
    }

	public function srsSoi(Request $req)
	{
        $res_iso = DashboardV2Model::grap_srs($req);
        $res_iso = json_decode(json_encode($res_iso), true);
        $res_soi = DashboardV2Model::grap_soi($req);
        $res_soi = json_decode(json_encode($res_soi), true);

        $arr = array(
            'data_index' => $res_iso[0]['max_iso'],
            'data_soi' => $res_soi[0]['avg_soi']
        );

        echo json_encode($arr, true);
	}

	public function srsMonth(Request $req)
	{
        $res_trans_month = DashboardV2Model::grap_trans_month($req);

        $gtm_arr = array();
        foreach ($res_trans_month as $key => $gtm) {
            $gtm_arr[] = $gtm->total;
        }

        echo json_encode($gtm_arr, true);
	}
    
	public function srsPerPlant(Request $req)
	{
        $res = DashboardV2Model::grap_trans_area($req);
        $res = json_decode(json_encode($res), true);

        $plantArr = array();
        $totalArr = array();
        foreach ($res as $key => $tar) {
            $plantArr[] = $tar['title'];
            $totalArr[] = $tar['total'];
        }

        $arr = array(
    		'plant' => $plantArr,
    		'total' => $totalArr,
    	);

        echo json_encode($arr, true);
	}

	public function srsRiskSource(Request $req)
	{
        $res = DashboardV2Model::grap_risk_source($req);
        $res = json_decode(json_encode($res), true);

        $rsouArr = array();
        foreach ($res as $key => $rsou) {
            $rsouArr[] = array(
                'id' => $rsou['id'],
                'label' => $rsou['title'],
                'total' => $rsou['total']
            );
        }

        echo json_encode($rsouArr, true);
	}

	public function srsTargetAssets(Request $req)
	{
        $res = DashboardV2Model::grap_target_assets($req);
        $res = json_decode(json_encode($res), true);

        $assArr = array();
        foreach ($res as $key => $ass) {
            $assArr[] = array(
                'id' => $ass['id'],
                'label' => $ass['title'],
                'total' => $ass['total']
            );
        }

        echo json_encode($assArr, true);
	}

	public function srsRisk(Request $req)
	{
        $res = DashboardV2Model::grap_risk($req);
        $res = json_decode(json_encode($res), true);

        $risArr = array();
        foreach ($res as $key => $ris) {
            $risArr[] = array(
                'id' => $ris['id'],
                'label' => $ris['title'],
                'total' => $ris['total']
            );
        }

        echo json_encode($risArr, true);
	}
}
