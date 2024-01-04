<?php

namespace Modules\Srs\Http\Controllers;

use AuthHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Srs\Entities\DashboardModel;

class DashboardController extends Controller
{
    public function __construct()
    {
        // AuthHelper::checksession(session()->all());
        $this->middleware('is_login_isec');
    }

    public function index(Request $request)
    {
        $user_npk = AuthHelper::user_npk();

        $data_area = DashboardModel::area();
        $risk = DashboardModel::risk();
        $target_assets = DashboardModel::target_assets();
        $grap_risk = DashboardModel::grap_risk($request);
        $grap_risk_source = DashboardModel::grap_risk_source($request);
        $grap_trans_month = DashboardModel::grap_trans_month($request);
        $grap_trans_area = DashboardModel::grap_trans_area($request);
        $grap_trans = DashboardModel::grap_trans($request);
        $grap_target_assets = DashboardModel::grap_target_assets($request);
        $res_iso = DashboardModel::grap_srs($request);
        $res_soi = DashboardModel::grap_soi($request);
        $res_soi_avg_month = DashboardModel::grap_soi_avg_month($request);
        $res_soi_avgpilar = DashboardModel::grap_soi_avgpilar($request);
        $res_soi_montharea = DashboardModel::grap_soi_avg_montharea($request);
        $current_year = date('Y');

        // FILTER AREA
        $opt_are_fil = ['' => '-- Choose --'];
        foreach ($data_area as $key => $are) {
            $opt_are_fil[$are->id] = $are->title;
        }

        // FILTER TAHUN
        $firstYear = 2022;
        $lastYear = $firstYear + 5; // + 2
        $opt_year = [];
        for($i=$firstYear;$i<=$lastYear;$i++)
        {
            $opt_year[$i] = $i;
        }

        // FILTER BULAN
        $opt_mon = [];
        for($i = 1; $i <= 12; $i++) {
            $opt_mon[$i] = date("F", mktime(0, 0, 0, $i, 10));
        }

        // RISK SOURCE DATA
        $rsouArr = array();
        foreach ($grap_risk_source as $key => $rsou) {
            // $rsouArr[] = $rsou['total;
            $rsouArr[] = array(
                'id' => $rsou->id,
                'label' => $rsou->title,
                'data' => $rsou->total
            );
        }

        // RISK
        $risTotalArr = array();
        foreach ($grap_risk as $key => $rit) {
            // $risTotalArr[] = $rit['total;
            $risTotalArr[] = array(
                'id' => $rit->id,
                'label' => $rit->title,
                'data' => $rit->total
            );
        }

        // TARGET ASSETS DATA
        $tarArr = array();
        foreach ($grap_target_assets as $key => $tar) {
            // $tarArr[] = $tar->total;
            $tarArr[] = array(
                'id' => $tar->id,
                'label' => $tar->title,
                'data' => $tar->total
            );
        }

        // TRANS MONTH DATA
        $gtm_arr = array();
        foreach ($grap_trans_month as $key => $gtm) {
            $gtm_arr[] = $gtm->total;
        }

        // AREA LEGEND
        $legend_area = array();
        foreach ($data_area as $key => $lar) {
            $legend_area[] = $lar->title;
        }

        // AREA DATA GRAP
        $tar_arr = array();
        foreach ($grap_trans_area as $key => $tar) {
            $tar_arr[] = $tar->total;
        }

        // TRANS DATA GRAP //
        $tra_arr = array();
        foreach ($grap_trans as $key => $tra) {
            $tra_arr[] = $tra->total;
        }
        $tra_arr[] = 5;
        // TRANS DATA GRAP //

        // SOI AVERAGE MONTH //
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
            'people' => json_encode($peopleAvg,true),
            'system' => json_encode($systemAvg,true),
            'device' => json_encode($deviceAvg,true),
            'network' => json_encode($networkAvg,true),
        );
        // SOI AVERAGE MONTH //

        // SOI AREA MONTH //
        $soiAreaGroup = array();
        $soiArea = array();
        foreach ($res_soi_montharea as $key => $soig) {
            $soiAreaGroup[$soig->label][] = $soig;
        }
        foreach ($soiAreaGroup as $key => $soia) {
            $soiArea[] = $soia;
        }
        $sorAvgArea = array(
            'plant_1' => json_encode(self::get_data($soiArea[0]),true),
            'plant_2' => json_encode(self::get_data($soiArea[1]),true),
            'plant_3' => json_encode(self::get_data($soiArea[2]),true),
            'plant_4' => json_encode(self::get_data($soiArea[3]),true),
            'plant_5' => json_encode(self::get_data($soiArea[4]),true),
            'vlc' => json_encode(self::get_data($soiArea[5]),true),
            'head_office' => json_encode(self::get_data($soiArea[6]),true),
            'part_center' => json_encode(self::get_data($soiArea[7]),true),
        );
        // SOI AREA MONTH //

        $data = [
            'link' => 'dashboard',
            'sub_link' => '',
            'select_area_filter' => $opt_are_fil,
            'select_year_filter' => $opt_year, //form_dropdown('year_filter', $opt_year, $current_year,'id="yearFilter" class="form-control" required'),
            'select_month_filter' => $opt_mon, //form_dropdown('month_filter', $opt_mon,'','id="monthFilter" class="form-control" required'),
            'legend_area' => json_encode($legend_area, true),
            'grap_risk' => json_encode($risTotalArr, true),
            'grap_risk_source' => json_encode($rsouArr, true),
            'grap_trans_month' => json_encode($gtm_arr, true),
            'grap_trans_area' => json_encode($tar_arr, true),
            'grap_trans' => json_encode($tra_arr, true),
            'grap_target_assets' => json_encode($tarArr, true),
            'data_index' => $res_iso[0]->max_iso,
            'data_soi' => $res_soi[0]->avg_soi,
            'grap_soi_average_month' => $grap_soi_average_month,
            'grap_soi_avgpilar' => $res_soi_avgpilar,
            'grap_soi_avg_areamonth' => $sorAvgArea
        ];

        return view('srs::dashboard', $data);
    }

    public function grap_srs(Request $request)
    {
        $res_iso = DashboardModel::grap_srs($request);
        $res_soi = DashboardModel::grap_soi($request);
        $res_risk_source = DashboardModel::grap_risk_source($request);
        $res_risk = DashboardModel::grap_risk($request);
        $res_target_assets = DashboardModel::grap_target_assets($request);
        $res_trans_month = DashboardModel::grap_trans_month($request);
        $res_trans_area = DashboardModel::grap_trans_area($request);
        $res_trans = DashboardModel::grap_trans($request);
        $res_soi_avg_month = DashboardModel::grap_soi_avg_month($request);
        $res_soi_avgpilar = DashboardModel::grap_soi_avgpilar($request);
        $res_soi_montharea = DashboardModel::grap_soi_avg_montharea($request);

        // RISK SOURCE
        $rsoArr = array();
        foreach ($res_risk_source as $key => $rso) {
            // $rsoArr[] = $rso->total;
            $rsoArr[] = array(
                'id' => $rso->id,
                'label' => $rso->title,
                'data' => $rso->total
            );
        }

        // RISK
        $risArr = array();
        foreach ($res_risk as $key => $ris) {
            $risArr[] = array(
                'id' => $ris->id,
                'label' => $ris->title,
                'data' => $ris->total
            );
        }

        // TRAGET ASSETS
        $assArr = array();
        foreach ($res_target_assets as $key => $ass) {
            // $assArr[] = $ass->total;
            $assArr[] = array(
                'id' => $ass->id,
                'label' => $ass->title,
                'data' => $ass->total
            );
        }

        // TRANS MOUNTH
        $tmoArr = array();
        foreach ($res_trans_month as $key => $tmo) {
            $tmoArr[] = $tmo->total;
        }

        // TRANS
        $traArr = array();
        foreach ($res_trans as $key => $tra) {
            $traArr[] = $tra->total;
        }
        $traArr[] = 5;
        // TRANS //

        // TRANS AREA
        $tarArr = array();
        foreach ($res_trans_area as $key => $tar) {
            $tarArr[] = $tar->total;
        }
        // TRANS AREA //

        // SOI AVERAGE MONTH //
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
        // SOI AVERAGE MONTH //

        // SOI AREA //
        $soiAreaGroup = array();
        $soiArea = array();
        foreach ($res_soi_montharea as $key => $soig) {
            $soiAreaGroup[$soig->label][] = $soig;
        }
        foreach ($soiAreaGroup as $key => $soia) {
            $soiArea[] = $soia;
        }
        $sorAvgArea = array(
            array(
                'label' => 'PLANT 1',
                'data' => $this->get_data($soiArea[0]),
            ),
            array(
                'label' => 'PLANT 2',
                'data' => $this->get_data($soiArea[1]),
            ),
            array(
                'label' => 'PLANT 3',
                'data' => $this->get_data($soiArea[2]),
            ),
            array(
                'label' => 'PLANT 4',
                'data' => $this->get_data($soiArea[3]),
            ),
            array(
                'label' => 'PLANT 5',
                'data' => $this->get_data($soiArea[4]),
            ),
            array(
                'label' => 'VLC',
                'data' => $this->get_data($soiArea[5]),
            ),
            array(
                'label' => 'HEAD OFFICE',
                'data' => $this->get_data($soiArea[6]),
            ),
            array(
                'label' => 'PART CENTER',
                'data' => $this->get_data($soiArea[7]),
            ),
        );
        // SOI AREA //

        $arr = array(
            'data_index' => $res_iso,
            'data_soi' => $res_soi,
            'data_risk_source' => $rsoArr,
            'data_risk' => $risArr,
            'data_target_assets' => $assArr,
            'data_trans_month' => $tmoArr,
            'data_trans' => $traArr,
            'data_trans_area' => $tarArr,
            'grap_soi_average_month' => $grap_soi_average_month,
            'grap_soi_avgpilar' => $res_soi_avgpilar,
            'grap_soi_avg_areamonth' => $sorAvgArea,
        );

        echo json_encode($arr, true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('srs::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('srs::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('srs::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    private function get_data($data)
    {
        $soiArea = array();
        foreach ($data as $key => $soia) {
            $soiArea[] = $soia->data;
        }

        return $soiArea;
    }
}
