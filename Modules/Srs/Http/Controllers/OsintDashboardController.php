<?php

namespace Modules\Srs\Http\Controllers;

use AuthHelper;
use FormHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Srs\Entities\OsintDashboardModel;

class OsintDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }

    public function index()
    {
        $opt_mon = array('' => '-- Month --');
        for ($i = 1; $i <= 12; $i++) {
            $opt_mon[$i] = date("F", mktime(0, 0, 0, $i, 10));
        }

        $firstYear = (int)date('Y') - 1; // v
        $lastYear = $firstYear + 4; // + 2
        $opt_yea = array('' => '-- Year --');
        for ($i = $firstYear; $i <= $lastYear; $i++) {
            $opt_yea[$i] = $i;
        }

        $data = [
            'link' => request()->segments()[1],
            'sub_link' => empty(request()->segments()[2]) ? '' : request()->segments()[2],
            'select_month_filter' => FormHelper::formDropdown('month_filter', $opt_mon, '', 'id="monthFilter" class="form-control" required'),
            'select_years' => FormHelper::formDropdown('year', $opt_yea, '', 'id="years" class="form-control" required'),
            'select_year_filter' => FormHelper::formDropdown('year_filter', $opt_yea,  date('Y'), 'id="yearFilter" class="form-control" required'),
        ];
        
        return view('srs::osintdashboard', $data);
    }

    public function getAllDataPie(Request $req)
    {
        $result = OsintDashboardModel::getDataAllOsint($req);
        
        $data = array();
        foreach ($result as $r) {
            $data[] = $r->total;
        }

        echo json_encode($data);
    }

    public function getArea(Request $req)
    {
        $data = OsintDashboardModel::getArea($req);
        echo json_encode($data);
    }

    public function detailEventList(Request $req)
    {
        $detail_event = OsintDashboardModel::detailEventList($req);

        $html = '<div class="row px-2 mb-4">';
        $no = 1;
        foreach ($detail_event as $key => $val) {
            $html .= '<div class="col-12 p-3">
                        <a href="javascript:void(0)" data-id="'.$val->id.'" data-target="#detailSearchModal" class="detail-list-event-osint text-white">
                        <h5>'.$no.'. '.$val->event_name.'</h5>
                        <small>'.date('Y-m-d H:i',strtotime($val->event_date)).'</small>
                        </a>
                    </div>';
            $no++;
        }
        $html .= '</div>';

        echo $html;
    }

    public function getInternalSource(Request $req)
    {
        $data = OsintDashboardModel::getInternalSource($req);
        echo json_encode($data);
    }

    public function detailSource(Request $req)
    {
        // NAME //
        $detailIntSourceSub1 = OsintDashboardModel::detailIntSourceSub1($req,'sub_risk1_source');
        // SUB MONTH //
        $detailInternalSourceSubMonth = OsintDashboardModel::detailMonth($req,'sub_risk_source');
        // SUB 1 MONTH //
        $detailInternalSourceSub1Month = OsintDashboardModel::detailMonth($req,'sub_risk1_source');

        // NAME
        $intSourceArr = array();
        foreach ($detailIntSourceSub1 as $key => $iso) {
            $intSourceArr[] = array(
                'id' => $iso->id,
                'data' => $iso->total,
                'label' => $iso->name,
            );
        }

        // MONTH
        $intSourceMonthArr = array();
        foreach ($detailInternalSourceSubMonth as $key => $isom) {
            $intSourceMonthArr[] = $isom->total;
        }

        // SUB 1 MONTH
        $intSourceSub1MonthArr = array();
        foreach ($detailInternalSourceSub1Month as $key => $isom1) {
            $intSourceSub1MonthArr[] = $isom1->total;
        }

        $arr = array(
            'data_intsource' => $intSourceArr,
            'data_intsource_month' => $intSourceMonthArr,
            'data_intsource_sub1_month' => $intSourceSub1MonthArr,
        );

        echo json_encode($arr, true);
    }

    public function getExternalSource(Request $req)
    {
        $data = OsintDashboardModel::getExternalSource($req);
        echo json_encode($data);
    }
    
    public function getTargetAssets(Request $req)
    {
        $data = OsintDashboardModel::getTargetAssets($req);
        echo json_encode($data);
    }

    public function detailTargetAssets(Request $req)
    {
        // SUB 1 NAME //
        $sub = OsintDashboardModel::detailSub1($req, 'sub_target_issue1_id');
        // SUB MONTH //
        $subMonth = OsintDashboardModel::detailMonth($req, 'target_issue_id');
        // SUB 1 MONTH //
        $sub1Month = OsintDashboardModel::detailMonth($req, 'sub_target_issue1_id');
        // SUB 2 NAME //
        $sub2 = OsintDashboardModel::detailSub2($req, 'sub_target_issue2_id');
        // SUB 2 MONTH //
        $sub2Month = OsintDashboardModel::detailMonth($req, 'sub_target_issue2_id');

        // SUB 1 NAME
        $subArr = array();
        foreach ($sub as $key => $tga) {
            $subArr[] = array(
                'id' => $tga->id,
                'data' => $tga->total,
                'label' => $tga->name,
            );
        }

        // MONTH
        $subMonthArr = array();
        foreach ($subMonth as $key => $subm) {
            $subMonthArr[] = $subm->total;
        }

        // SUB 1 MONTH
        $sub1MonthArr = array();
        foreach ($sub1Month as $key => $sub1m) {
            $sub1MonthArr[] = $sub1m->total;
        }

        // SUB 2 NAME
        $sub2Arr = array();
        foreach ($sub2 as $key => $sub2m) {
            $sub2Arr[] = array(
                'id' => $sub2m->id,
                'data' => $sub2m->total,
                'label' => $sub2m->name,
            );
        }

        // SUB 2 MONTH
        $sub2MonthArr = array();
        foreach ($sub2Month as $key => $sub2m) {
            $sub2MonthArr[] = $sub2m->total;
        }

        $arr = array(
            'data_sub' => $subArr,
            'data_sub_month' => $subMonthArr,
            'data_sub1_month' => $sub1MonthArr,
            'data_sub2' => $sub2Arr,
            'data_sub2_month' => $sub2MonthArr,
        );

        echo json_encode($arr, true);
    }

    public function getNegativeSentiment(Request $req)
    {
        $data = OsintDashboardModel::getNegativeSentiment($req);
        echo json_encode($data);
    }
    
    public function detailNegativeSentiment(Request $req)
    {
        // SUB 1 NAME //
        $sub = OsintDashboardModel::detailSub1($req, 'hatespeech_type_id');
        // SUB MONTH //
        $subMonth = OsintDashboardModel::detailMonth($req, 'hatespeech_type_id');
        // SUB 1 MONTH //
        $sub1Month = OsintDashboardModel::detailMonth($req, 'hatespeech_type_id');
        // SUB 2 NAME //
        $sub2 = OsintDashboardModel::detailSub2($req, 'hatespeech_type_id');

        // SUB 1 NAME
        $subArr = array();
        foreach ($sub as $key => $tga) {
            $subArr[] = array(
                'id' => $tga->id,
                'data' => $tga->total,
                'label' => $tga->name,
            );
        }

        // MONTH
        $subMonthArr = array();
        foreach ($subMonth as $key => $subm) {
            $subMonthArr[] = $subm->total;
        }

        // SUB 1 MONTH
        $sub1MonthArr = array();
        foreach ($sub1Month as $key => $sub1m) {
            $sub1MonthArr[] = $sub1m->total;
        }

        // SUB 2 NAME
        $sub2Arr = array();
        foreach ($sub2 as $key => $sub2m) {
            $sub2Arr[] = array(
                'id' => $sub2m->id,
                'data' => $sub2m->total,
                'label' => $sub2m->name,
            );
        }

        $arr = array(
            'data_sub' => $subArr,
            'data_sub_month' => $subMonthArr,
            'data_sub1_month' => $sub1MonthArr,
            'data_sub2' => $sub2Arr,
        );

        echo json_encode($arr, true);
    }

    public function getMedia(Request $req)
    {
        $data = OsintDashboardModel::getMedia($req);
        echo json_encode($data);
    }

    public function detailMedia(Request $req)
    {
        // SUB 1 NAME //
        $sub = OsintDashboardModel::detailSub1($req, 'sub_media_id');
        // SUB MONTH //
        $subMonth = OsintDashboardModel::detailMonth($req, 'media_id');
        // SUB 1 MONTH //
        $sub1Month = OsintDashboardModel::detailMonth($req, 'sub_media_id');
        // SUB 2 NAME //
        $sub2 = OsintDashboardModel::detailSub1($req, 'sub2_media_id');

        // SUB 1 NAME
        $subArr = array();
        foreach ($sub as $key => $tga) {
            $subArr[] = array(
                'id' => $tga->id,
                'data' => $tga->total,
                'label' => $tga->name,
            );
        }

        // MONTH
        $subMonthArr = array();
        foreach ($subMonth as $key => $subm) {
            $subMonthArr[] = $subm->total;
        }

        // SUB 1 MONTH
        $sub1MonthArr = array();
        foreach ($sub1Month as $key => $sub1m) {
            $sub1MonthArr[] = $sub1m->total;
        }

        // SUB 2 NAME
        $sub2Arr = array();
        foreach ($sub2 as $key => $sub2m) {
            $sub2Arr[] = array(
                'id' => $sub2m->id,
                'data' => $sub2m->total,
                'label' => $sub2m->name,
            );
        }

        $arr = array(
            'data_sub' => $subArr,
            'data_sub_month' => $subMonthArr,
            'data_sub1_month' => $sub1MonthArr,
            'data_sub2' => $sub2Arr,
        );

        echo json_encode($arr, true);
    }

    public function getFormat(Request $req)
    {
        $data = OsintDashboardModel::getFormat($req);
        echo json_encode($data);
    }

    public function detailFormat(Request $req)
    {
        // SUB 1 NAME //
        $sub = OsintDashboardModel::detailSub1($req, 'format_id');
        // SUB MONTH //
        $subMonth = OsintDashboardModel::detailMonth($req, 'format_id');
        // SUB 1 MONTH //
        $sub1Month = OsintDashboardModel::detailMonth($req, 'format_id');
        // SUB 2 NAME //
        $sub2 = OsintDashboardModel::detailSub1($req, 'format_id');

        // SUB 1 NAME
        $subArr = array();
        foreach ($sub as $key => $tga) {
            $subArr[] = array(
                'id' => $tga->id,
                'data' => $tga->total,
                'label' => $tga->name,
            );
        }

        // MONTH
        $subMonthArr = array();
        foreach ($subMonth as $key => $subm) {
            $subMonthArr[] = $subm->total;
        }

        // SUB 1 MONTH
        $sub1MonthArr = array();
        foreach ($sub1Month as $key => $sub1m) {
            $sub1MonthArr[] = $sub1m->total;
        }

        // SUB 2 NAME
        $sub2Arr = array();
        foreach ($sub2 as $key => $sub2m) {
            $sub2Arr[] = array(
                'id' => $sub2m->id,
                'data' => $sub2m->total,
                'label' => $sub2m->name,
            );
        }

        $arr = array(
            'data_sub' => $subArr,
            'data_sub_month' => $subMonthArr,
            'data_sub1_month' => $sub1MonthArr,
            'data_sub2' => $sub2Arr,
        );

        echo json_encode($arr, true);
    }
    
    public static function totalLevelAvg(Request $req)
    {
        $data = OsintDashboardModel::totalLevelAvg($req);

        echo json_encode($data);
    }
}