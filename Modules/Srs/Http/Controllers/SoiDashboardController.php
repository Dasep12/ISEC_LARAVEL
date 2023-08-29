<?php

namespace Modules\Srs\Http\Controllers;

use AuthHelper;
use FormHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Srs\Entities\SoiDashboardModel;

class SoiDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }
    
    public function index()
    {
        $data_area = SoiDashboardModel::area();

        $opt_are = array('' => '-- Area --');
        foreach ($data_area as $key => $are) {
            $opt_are[$are->id] = $are->title;
        }

        $opt_lev = array('' => '-- Level --');
        for($i = 1; $i <= 5; $i++) {
            $opt_lev[$i] = $i;
        }

        $opt_lev_com = array('' => '-- Level --');
        for($i = 1; $i <= 10; $i++) {
            $opt_lev_com[$i] = $i;
        }

        $opt_mon= array('' => '-- Month --');
        for($i = 1; $i <= 12; $i++) {
            $opt_mon[$i] = date("F", mktime(0, 0, 0, $i, 10));
        }

        $firstYear = 2022; // - 84
        $lastYear = $firstYear + 5; // + 2
        $opt_yea = array('' => '-- Year --');
        for($i=$firstYear;$i<=$lastYear;$i++)
        {
            $opt_yea[$i] = $i;
        }
        
        $data = [
            'link' => request()->segments()[1],
            'sub_link' => empty(request()->segments()[2]) ? '' : request()->segments()[2],
            'select_areas_filter' => FormHelper::formDropdown('area_filter', $opt_are,'','id="areaFilter" class="form-control" required'),
            'select_years_filter' => FormHelper::formDropdown('year_filter', $opt_yea, date('Y'),'id="yearFilter" class="form-control" required'),
            'select_months_filter' => FormHelper::formDropdown('month_filter', $opt_mon,'','id="monthFilter" class="form-control" required'),
        ];
        
        return view('srs::soidashboard', $data);
    }

    public function soiAvgPilar(Request $req)
    {
        $res_soi_avg_pilar = SoiDashboardModel::soiAvgPilar($req);
        echo json_encode($res_soi_avg_pilar, true);
    }

    public function soiThreatSoi(Request $req)
    {
        $res_threat_soi = SoiDashboardModel::threatSoi($req);

        echo json_encode($res_threat_soi, true);
    }

    public function soiAvgMonth(Request $req)
    {
        $res_soi_avg_month = SoiDashboardModel::soiAvgMonth($req);

        $peopleAvg = array();
        $systemAvg = array();
        $deviceAvg = array();
        $networkAvg = array();
        foreach ($res_soi_avg_month as $key => $savm) {
            $peopleAvg[] = $savm->avg_people;
            $systemAvg[] = $savm->avg_system;
            $deviceAvg[] = $savm->avg_device;
            $networkAvg[] = $savm->avg_network;
        }
        $grap_soi_average_month = array(
            array(
                'label' => 'PEOPLE',
                'data' => $peopleAvg,
                'borderColor' => "rgba(0, 176, 80, 1)",
                'backgroundColor' => "rgba(0, 176, 80, 1)",
            ),
            array(
                'label' => 'SYSTEM',
                'data' => $systemAvg,
                'borderColor' => "rgba(0, 176, 240, 1)",
                'backgroundColor' => "rgba(0, 176, 240, 1)",
            ),
            array(
                'label' => 'DEVICE',
                'data' => $deviceAvg,
                'borderColor' => "rgba(255, 0, 0, 1)",
                'backgroundColor' => "rgba(255, 0, 0, 1)",
            ),
            array(
                'label' => 'NETWORKING',
                'data' => $networkAvg,
                'borderColor' => "rgba(112, 48, 160, 1)",
                'backgroundColor' => "rgba(112, 48, 160, 1)",
            )
        );

        echo json_encode($grap_soi_average_month, true);
    }

    public function soiAvgAreaMonth(Request $req)
    {
        $res_soi_avg_area_month = SoiDashboardModel::soiAvgAreaMonth($req);
        $res_soi_avg_area_month = json_decode(json_encode($res_soi_avg_area_month), true);

        $area = array(); 
        $key = 'area';
        foreach($res_soi_avg_area_month as $val) {
            if(array_key_exists($key, $val)){
                $area[$val[$key]][] = $val;
            }else{
                $area[""][] = $val;
            }
        }

        $soi = array();
        $soi_item = array();
        $num = 1;
        foreach ($area as $key => $pcd) {
            $color = $this->getColor($num);

            foreach ($pcd as $i => $sva) {
                $soi_item[$i] = $sva['avgsoi'];
            }

            $soi[] = array(
                'label' => $key,
                'data' => $soi_item,
                'borderColor' => $color,
                'backgroundColor' => $color,
            );

            $num++;
        }

        echo json_encode($soi, true);
    }

    public function soiAvgAreaPillar(Request $req)
    {
        $res = SoiDashboardModel::soiAvgAreaPillar($req);
        $res = json_decode(json_encode($res), true);

        $people = array(); 
        $devices = array(); 
        $networks = array(); 
        $systems = array(); 
        $area = array(); 
        foreach ($res as $key => $pil) {
            $people[] = $pil['peoples'];
            $devices[] = $pil['devices'];
            $networks[] = $pil['networks'];
            $systems[] = $pil['systems'];
            $area[] = $pil['area'];
        }

        $data = array(
            'area' => $area,
            'data' => array(
                array(
                    'label' => 'People',
                    'data' => $people,
                    'borderColor' => "rgba(0, 176, 80, 1)",
                    'backgroundColor' => "rgba(0, 176, 80, 1)",
                ),
                array(
                    'label' => 'Device',
                    'data' => $devices,
                    'borderColor' => "rgba(255, 0, 0, 1)",
                    'backgroundColor' => "rgba(255, 0, 0, 1)",
                ),
                array(
                    'label' => 'Network',
                    'data' => $networks,
                    'borderColor' => "rgba(112, 48, 160, 1)",
                    'backgroundColor' => "rgba(112, 48, 160, 1)",
                ),
                array(
                    'label' => 'System',
                    'data' => $systems,
                    'borderColor' => "rgba(0, 176, 240, 1)",
                    'backgroundColor' => "rgba(0, 176, 240, 1)",
                ),
            )
        );

        echo json_encode($data, true);
    }
    
    private function getColor($num) {
        $hash = md5('color' . $num);

        return "rgb(".hexdec(substr($hash, 0, 2))." ,".hexdec(substr($hash, 2, 2)).", ".hexdec(substr($hash, 4, 2)).")";
    }
}