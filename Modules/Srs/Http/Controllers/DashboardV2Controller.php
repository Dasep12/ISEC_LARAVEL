<?php

namespace Modules\Srs\Http\Controllers;

use AuthHelper;
use FormHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;

use Modules\Srs\Entities\DashboardV2Model;

class DashboardV2Controller extends Controller
{
    public function __construct()
    {
        // AuthHelper::checksession(session()->all());
        $this->middleware('is_login_isec');
    }

    public function index(Request $request)
    {
        $user_npk = AuthHelper::user_npk();

        $data_area = DashboardV2Model::area();
        $risk = DashboardV2Model::risk();
        $target_assets = DashboardV2Model::target_assets();
        $grap_risk = DashboardV2Model::grap_risk($request);
        $grap_risk_source = DashboardV2Model::grap_risk_source($request);
        $grap_trans_month = DashboardV2Model::grap_trans_month($request);
        $grap_trans_area = DashboardV2Model::grap_trans_area($request);
        $grap_trans = DashboardV2Model::grap_trans($request);
        $grap_target_assets = DashboardV2Model::grap_target_assets($request);
        $res_iso = DashboardV2Model::grap_srs($request);
        $res_soi = DashboardV2Model::grap_soi($request);
        $res_soi_avg_month = DashboardV2Model::grap_soi_avg_month($request);
        $res_soi_avgpilar = DashboardV2Model::grap_soi_avgpilar($request);
        $res_soi_montharea = DashboardV2Model::grap_soi_avg_montharea($request);
        $current_year = date('Y');

        // FILTER AREA
        $opt_are_fil = ['' => '-- Choose --'];
        foreach ($data_area as $key => $are) {
            $opt_are_fil[$are->id] = $are->title;
        }

        // FILTER TAHUN
        $firstYear = 2022;
        $lastYear = $firstYear + 5; // + 2
        $opt_year = ['' => '-- Choose --'];
        for($i=$firstYear;$i<=$lastYear;$i++)
        {
            $opt_year[$i] = $i;
        }

        // FILTER BULAN
        $opt_mon = ['' => '-- Choose --'];
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
            'select_area_filter' => FormHelper::formDropdown('area_fil', $opt_are_fil, '','id="areaFilter" class="form-control" required'),
            'select_year_filter' => FormHelper::formDropdown('year_filter', $opt_year, $current_year,'id="yearFilter" class="form-control" required'),
            'select_month_filter' => FormHelper::formDropdown('month_filter', $opt_mon, '','id="monthFilter" class="form-control" required'),
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

        return view('srs::dashboard_v2', $data);
    }

    public function grap_srs(Request $request)
    {
        $res_iso = DashboardV2Model::grap_srs($request);
        $res_soi = DashboardV2Model::grap_soi($request);
        $res_risk_source = DashboardV2Model::grap_risk_source($request);
        $res_risk = DashboardV2Model::grap_risk($request);
        $res_target_assets = DashboardV2Model::grap_target_assets($request);
        $res_trans_month = DashboardV2Model::grap_trans_month($request);
        $res_trans_area = DashboardV2Model::grap_trans_area($request);
        $res_trans = DashboardV2Model::grap_trans($request);
        $res_soi_avg_month = DashboardV2Model::grap_soi_avg_month($request);
        $res_soi_avgpilar = DashboardV2Model::grap_soi_avgpilar($request);
        $res_soi_montharea = DashboardV2Model::grap_soi_avg_montharea($request);

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
            $tarArr[] = array(
                'label' => $tar->title,
                'total' => $tar->total
            );
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

    public function grapDetailRiskSource(Request $req)
    {
        // GRAP RISK SOURCE - TOTAL //
        $res_riSo_detail = DashboardV2Model::grapDetailRiskSource($req, 'risk_source_id');
        // GRAP RISK SOURCE - MONTH //
        $res_riSo_month_sub1 = DashboardV2Model::grapDetailRiskSource($req, 'risksource_sub1_id');
        // GRAP RISK SOURCE SUB 1 - TOTAL //
        $res_riSosub1_detail = DashboardV2Model::grapDetailRiskSourceSub($req, 'risksource_sub1_id');
        // GRAP RISK SOURCE SUB 2 - TOTAL //
        $res_risksub2_detail = DashboardV2Model::grapDetailRiskSourceSub($req, 'risksource_sub2_id');
        // RISK SOURCE SUB 2 MONTH //
        $res_riSo_month_sub2 = DashboardV2Model::grapDetailRiskSource($req, 'risksource_sub2_id');

        // RISK SOURCE
        $rSoArr = array();
        foreach ($res_riSo_detail as $key => $rSo) {
            $rSoArr[] = $rSo->total;
        }

        // RISK SOURCE MONTH
        $rSoMArr = array();
        foreach ($res_riSo_month_sub1 as $key => $rSoM) {
            $rSoMArr[] = $rSoM->total;
        }

        // RISK SOURCE SUB 1
        $rSoSubDataArr = array();
        foreach ($res_riSosub1_detail as $key => $riSoSub) {
            $rSoSubDataArr[] = array(
                'id' => $riSoSub->id,
                'data' => $riSoSub->total,
                'label' => $riSoSub->title,
            );
        }

        // RISK SOURCE SUB 2
        $risSub2Arr = array();
        foreach ($res_risksub2_detail as $key => $risSub2) {
            $risSub2Arr[] = array(
                'id' => $risSub2->id,
                'label' => $risSub2->title,
                'data' => $risSub2->total,
            );
        }

        // RISK SOURCE SUB 2 MONTH
        $rSoSub2MArr = array();
        foreach ($res_riSo_month_sub2 as $key => $rSoSub2M) {
            $rSoSub2MArr[] = $rSoSub2M->total;
        }

        $arr = array(
            'data_riso' => $rSoArr,
            'data_riso_sub1' => $rSoSubDataArr,
            'data_riso_sub1_month' => $rSoMArr,
            'data_riso_sub2' => $risSub2Arr,
            'data_riso_sub2_month' => $rSoSub2MArr,
        );

        echo json_encode($arr, true);
    }
    
    public function grapDetailAssets(Request $req)
    {
        // Main assets data
        $res_assets_detail = DashboardV2Model::grapDetailAssets($req, 'assets_id');
        // TARGET ASSETS SUB 1 MONTH
        $res_assets_sub1_month = DashboardV2Model::grapDetailAssets($req, 'assets_sub1_id');
        // TARGET ASSETS SUB 1
        $res_assetssub1_detail = DashboardV2Model::grapDetailAssetsSub($req, 'assets_sub1_id');
        // TARGET ASSETS SUB 2
        $res_assetssub2_detail = DashboardV2Model::grapDetailAssetsSub($req, 'assets_sub2_id');
        // TARGET ASSETS SUB 2 MONTH
        $res_assets_sub2_month = DashboardV2Model::grapDetailAssets($req, 'assets_sub2_id');

        // MAIN ASSETS
        $assetsArr = array();
        foreach ($res_assets_detail as $key => $ass) {
            $assetsArr[] = $ass->total;
        }

        // ASSETS SUB 1 MONTH
        $assetsMSub1Arr = array();
        foreach ($res_assets_sub1_month as $key => $assM) {
            $assetsMSub1Arr[] = $assM->total;
        }

        // ASSETS SUB 1
        $assSubLabelArr = array();
        $assSubArr = array();
        $assSubJoinArr = array();
        foreach ($res_assetssub1_detail as $key => $assSub) {
            $assSubLabelArr[] = $assSub->title;
            $assSubArr[] = $assSub->total;
            $assSubJoinArr[] = array(
                'id' => $assSub->id,
                'label' => $assSub->title,
                'data' => $assSub->total,
            );
        }

        // ASSETS SUB 2
        $assSub2Arr = array();
        foreach ($res_assetssub2_detail as $key => $assSub2) {
            $assSub2Arr[] = array(
                'id' => $assSub2->id,
                'label' => $assSub2->title,
                'data' => $assSub2->total,
            );
        }

        // ASSETS SUB 2 MONTH
        $assetsMSub2Arr = array();
        foreach ($res_assets_sub2_month as $key => $assM2) {
            $assetsMSub2Arr[] = $assM2->total;
        }

        $arr = array(
            'data_detail_assets' => $assetsArr,
            'data_assets_month_sub1' => $assetsMSub1Arr,
            'data_detail_assetssub_label' => $assSubLabelArr,
            'data_detail_assetssub' => $assSubJoinArr,
            'data_detail_assetssub2' => $assSub2Arr,
            'data_assets_month_sub2' => $assetsMSub2Arr,
        );

        echo json_encode($arr, true);
    }
    
    public function grapDetailRisk(Request $req)
    {
        $res_risk_detail = DashboardV2Model::grapDetailRisk($req, 'risk_id');
        $res_risk_sub1 = DashboardV2Model::grapDetailRiskSub($req, 'risk_sub1_id');
        $res_risk_sub1_month = DashboardV2Model::grapDetailRisk($req, 'risk_sub1_id');
        $res_risk_sub2 = DashboardV2Model::grapDetailRiskSub($req, 'risk_sub2_id');
        $res_risk_sub2_month = DashboardV2Model::grapDetailRisk($req, 'risk_sub2_id');

        // RISK
        $risArr = array();
        foreach ($res_risk_detail as $key => $ris) {
            $risArr[] = $ris->total;
        }

        // RISK SUB 1
        $risSub1Arr = array();
        foreach ($res_risk_sub1 as $key => $risSub1) {
            $risSub1Arr[] = array(
                'id' => $risSub1->id,
                'label' => $risSub1->title,
                'data' => $risSub1->total,
            );
        }

        // RISK SUB 1 MONTH
        $risSub1MArr = array();
        foreach ($res_risk_sub1_month as $key => $risMo) {
            $risSub1MArr[] = $risMo->total;
        }

        // RISK SUB 2
        $risSub2Arr = array();
        foreach ($res_risk_sub2 as $key => $risSub2) {
            $risSub2Arr[] = array(
                'id' => $risSub2->id,
                'label' => $risSub2->title,
                'data' => $risSub2->total,
            );
        }

        // RISK MONTH
        $risSub2MArr = array();
        foreach ($res_risk_sub2_month as $key => $risSub2M) {
            $risSub2MArr[] = $risSub2M->total;
        }

        $arr = array(
            'data_risk_month' => $risArr,
            'data_risk_sub1' => $risSub1Arr,
            'data_risk_sub1_month' => $risSub1MArr,
            'data_risk_sub2' => $risSub2Arr,
            'data_risk_sub2_month' => $risSub2MArr,
        );

        echo json_encode($arr, true);
    }
    
    public function grapTrendSoi(Request $req)
    {
        // TREND YEAR MODEL
        $res_trend_year = DashboardV2Model::grapTrendSoiIndex($req);

        // TREND YEAR SORT
        $trendYearLabelArr = array();
        $trendSoiArr = array();
        $trendIndexArr = array();
        foreach ($res_trend_year as $key => $tya) {
            $trendYearLabelArr[] = $tya->month_num;
            $trendSoiArr[] = (float) $tya->avgsoi;
            $trendIndexArr[] = (float) $tya->maxiso;
        }

        $data = array(
            'data_trendyear_label' => $trendYearLabelArr,
            'data_soi' => $trendSoiArr,
            'data_index' => $trendIndexArr,
        );

        echo json_encode($data, true);

    }
    public function grapTopIndex(Request $req)
    {
        $grap_risk_source = DashboardV2Model::grapTopIndex($req);

        $grap_risk_source = $grap_risk_source;

        $rsoIArr = array();
        $rsoEArr = array();
        $rsoElArr = array();
        $rsoEcArr = array();
        foreach ($grap_risk_source as $rse) {
            if($rse->type_source == 1)
            {
                $rsoIArr[] = array(
                    'id' => $rse->id,
                    'label' => $rse->title,
                    'data' => $rse->total
                );   
            }
            if($rse->id == 7)
            {
                $rsoElArr[] = array(
                    'label' => $rse->title,
                    'data' => $rse->total
                );
            }
            if($rse->id == 4)
            {
                $rsoEcArr[] = array(
                    'label' => $rse->title,
                    'data' => $rse->total
                );
            }
            if($rse->type_source == 2 && $rse->id !== 4 && $rse->id !== 7)
            {
                $rsoEArr[] = array(
                    'label' => $rse->title,
                    'data' => $rse->total
                );
            }
        }

        $joinExt = array(
            'label' => $rsoElArr[0]['label'].', '.$rsoEcArr[0]['label'],
            'data' => ($rsoElArr[0]['data'] + $rsoEcArr[0]['data'])
        );

        $grap_internal = array_reduce($rsoIArr, function($carry, $item){ 
            if(!isset($carry[$item['label']])){ 
                $carry[$item['label']] = ['id' => $item['id'],'label'=>$item['label'],'data'=>$item['data']]; 
            } else { 
                $carry[$item['label']]['data'] += $item['data']; 
            } 
            return $carry; 
        });

        // echo '<pre>';
        // print_r($grap_internal);die();

        $grap_external = array_merge($rsoEArr, array($joinExt));
        rsort($grap_external);
        $gaExt = array();
        foreach ($grap_external as $key => $ge) {
            $gaExt[] = array(
                'label' => $ge['label'],
                'data' => $ge['data']
            );
        }

        $html = '<div class="row px-2 mb-4">
                    <div class="col-md-6 px-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h5>Internal Source</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="row">';
        $iInt = 1;
        foreach ($grap_internal as $keyInt => $int) {
            $html .= '
                <div class="col-md-12 border-bottom text-center py-2">
                    <div class="d-flex flex-row justify-content-between">
                        <span>'.$int['label'].'</span>
                        <span>'.$int['data'].'</span>
                    </div>
                </div>
            ';
            if ($iInt == 3) break;
            $iInt++;
        }
        $html .= "
                    </div>
                </div>
            </div>
        </div>";


        $html .= '
                <div class="col-md-6 px-3">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h5>External Source</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">';
        foreach ($gaExt as $keyExt => $ext) {
            $html .= '
                <div class="col-md-12 border-bottom text-center py-2">
                    <div class="d-flex flex-row justify-content-between">
                        <span>'.$ext['label'].'</span>
                        <span>'.$ext['data'].'</span>
                    </div>
                </div>
            ';
            if ($keyExt == 2) break;
        }
        $html .= "
                        </div>
                    </div>
                </div>
            </div>
        </div>";

        echo $html;
    }
    
    public function grapRisksourceSoi(Request $req)
    {
        $grap_risk_source = DashboardV2Model::grapRisksourceSoi($req);
        $grap_risk_source = json_decode(json_encode($grap_risk_source), true);

        $rsoIArr = array();
        $rsoEArr = array();
        $rsoElArr = array();
        $rsoEcArr = array();
        foreach ($grap_risk_source as $rse) {
            if($rse['type_source'] == 1)
            {
                $rsoIArr[] = array(
                    'id' => $rse['id'],
                    'label' => $rse['title'],
                    'data' => $rse['total']
                );   
            }
            if($rse['id'] == 7)
            {
                $rsoElArr[] = array(
                    'label' => $rse['title'],
                    'data' => $rse['total']
                );
            }
            if($rse['id'] == 4)
            {
                $rsoEcArr[] = array(
                    'label' => $rse['title'],
                    'data' => $rse['total']
                );
            }
            if($rse['type_source'] == 2 && $rse['id'] !== 4 && $rse['id'] !== 7)
            {
                $rsoEArr[] = array(
                    'label' => $rse['title'],
                    'data' => $rse['total']
                );
            }
        }
        $joinExt = array(
            'label' => $rsoElArr[0]['label'].', '.$rsoEcArr[0]['label'],
            'data' => ($rsoElArr[0]['data']+$rsoEcArr[0]['data'])
        );
        $grap_internal = $rsoIArr;
        $grap_external = array_merge($rsoEArr, array($joinExt));
        rsort($grap_external);
        $gaExt = array();
        foreach ($grap_external as $key => $ge) {
            $gaExt[] = array(
                'label' => $ge['label'],
                'data' => $ge['data']
            );
        }

        $html = '<div class="row px-2 mb-4">
                    <div class="col-md-6 px-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h5>Internal Source</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="row">';
        foreach ($grap_internal as $keyInt => $int) {
            $html .= '
                <div class="col-md-12 border-bottom text-center py-2">
                    <div class="d-flex flex-row justify-content-between">
                        <span>'.$int['label'].'</span>
                        <span>'.$int['data'].'</span>
                    </div>
                </div>
            ';
            if ($keyInt == 2) break;
        }
        $html .= "
                    </div>
                </div>
            </div>
        </div>";


        $html .= '
                <div class="col-md-6 px-3">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h5>External Source</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">';
        foreach ($gaExt as $keyExt => $ext) {
            $html .= '
                <div class="col-md-12 border-bottom text-center py-2">
                    <div class="d-flex flex-row justify-content-between">
                        <span>'.$ext['label'].'</span>
                        <span>'.$ext['data'].'</span>
                    </div>
                </div>
            ';
            if ($keyExt == 2) break;
        }
        $html .= "
                        </div>
                    </div>
                </div>
            </div>
        </div>";

        echo $html;
    }

    public function detaileventlist(Request $req)
    {
        $detail_event = DashboardV2Model::detaileventlist($req);

        $html = '<div class="row px-2 mb-4">';
        $no = 1;
        foreach ($detail_event as $key => $val) {
            $html .= '<div class="col-12 p-3">
                        <a href="javascript:void(0)" data-id="'.$val->id.'" data-target="#detailSearchModal" class="detail-list-event text-white">
                        <h5>'.$no.'. '.$val->event_name.'</h5>
                        <small>'.date('Y-m-d H:i',strtotime($val->event_date)).'</small>
                        </a>
                    </div>';
            $no++;
        }
        $html .= '</div>';

        // echo '<pre>';
        // print_r($detail_event);die();

        echo $html;
    }

    private function get_data($data)
    {
        $soiArea = array();
        foreach ($data as $key => $soia) {
            $soiArea[] = $soia->data;
        }

        return $soiArea;
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
}
