<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Modules\Srs\Entities\SoiModel;

use AuthHelper;
use FormHelper;

class SoiController extends Controller
{
    private static $moduleCode = 'SRSSOI';
    private static $isModuleCode = 'SRSSOI';
    
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }
    
    public function index()
    {
        $data_area = SoiModel::area();

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

        $firstYear = (int)date('Y') - 4; // - 84
        $lastYear = $firstYear + 4; // + 2
        $opt_yea = array('' => '-- Year --');
        for($i=$firstYear;$i<=$lastYear;$i++)
        {
            $opt_yea[$i] = $i;
        }

        $data = [
            'link' => request()->segments()[1],
            'sub_link' => empty(request()->segments()[2]) ? '' : request()->segments()[2],
            'select_area' => FormHelper::formDropdown('area', $opt_are,'','id="area" class="form-control" required'),
            'select_area_filter' => FormHelper::formDropdown('area_filter', $opt_are,'','id="areaFilter" class="form-control" required'),
            'select_years' => FormHelper::formDropdown('year', $opt_yea,'','id="years" class="form-control" required'),
            'select_years_filter' => FormHelper::formDropdown('year_filter', $opt_yea,'','id="yearFilter" class="form-control" required'),
            'select_month' => FormHelper::formDropdown('month', $opt_mon,'','id="month" class="form-control" required'),
            'select_month_filter' => FormHelper::formDropdown('month_filter', $opt_mon,'','id="monthFilter" class="form-control" required'),
            'select_people' => FormHelper::formDropdown('people', $opt_lev,'','id="people" class="form-control" required'),
            'select_people_comma' => FormHelper::formDropdown('people_comma', $opt_lev_com,'','id="peopleComma" class="form-control" required'),
            'select_dev' => FormHelper::formDropdown('device', $opt_lev,'','id="device" class="form-control" required'),
            'select_dev_comma' => FormHelper::formDropdown('device_comma', $opt_lev,'','id="deviceComma" class="form-control" required'),
            'select_sys' => FormHelper::formDropdown('system', $opt_lev,'','id="system" class="form-control" required'),
            'select_sys_comma' => FormHelper::formDropdown('system_comma', $opt_lev_com,'','id="systemComma" class="form-control" required'),
            'select_net' => FormHelper::formDropdown('network', $opt_lev,'','id="network" class="form-control" required'),
            'select_net_comma' => FormHelper::formDropdown('network_comma', $opt_lev_com,'','id="networkComma" class="form-control" required'),
            'isModuleCode' => self::$moduleCode
        ];

        return view('srs::soiForm', $data);
    }

    public function listTable(Request $req)
    {
        $get_json_data = SoiModel::listTable($req);
         
        echo json_encode($get_json_data);
    }

    public function edit()
    {
        $id = request()->segments()[3];

        if ($id == '')
        {
            return redirect('srs/soi')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> ID tidak ditemukan');
        }
        else
        {
            $get_edit = SoiModel::edit($id);
            $data_area = SoiModel::area();
            // dd($get_edit);

            if($get_edit !== NULL)
            {
                $data_edit = $get_edit[0];

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

                $firstYear = (int)date('Y') - 4; // - 84
                $lastYear = $firstYear + 4; // + 2
                $opt_yea = array('' => '-- Year --');
                for($i=$firstYear;$i<=$lastYear;$i++)
                {
                    $opt_yea[$i] = $i;
                }

                $data = [
                    'link' => request()->segments()[1],
                    'sub_link' => empty(request()->segments()[2]) ? '' : request()->segments()[2],
                    'select_area' => FormHelper::formDropdown('area', $opt_are, $data_edit->area_id,'id="area" class="form-control" required'),
                    'select_years' => FormHelper::formDropdown('year', $opt_yea, $data_edit->year,'id="years" class="form-control" required'),
                    'select_month' => FormHelper::formDropdown('month', $opt_mon, $data_edit->month,'id="month" class="form-control" required'),
                    'data_edit' => $data_edit
                ];
                
                return view('srs::soiFormEdit', $data);
            }
            else
            {
                return redirect('srs/soi')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak ditemukan');
            }
        }
    }

    public function getPerformanceGt(Request $req)
    {
        $area = $req->input('area', true);
        $year = $req->input('year', true);
        $month = $req->input('month', true);

        $perform_gt = SoiModel::getPerformanceGt($req);

        $sum_persen = 0;
        foreach ($perform_gt as $key => $pgt) {
            $sum_persen += $pgt->persentase;
        }

        $jumlahPatroli = 3; // Jumlah patroli dalam sehari
        $totalHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $totalArea = 1;
        $total = round($sum_persen / ($jumlahPatroli * $totalHari) / $totalArea, 0);

        $data = array(
            'performance_gt' => $total,
        );

        echo json_encode($data, true);
    }

    public function detailData(Request $req)
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
            $res = SoiModel::detail($req);

            if($res)
            {
                $opt = '<table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Area</th>
                                    <td>'.$res[0]->area.'</td>
                                </tr>
                                <tr>
                                    <th>Year</th>
                                    <td>'.$res[0]->year.'</td>
                                </tr>
                                <tr>
                                    <th>Month</th>
                                    <td>'.date("F", mktime(0, 0, 0, $res[0]->month, 10)).'</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table table-bordered">
                                            <tr class="text-center">
                                                <th colspan="2">People</th>
                                                <th colspan="2">System</th>
                                                <th>Device</th>
                                                <th>Network</th>
                                            </tr>
                                            <tr>
                                                <th>Knowlage</th>
                                                <th class="text-center font-weight-normal">'.$res[0]->knowlage.'</th>
                                                <th>ASMS Value</th>
                                                <th class="text-center font-weight-normal">'.$res[0]->asms_value.'</th>
                                                <th rowspan="3"></th>
                                                <th rowspan="3"></th>
                                            </tr>
                                            <tr>
                                                <th>Attitude</th>
                                                <th class="text-center font-weight-normal">'.$res[0]->attitude.'</th>
                                                <th>Perform Guard Tour</th>
                                                <th class="text-center font-weight-normal">'.$res[0]->perform_gt.'</th>
                                            </tr>
                                            <tr>
                                                <th>Skill</th>
                                                <th class="text-center font-weight-normal">'.$res[0]->skill.'</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr class="text-center">
                                                <th colspan="2" >'.$res[0]->people.'</th>
                                                <th colspan="2">'.$res[0]->system.'</th>
                                                <th>'.$res[0]->device.'</th>
                                                <th>'.$res[0]->network.'</th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Note</th>
                                    <td>
                                        <textarea class="form-control" disabled>'.$res[0]->note.'</textarea>
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
    }

    public function saveData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'area' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/soi')->with('error', 'ID tidak ditemukan');
        }
        else
        {
            $res = SoiModel::saveData($req);

            if($res == '00')
            {
                return redirect('srs/soi')->with('success', '<i class="icon fas fa-check"></i> Berhasil menyimpan data');
            }
            else
            {
                return redirect('srs/soi')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menyimpan data');
            }
        }
    }

    public function updateData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/soi')->with('error', 'ID tidak ditemukan');
        }
        else
        {
            $res = SoiModel::updateData($req);

            if($res == '00')
            {
                return redirect('srs/soi')->with('success', '<i class="icon fas fa-check"></i> Berhasil memperbarui data');
            }
            else
            {
                return redirect('srs/soi')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal memperbarui data');
            }
        }
    }

    public function approveData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/soi')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> ID tidak ditemukan');
        }
        else
        {
            $res = SoiModel::approveData($req);

            if($res == '00')
            {
                return redirect('srs/soi')->with('success', '<i class="icon fas fa-check"></i> Berhasil approve data');
            }
            else
            {
                return redirect('srs/soi')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Tidak dapat menyetujui data');
            }
        }
        
        redirect('analitic/srs/soi');
    }

    public function deleteData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/soi')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> ID tidak ditemukan');
        }
        else
        {
            $res = SoiModel::deleteData($req);

            if($res == '00')
            {
                return redirect('srs/soi')->with('success', '<i class="icon fas fa-check"></i> Berhasil menghapus data');
            }
            else
            {
                return redirect('srs/soi')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            }

        }
    }
}