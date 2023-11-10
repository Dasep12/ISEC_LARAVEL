<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use AuthHelper, FormHelper;
use Modules\Srs\Entities\HumintModel;
use App\Models\RoleModel;

use TCPDF;

class HumintController extends Controller
{
    public $isModule = 'SRSISO';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data_area = HumintModel::area();
        $data_subarea = HumintModel::sub_area();
        $data_ass = HumintModel::assest();
        $data_rso = HumintModel::risk_source();
        $data_ris = HumintModel::risk();
        $data_rle = HumintModel::risk_level();
        $data_vle = HumintModel::vurnability_level();
        $no = HumintModel::no_urut();

        // AREA
        $opt_are = array();
        foreach ($data_area as $key => $are) {
            $opt_are[$are->id] = $are->title;
        }

        // AREA FILTER
        $opt_are_fil = array('' => '-- All --');
        foreach ($data_area as $key => $are) {
            $opt_are_fil[$are->id] = $are->title;
        }
        
        // YEAR FILTER
        $firstYear = 2022;
        $lastYear = $firstYear + 5;
        $opt_year = array('' => '-- All --');
        for($i=$firstYear;$i<=$lastYear;$i++)
        {
            $opt_year[$i] = $i;
        }

        // STATUS
        $opt_status = array(''=>'All','0'=>'Not Approve','1'=>'Approved');

        $opt_subarea = array('' => '-- Choose --');
        foreach ($data_subarea as $key => $sare) {
            $opt_subarea[$sare->id] = $sare->title;
        }

        $opt_ass = array('' => '-- Choose --');
        foreach ($data_ass as $key => $asc) {
            $opt_ass[$asc->id] = $asc->title;
        }

        $opt_rso = array('' => '-- Choose --');
        foreach ($data_rso as $key => $rso) {
            $opt_rso[$rso->id] = $rso->title;
        }

        $opt_ris = array();
        foreach ($data_ris as $key => $ris) {
            $opt_ris[$ris->id.':'.$ris->level] = $ris->title;
        }

        $opt_rle = array();
        foreach ($data_rle as $key => $rle) {
            $opt_rle[$rle->id] = $rle->level;
        }

        $opt_vle = array('' => '-- Choose --');
        foreach ($data_vle as $key => $vle) {
            $opt_vle[$vle->level.':'.$vle->id] = $vle->level.'. '.$vle->title;
        }

        $opt_fin = array('' => '-- Choose --');
        foreach ($data_vle as $key => $fin) {
            $opt_fin[$fin->level.':'.$fin->id] = htmlentities($fin->level.'. '.$fin->financial_desc);
        }

        $opt_sdm = array('' => '-- Choose --');
        foreach ($data_vle as $key => $sdm) {
            $opt_sdm[$sdm->level.':'.$sdm->id] = $sdm->level.'. '.$sdm->sdm_desc;
        }

        $opt_ope = array('' => '-- Choose --');
        foreach ($data_vle as $key => $ope) {
            $opt_ope[$ope->level.':'.$ope->id] = $ope->level.'. '.$ope->operational_desc;
        }

        $opt_rep = array('' => '-- Choose --');
        foreach ($data_vle as $key => $rep) {
            $opt_rep[$rep->level.':'.$rep->id] = $rep->level.'. '.$rep->reputation_desc;
        }

        $data = [
            'link' => request()->segments()[1],
            'sub_link' => empty(request()->segments()[2]) ? '' : request()->segments()[2],
            'no_urut' => $no[0]->no_urut,
            'no_ref' => $no[0]->no_urut,
            'select_area' => FormHelper::formDropdown('area[]',$opt_are,'','id="area" class="form-control area js-select2" multiple required'),
            'select_area_filter' => FormHelper::formDropdown('area_fil',$opt_are_fil,'','id="areaFilter" class="form-control" required'),
            'select_year_filter' => FormHelper::formDropdown('year_filter', $opt_year, '','id="yearFilter" class="form-control" required'),
            'select_status_filter' => FormHelper::formDropdown('status_filter', $opt_status, '','id="statusFilter" class="form-control" required'),
            'select_subarea1' => FormHelper::formDropdown('sub_area1',$opt_subarea,'','id="subArea1" class="form-control subArea1" required'),
            'select_ass' => FormHelper::formDropdown('assets', $opt_ass,'','id="assets" class="form-control assets" required'),
            'select_rso' => FormHelper::formDropdown('risk_source', $opt_rso,'','id="riskSource" class="form-control" required'),
            'select_ris' => FormHelper::formDropdown('risk', $opt_ris,'','id="risk" class="form-control" required'),
            'select_rle' => FormHelper::formDropdown('risk_level', $opt_rle, '','id="riskLevel" class="form-control" required readonly'),
            'select_fin' => FormHelper::formDropdown('financial', $opt_fin,'','id="financial" class="form-control" required'),
            'select_sdm' => FormHelper::formDropdown('sdm', $opt_sdm,'','id="sdm" class="form-control" required'),
            'select_ope' => FormHelper::formDropdown('operational', $opt_ope,'','id="operational" class="form-control" required'),
            'select_rep' => FormHelper::formDropdown('reputation', $opt_rep,'','id="reputation" class="form-control" required')
        ];

        return view('srs::humintForm', $data);
    }

    public function listTable(Request $request)
    {
        $get_json_data = HumintModel::listTable($request);
         
        echo json_encode($get_json_data);
    }

    public function listTables(Request $request)
    {
        $role = AuthHelper::user_role();
        $npk = AuthHelper::user_npk();
        
        // if ($request->ajax())
        // {
            // $dataIso = HumintModel::listTable();

            ## Read value
            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');

            $searchValue = $search_arr['value']; // Search value

            if($columnIndex_arr)
            {
                $columnIndex = $columnIndex_arr[0]['column']; // Column index
                $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            }

            // dd($columnIndex_arr);die();

            $columnSortOrder = $order_arr[0]['dir']; // asc or desc

            // Total records
            $totalRecords = HumintModel::select('count(*) as allcount')->count();
            $totalRecordswithFilter = HumintModel::select('count(*) as allcount')->where('srs_bi.dbo.admiseciso_transaction.event_name', 'like', '%' .$searchValue . '%')->count();

            // Fetch records
            $records = HumintModel::orderBy($columnName,$columnSortOrder)
            ->where('srs_bi.dbo.admiseciso_transaction.event_name', 'like', '%' .$searchValue . '%')
            ->select('srs_bi.dbo.admiseciso_transaction.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

            $data_arr = array();

            foreach($records as $record) {
                // $id = $record->id;
                $event_name = $record->event_name;

                $data_arr[] = array(
                    "id" => $id,
                    "event_name" => $record->event_name,
                    "event_date" => date('d F Y H:i', strtotime($record->event_date)),
                    "area" => 1,
                    "assets" => 2,
                    "risk_source" => 3,
                    "risk" => 4,
                    "impact_level" => 5,
                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );

            echo json_encode($response);
            // exit;

            // return datatables()->of($dataIso)
            //     ->addColumn('action', function ($row) {
            //         $html = '<a href="#" class="btn btn-xs btn-secondary btn-edit">Edit</a> ';
            //         $html .= '<button data-rowid="' . $row->id . '" class="btn btn-xs btn-danger btn-delete">Del</button>';
            //         return $html;
            //     })->toJson();
        // }
    }

    public function getSubArea2(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idcateg' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $res_sub = HumintModel::subArea2($req);

            $opt = array();
            foreach ($res_sub as $key => $sub) {
                echo '<option value="'.$sub->id.'">'.$sub->title.'</option>';
            }
        }
    }

    public function getSubArea3(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idcateg' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $res_sub = HumintModel::subArea2($req);

            if($res_sub)
            {
                echo '<div class="form-group col-3">
                        <label for="subArea3">'.$res_sub[0]->title_cat.'</label>
                        <select id="subArea3" class="form-control subArea3" name="sub_area3" required>';
                    $opt = array();
                    foreach ($res_sub as $key => $sub) {
                        echo '<option value="'.$sub->id.'">'.$sub->title.'</option>';
                    }
                echo '</select>
                        </div>';
                }
            else
            {
                echo null;
            }
        }
    }

    public function getSubAssets(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idcateg' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $res_sub = HumintModel::subAssets($req);

            if($res_sub)
            {
                echo '<div class="form-group col-3">
                        <label for="subAssets">'.$res_sub[0]->title_cat.'</label>
                        <select id="subAssets" class="form-control" name="sub_assets1" required>';
                $opt = array();
                foreach ($res_sub as $key => $sub) {
                    echo '<option value="'.$sub->id.'">'.$sub->title.'</option>';
                }
                echo '</select>
                        </div>';
                }
            else
            {
                echo null;
            }
        }
    }

    public function getSubAssets2(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idcateg' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $res_sub = HumintModel::subAssets($req);

            if($res_sub)
            {
                echo '<div class="form-group col-3">
                        <label for="subAssets2">'.$res_sub[0]->title_cat.'</label>
                        <select id="subAssets2" class="form-control" name="sub_assets2" required>';
                $opt = array();
                foreach ($res_sub as $key => $sub) {
                    echo '<option value="'.$sub->id.'">'.$sub->title.'</option>';
                }
                echo '</select>
                    </div>';
                }
            else
            {
                echo null;
            }
        }
    }
    
    public function getSubRisksource(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idcateg' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $res_sub = HumintModel::subRiskSource($req);

            if($res_sub)
            {
                $opt = '<div class="form-group col-3">
                            <label for="subRiskSource">'.$res_sub[0]->title_cat.'</label>
                            <select id="subRiskSource" class="form-control" name="subRiskSource1" required>';
                $opt .= '<option value="">-- Choose --</option>';
                foreach ($res_sub as $key => $sub) {
                    $opt .=  '<option value="'.$sub->id.'">'.$sub->title.'</option>';
                }
                $opt .=  '</select>
                    </div>';

                echo $opt;
            }
            else
            {
                echo null;
            }
        }
    }
    
    public function getSubRiskSource2(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idcateg' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $res_sub = HumintModel::subRiskSource($req);

            if($res_sub)
            {
                echo '<div class="form-group col-3">
                            <label for="subRiskSource2"></label>
                            <select id="subRiskSource2" class="form-control" name="sub_risksource2">';
                $opt = array();
                foreach ($res_sub as $key => $sub) {
                    echo '<option value="'.$sub->id.'">'.$sub->title.'</option>';
                }
                echo '</select>
                    </div>';
                }
            else
            {
                echo null;
            }
        }
    }

    public function getSubRisk(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idcateg' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $res_sub = HumintModel::subRisk($req);

            if($res_sub)
            {
                $opt = '<div class="form-group col-3">
                            <label for="subRisk">'.$res_sub[0]->title_cat.'</label>
                            <select id="subRisk" class="form-control" name="sub_risk1" required>';
                $opt .= '<option value="">-- Choose --</option>';
                foreach ($res_sub as $key => $sub) {
                    $opt .=  '<option value="'.$sub->id.'">'.$sub->title.'</option>';
                }
                $opt .=  '</select>
                    </div>';

                echo $opt;
            }
            else
            {
                echo null;
            }
        }
    }

    public function getSubRisk2(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idcateg' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo null;
        }
        else
        {
            $res_sub = HumintModel::subRisk($req);

            if($res_sub)
            {
                $opt = '<div class="form-group col-3">
                            <label for="subRisk2"> - </label>
                            <select id="subRisk2" class="form-control" name="sub_risk2" required>';
                $opt .= '<option value="">-- Choose --</option>';
                foreach ($res_sub as $key => $sub) {
                    $opt .=  '<option value="'.$sub->id.'">'.$sub->title.'</option>';
                }
                $opt .=  '</select>
                    </div>';

                echo $opt;
            }
            else
            {
                echo null;
            }
        }
    }
    
    public function approve(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            // return redirect('srs/humint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data yang diisi tidak lengkap');
            $result = array(
                'code' => '01',
                'msg' => 'Data yang diisi tidak lengkap.'
            );
        }
        else
        {
            $res = HumintModel::approve($req);

            if($res == '00')
            {
                // return redirect('srs/humint_source')->with('success', '<i class="icon fas fa-check"></i> Berhasil menyetujui data');
                $result = array(
                    'code' => '00',
                    'msg' => 'Berhasil menyetujui data.'
                );
            }
            else
            {
                // return redirect('srs/humint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menyetujui data');
                $result = array(
                    'code' => '01',
                    'msg' => 'Gagal menyetujui data.'
                );
            }
        }
        
        // redirect('analitic/srs/internal_source');
        return json_encode($result, true);
    }

    public function edit($id, Request $request)
    {
        if ($id == '')
        {
            redirect('/home/dashboard')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> ID tidak ditemukan');
        }
        else
        {
            $get_edit = HumintModel::edit($id);

            if($get_edit !== NULL)
            {
                $data_edit = $get_edit[0];
                // echo '<pre>';
                // print_r($data_edit);die();
                $data_area = HumintModel::area();
                // AREA
                $data_subarea = HumintModel::sub_area();
                $data_subarea2 = HumintModel::subArea2($request, $data_edit->area_sub1_id);
                $data_subarea3 = HumintModel::subArea2($request, $data_edit->area_sub2_id);

                // RISK SOURCE
                $data_rso = HumintModel::risk_source();
                $data_rso1 = HumintModel::subRiskSource($request, $data_edit->risk_source_id);
                $data_rso2 = HumintModel::subRiskSource($request, $data_edit->risksource_sub1_id);

                // RISK
                $data_ris = HumintModel::risk();
                $data_ris1 = HumintModel::subRisk($request, $data_edit->risk_id);
                $data_ris2 = HumintModel::subRisk($request, $data_edit->risk_sub1_id);

                $data_rle = HumintModel::risk_level();
                $data_vle = HumintModel::vurnability_level();
                $data_ass = HumintModel::assest();
                $no = HumintModel::no_urut();
                $data_subass = HumintModel::subAssets($request, $data_edit->assets_id);
                $data_subass2 = HumintModel::subAssets($request, $data_edit->assets_sub1_id);

                // AREA & SUBAREA //
                $opt_are = array();
                foreach ($data_area as $key => $are) {
                    $opt_are[$are->id] = $are->title;
                }

                $opt_subarea = array('' => '-- Choose --');
                foreach ($data_subarea as $key => $sare) {
                    $opt_subarea[$sare->id] = $sare->title;
                }

                $opt_subarea2 = array('' => '-- Choose --');
                foreach ($data_subarea2 as $key => $sa2) {
                    $opt_subarea2[$sa2->id] = $sa2->title;
                }

                $opt_subarea3 = array('' => '-- Choose --');
                foreach ($data_subarea3 as $key => $sa3) {
                    $opt_subarea3[$sa3->id] = $sa3->title;
                }

                $opt_are_fil = array('' => '-- All --');
                foreach ($data_area as $key => $are) {
                    $opt_are_fil[$are->id] = $are->title;
                }
                // AREA & SUBAREA //

                // TARGET ASSETS //
                $opt_ass = array('' => '-- Choose --');
                foreach ($data_ass as $key => $asc) {
                    $opt_ass[$asc->id] = $asc->title;
                }
                $opt_sas1 = array('' => '-- Choose --');
                foreach ($data_subass as $key => $sas1) {
                    $opt_sas1[$sas1->id] = $sas1->title;
                }
                $opt_sas2 = array('' => '-- Choose --');
                foreach ($data_subass2 as $key => $sas2) {
                    $opt_sas2[$sas2->id] = $sas2->title;
                }
                // TARGET ASSETS //

                // RISK SOURCE //
                $opt_rso = array('' => '-- Choose --');
                foreach ($data_rso as $key => $rso) {
                    $opt_rso[$rso->id] = $rso->title;
                }

                $opt_rso1 = array('' => '-- Choose --');
                foreach ($data_rso1 as $key => $rso1) {
                    $opt_rso1[$rso1->id] = $rso1->title;
                }

                $opt_rso2 = array('' => '-- Choose --');
                foreach ($data_rso2 as $key => $rso2) {
                    $opt_rso2[$rso2->id] = $rso2->title;
                }
                // RISK SOURCE //

                // RISK //
                $opt_ris = array();
                foreach ($data_ris as $key => $ris) {
                    $opt_ris[$ris->id.':'.$ris->level] = $ris->title;
                    if($data_edit->risk_id == $ris->id)
                    {
                        $curr_ris = $ris->id.':'.$ris->level; 
                    }
                }

                $opt_ris1 = array();
                foreach ($data_ris1 as $key => $ris1) {
                    $opt_ris1[$ris1->id] = $ris1->title;
                }

                $opt_ris2 = array();
                foreach ($data_ris2 as $key => $ris2) {
                    $opt_ris2[$ris2->id] = $ris2->title;
                }
                // RISK //

                $opt_rle = array();
                foreach ($data_rle as $key => $rle) {
                    $opt_rle[$rle->id] = $rle->level;
                    if($data_edit->risk_level_id == $rle->id)
                    {
                        $curr_rle = $rle->id.':'.$rle->level; 
                    }
                }

                $opt_vle = array('' => '-- Choose --');
                foreach ($data_vle as $key => $vle) {
                    $opt_vle[$vle->level.':'.$vle->id] = $vle->level.'. '.$vle->title;
                }

                $opt_fin = array('' => '-- Choose --');
                foreach ($data_vle as $key => $fin) {
                    $opt_fin[$fin->level.':'.$fin->id] = htmlentities($fin->level.'. '.$fin->financial_desc);
                    if($data_edit->financial_level == $fin->id)
                    {
                        $curr_fin = $fin->level.':'.$fin->id; 
                    }
                }

                $opt_sdm = array('' => '-- Choose --');
                foreach ($data_vle as $key => $sdm) {
                    $opt_sdm[$sdm->level.':'.$sdm->id] = $sdm->level.'. '.$sdm->sdm_desc;
                    if($data_edit->sdm_level == $sdm->id)
                    {
                        $curr_sdm = $sdm->level.':'.$sdm->id; 
                    }
                }

                $opt_ope = array('' => '-- Choose --');
                foreach ($data_vle as $key => $ope) {
                    $opt_ope[$ope->level.':'.$ope->id] = $ope->level.'. '.$ope->operational_desc;
                    if($data_edit->operational_level == $ope->id)
                    {
                        $curr_ope = $ope->level.':'.$ope->id; 
                    }
                }

                $opt_rep = array('' => '-- Choose --');
                foreach ($data_vle as $key => $rep) {
                    $opt_rep[$rep->level.':'.$rep->id] = $rep->level.'. '.$rep->reputation_desc;
                    if($data_edit->reputation_level == $rep->id)
                    {
                        $curr_rep = $rep->level.':'.$rep->id; 
                    }
                }

                $data = [
                    'link' => request()->segments()[1],
                    'sub_link' => empty(request()->segments()[2]) ? '' : request()->segments()[2],
                    'no_ref' => $no[0]->no_urut.'/LK/EA/'.FormHelper::convertRomawi(date('m')).'/'.date('Y'),
                    'no_urut' => $no[0]->no_urut,
                    'select_area' => FormHelper::formDropdown('area[]', $opt_are, $data_edit->area_id,'id="area" class="form-control area js-select2" multiple required'),
                    'select_area_filter' => FormHelper::formDropdown('area_fil', $opt_are_fil,'','id="areaFilter" class="form-control" required'),
                    'select_subarea1' => FormHelper::formDropdown('sub_area1', $opt_subarea, $data_edit->area_sub1_id,'id="subArea1" class="form-control subArea1" required'),
                    'select_subarea2' => FormHelper::formDropdown('sub_area2', $opt_subarea2, $data_edit->area_sub2_id,'id="subArea2" class="form-control" required'),
                    'select_subarea3' => count($opt_subarea3) <= 1 ? '' : FormHelper::formDropdown('sub_area3', $opt_subarea3, $data_edit->area_sub3_id,'id="subArea3" class="form-control" required'),

                    'select_ass' => FormHelper::formDropdown('assets', $opt_ass, $data_edit->assets_id,'id="assets" class="form-control assets" required'),
                    'select_subass1' => count($opt_sas1) <= 1 ? '' : FormHelper::formDropdown('sub_assets1', $opt_sas1, $data_edit->assets_sub1_id,'id="subAssets" class="form-control" required'),
                    'select_subass2' => count($opt_sas2) <= 1 ? '' : FormHelper::formDropdown('select_subass2', $opt_sas2, $data_edit->assets_sub2_id,'id="subAssets2" class="form-control" required'),

                    'select_rso' => FormHelper::formDropdown('risk_source', $opt_rso, $data_edit->risk_source_id,'id="riskSource" class="form-control" required'),
                    'select_rso1' => count($opt_rso1) <= 1 ? '' : FormHelper::formDropdown('sub_risksource1', $opt_rso1, $data_edit->risksource_sub1_id,'id="subRiskSource" class="form-control" required'),
                    'select_rso2' => count($opt_rso2) <= 1 ? '' : FormHelper::formDropdown('sub_risksource2', $opt_rso2, $data_edit->risksource_sub2_id,'id="subRiskSource2" class="form-control" required'),

                    'select_ris' => FormHelper::formDropdown('risk', $opt_ris, $curr_ris,'id="risk" class="form-control" required'),
                    'select_ris1' => count($opt_ris1) <= 1 ? '' : FormHelper::formDropdown('sub_risk1', $opt_ris1, $data_edit->risk_sub1_id,'id="subRisk" class="form-control" required'),
                    'select_ris2' => count($opt_ris2) <= 1 ? '' : FormHelper::formDropdown('sub_risk2', $opt_ris2, $data_edit->risk_sub2_id,'id="subRisk2" class="form-control" required'),

                    'select_rle' => FormHelper::formDropdown('risk_level', $opt_rle, $curr_rle,'id="riskLevel" class="form-control" required readonly'),
                    'select_fin' => FormHelper::formDropdown('financial', $opt_fin, $curr_fin,'id="financial" class="form-control" required'),
                    'select_sdm' => FormHelper::formDropdown('sdm', $opt_sdm, $curr_sdm,'id="sdm" class="form-control" required'),
                    'select_ope' => FormHelper::formDropdown('operational', $opt_ope, $curr_ope,'id="operational" class="form-control" required'),
                    'select_rep' => FormHelper::formDropdown('reputation', $opt_rep, $curr_rep,'id="reputation" class="form-control" required'),

                    'access_module' => RoleModel::access_modul(AuthHelper::user_npk(), $this->isModule)[0],
                    'data_edit' => $data_edit,
                    'data_edit_all' => $get_edit,
                    'isModule' => $this->isModule,
                ];

                // dd($data_edit->risksource_sub1_id);

                // $this->template->load("template/analityc/template_srs", "srs/form_iso_edit_v", $data);
                return view('srs::humintFormEdit', $data);
            }
            else
            {
                // $this->session->set_tempdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak ditemukan', 5);
                return redirect('srs/humint_source');
            }
        }
    }

    public function detail(Request $request)
    {
        $res = HumintModel::detail($request);
        
        if($res)
        {
            $opt = '
                    <table class="table table-borderless mb-3">
                        <tr>
                            <th width="10">Author:</th>
                            <td>'.$res[0]->author.'</td>
                        </tr>
                    </table>
                    <a class="btn btn-primary mb-2" target="_blank" href="'.url('srs/humint_source/report_pdf/'.$res[0]->id).'">Export Report</a>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <td colspan="4">'.$res[0]->event_name.'</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td colspan="4">'.date('d F Y h:i', strtotime($res[0]->event_date)).'</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <td>'.$res[0]->area.'</td>
                                <td>'.$res[0]->area_sub1.'</td>
                                <td>'.$res[0]->area_sub2.'</td>
                                <td>'.$res[0]->area_sub3.'</td>
                            </tr>
                            <tr>
                                <th>Target Assets</th>
                                <td>'.$res[0]->assets.'</td>
                                <td>'.$res[0]->assets_sub1.'</td>
                                <td>'.$res[0]->assets_sub2.'</td>
                            </tr>
                            <tr>
                                <th>Risk Source</th>
                                <td>'.$res[0]->risksource.'</td>
                                <td>'.$res[0]->risksource1.'</td>
                                <td colspan="4">'.$res[0]->risksource2.'</td>
                            </tr>
                            <tr>
                                <th>Risk</th>
                                <td>'.$res[0]->risk.'</td>
                                <td>'.$res[0]->risk1.'</td>
                                <td colspan="4">'.$res[0]->risk2.'</td>
                            </tr>
                            <tr>
                                <th>Risk Level</th>
                                <td colspan="4" class="font-weight-bold">'.$res[0]->risk_level.'</td>
                            </tr>
                            <tr>
                                <th>Vulnerability Lost</th>
                                <td colspan="4">
                                    <table class="table table-bordered text-center">
                                        <tr>
                                            <th>Financial</th>
                                            <th>SDM</th>
                                            <th>Operational</th>
                                            <th>Reputation</th>
                                            <!--<th>Impact Level</th>-->
                                        </tr>
                                        <tr>
                                            <td>'.$res[0]->financial_level.'</td>
                                            <td>'.$res[0]->sdm_level.'</td>
                                            <td>'.$res[0]->operational_level.'</td>
                                            <td>'.$res[0]->reputation_level.'</td>
                                            <!-- <td class="font-weight-bold">'.$res[0]->impact_level.'</td> -->
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Attachment</th>
                                <td colspan="4">
                                    <table class="table table-bordered text-center">
                                        <tbody>';

                                            foreach ($res as $key => $fla) {
                                                if(!empty($fla->file_name))
                                                {
                                                    $opt .= '<tr><th>'.$fla->file_name.'</th>
                                                    <td><a href="'.url('uploads/srsbi/humint/'.$fla->file_name).'" target="_blank">View</a></td></tr>';
                                                }
                                            }
                                            
                                        $opt .= '
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>';

            echo $opt;
        }
        else
        {
            echo null;
        }
    }
    
    public function delete(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/humint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak lengkap');
        }
        else
        {
            $res = HumintModel::deleteData($req);

            if($res == '00')
            {
                return redirect('srs/humint_source')->with('success', '<i class="icon fas fa-check"></i> Berhasil menghapus data');
            }
            else
            {
                return redirect('srs/humint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            }

        }
        
        // redirect('analitic/srs/humint_source');
    }
    
    public function deleteAttached(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'fileId' => 'required',
        ]);
 
        if ($validator->fails())
        {
            $res = array(
                'code' => '01',
                'msg' => $_POST
            );
        }
        else
        {
            $res = HumintModel::deleteAttachFile($req);

            if($res == '00')
            {
                $res = array(
                    'code' => '00',
                    'msg' => 'success'
                );
            }
            else
            {
                $res = array(
                    'code' => '02',
                    'msg' => 'failed'
                );
            }

        }
        
        header('Content-Type: application/json');
        echo json_encode($res);
    }

    public function search(Request $req)
    {
        $res = HumintModel::search($req);

        $data = '<div id="searchResult" class="col-12 mt-5"><div class="row">';
        foreach ($res as $key => $val) {
            $data .= '<div class="col-12 p-3">
                        <a href="#" target="_blank" data-id="'.$val->id.'" data-toggle="modal" data-target="#detailSearchModal" class="text-white">
                        <h5>'.$val->event_name.'</h5>
                        <small>'.date('Y-m-d H:i',strtotime($val->event_date)).'</small>
                        <p>'.html_entity_decode($val->chronology).'...</p></a>
                    </div>';
        }
        $data .= '</div><div>';

        echo $data;
    }
    
    public function detailSearch(Request $req)
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
            $res_sub = HumintModel::detail($req);

            if($res_sub)
            {
                $opt = '
                        <table class="table table-borderless mb-3">
                            <tr>
                                <th width="10">Author:</th>
                                <td>'.$res_sub[0]->author.'</td>
                            </tr>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Title</th>
                                    <td colspan="4">'.$res_sub[0]->event_name.'</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td colspan="4">'.date('d F Y h:i', strtotime($res_sub[0]->event_date)).'</td>
                                </tr>
                                <tr>
                                    <th>Area</th>
                                    <td>'.$res_sub[0]->area.'</td>
                                    <td>'.$res_sub[0]->area_sub1.'</td>
                                    <td>'.$res_sub[0]->area_sub2.'</td>
                                    <td>'.$res_sub[0]->area_sub3.'</td>
                                </tr>
                                <tr>
                                    <th>Target Assets</th>
                                    <td>'.$res_sub[0]->assets.'</td>
                                    <td>'.$res_sub[0]->assets_sub1.'</td>
                                    <td>'.$res_sub[0]->assets_sub2.'</td>
                                </tr>
                                <tr>
                                    <th>Risk Source</th>
                                    <td>'.$res_sub[0]->risksource.'</td>
                                    <td>'.$res_sub[0]->risksource1.'</td>
                                    <td colspan="4">'.$res_sub[0]->risksource2.'</td>
                                </tr>
                                <tr>
                                    <th>Risk</th>
                                    <td>'.$res_sub[0]->risk.'</td>
                                    <td>'.$res_sub[0]->risk1.'</td>
                                    <td colspan="4">'.$res_sub[0]->risk2.'</td>
                                </tr>
                                <tr>
                                    <th>Risk Level</th>
                                    <td colspan="4" class="font-weight-bold">'.$res_sub[0]->impact_level.'</td>
                                </tr>
                                <tr>
                                    <th>Vulnerability Lost</th>
                                    <td colspan="4">
                                        <table class="table table-bordered text-center">
                                            <tr>
                                                <th>Financial</th>
                                                <th>SDM</th>
                                                <th>Operational</th>
                                                <th>Reputation</th>
                                                <!--<th>Impact Level</th>-->
                                            </tr>
                                            <tr>
                                                <td>'.$res_sub[0]->financial_level.'</td>
                                                <td>'.$res_sub[0]->sdm_level.'</td>
                                                <td>'.$res_sub[0]->operational_level.'</td>
                                                <td>'.$res_sub[0]->reputation_level.'</td>
                                                <!-- <td class="font-weight-bold">'.$res_sub[0]->impact_level.'</td> -->
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Attachment</th>
                                    <td colspan="4">
                                        <table class="table table-bordered text-center">
                                            <tbody>';

                                                foreach ($res_sub as $key => $fla) {
                                                    if(!empty($fla->file_name))
                                                    {
                                                        $opt .= '<tr><th>'.$fla->file_name.'</th>
                                                        <td><a href="'.url('uploads/srsbi/humint/'.$fla->file_name).'" target="_blank">View</a></td></tr>';
                                                    }
                                                }

                                            $opt .= '
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Chronology</th>
                                    <td colspan="4" class="font-weight-bold">'.html_entity_decode($res_sub[0]->chronology).'</td>
                                </tr>
                            </tbody>
                        </table>';

                echo $opt;
            }
            else
            {
                echo null;
            }
        }
    }

    public function saveData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'risk_level' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/humint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak lengkap');
        }
        else
        {
            $res = HumintModel::saveData($req);

            if($res == '00')
            {
                return redirect('srs/humint_source')->with('success', '<i class="icon fas fa-check"></i> Berhasil menyimpan data');
            }
            else
            {
                return redirect('srs/humint_source')->with('success', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menyimpan data');
            }

        }
        
        return redirect('srs/humint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> ID tidak ditemukan');
        
        // redirect('analitic/srs/humint_source');
        // return view('srs::create');
    }
    
    public function updateData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/humint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak lengkap');
        }
        else
        {
            $res = HumintModel::updateData($req);

            if($res == '00')
            {
                return redirect('srs/humint_source')->with('success', '<i class="icon fas fa-check"></i> Berhasil menyimpan data');
            }
            else
            {
                return redirect('srs/humint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menyimpan data');
            }
        }
    }

    public function exportExcel(Request $req)
    {
        $resExport = HumintModel::export($req);
        // echo '<pre>';print_r($resExport);die();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=internal_source_".date('d_m_Y_H_i_s').".xls");
        
        // echo "<h2>Daftar</h2>";

            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>No</th>";
            echo "<th>Event Name</th>";
            echo "<th>Event Date</th>";
            echo "<th>No Urut</th>";
            echo "<th>Area</th>";
            echo "<th>Target Assets</th>";
            echo "<th>Risk Source</th>";
            echo "<th>Risk</th>";
            echo "<th>Impact Level</th>";
            echo "</tr>";
            $no = 1;
            foreach ($resExport as $key => $row) {
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td>" . $row->event_name . "</td>";
                echo "<td>" . date('d F Y h:i', strtotime($row->event_date)) . "</td>";
                echo "<td>" . $row->no_urut . "</td>";
                echo "<td>" . $row->area . "</td>";
                echo "<td>" . $row->assets . "</td>";
                echo "<td>" . $row->risksource . "</td>";
                echo "<td>" . $row->risk . "</td>";
                echo "<td>" . $row->impact_level . "</td>";
                echo "</tr>";
                $no++;
            }
            echo '
            </table>';
                
        echo "</body>
        </html>";
    }
    
    public function srsExportReportPdf() {
        require_once(public_path().'/assets/vendor/tcpdf/tcpdf.php');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        // Set some content to print
        $html = <<<EOD
        <h1 style="text-align:center">Report SRS</h1>
        <p>Level resiko ADM: <span style="background-color:green;color:#FFFFFF;">MEDIUM</span></p>
        <p>Index resiko ADM: <span>4,20</span></p>
        <p>Suggestion:
        <ul>
            <li>Masyarakat Sunter tidak kondusif (pandemic ke endemic) dan program CSR - External</li>.
            <li>Narkoba (Pembubaran kampung Bahari) - External</li>.
            <li>Pembangunan KAP 2 - Internal</li>.
            <li>Serangan Ransomware - Internal</li>.
        </ul>
        </p>
        EOD;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');
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
    // public function edit($id)
    // {
    //     return view('srs::edit');
    // }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

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
