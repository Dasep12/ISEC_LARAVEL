<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Modules\Srs\Entities\OsintModel;

use AuthHelper;
use FormHelper;

class OsintController extends Controller
{
    public $module_code = 'SRSOSI';
    
    public function __construct()
    {
        $this->middleware('is_login_isec');
    }
    
    public function index()
    {
        $regional = OsintModel::getCategory(10);
        $legalitas = OsintModel::getCategory(11);
        $format = OsintModel::getCategory(12);
        $hatespeech = OsintModel::getCategory(5);

        $opt_regional = array('' => '-- Select --');
        foreach ($regional as $key => $reg) {
            $opt_regional[$reg['sub_id'].':'.$reg['level_id'].':'.$reg['level']] = ucwords($reg['name']);
        }

        $opt_legalitas = array('' => '-- Select --');
        foreach ($legalitas as $key => $leg) {
            $opt_legalitas[$leg['sub_id']] = ucwords($leg['name']);
        }

        $opt_format = array('' => '-- Select --');
        foreach ($format as $key => $for) {
            // $opt_format[$for['sub_id'].':'.$for['level_id'].':'.$for['level']] = ucwords($for['name']);
            $opt_format[$for['sub_id']] = ucwords($for['name']);
        }

        $opt_hatespeech = array('' => '-- Select --');
        foreach ($hatespeech as $key => $hat) {
            // $opt_hatespeech[$hat['sub_id'].':'.$hat['level_id'].':'.$hat['level']] = ucwords($hat['name']);
            $opt_hatespeech[$hat['sub_id'].':'.$hat['level_id'].':'.$hat['level']] = ucwords($hat['name']);
        }

        $data = [
            'link' => request()->segments()[1],
            'sub_link' => empty(request()->segments()[2]) ? '' : request()->segments()[2],
            'plant' => OsintModel::getPlant(),
            'area' => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 1]),
            'targetIssue'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 2]),
            'riskSource'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 3]),
            'riskTarget'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 5]),
            'vulne'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 6]),
            'sdm' => OsintModel::levelVurne(7),
            'reput' => OsintModel::levelVurne(8),
            'media' => OsintModel::getCategory(4),
            'hatespeech' => FormHelper::formDropdown('hatespeech', $opt_hatespeech, '','id="hatespeech" class="form-control" required'),
            'regional' => FormHelper::formDropdown('regional', $opt_regional,'','id="regional" class="form-control" required'),
            'legalitas' => FormHelper::formDropdown('legalitas', $opt_legalitas,'','id="legalitas" class="form-control" required'),
            'format' => FormHelper::formDropdown('format', $opt_format,'','id="format" class="form-control" required'),
        ];

        return view('srs::osintForm', $data);
    }

    public function detail(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo '<h5>Data tidak ditemukan';
        }
        else
        {
            $result = OsintModel::getDetail($req);

            if ($result) 
            {
                $data = $result;
                $name = DB::connection('sqlsrv')->table("admisecsgp_mstusr")->where(['npk' => $data->created_by])->first();
                $lampiran = DB::connection('srsbi')->table("admisecosint_transaction_file")->where(['trans_id' => $data->id])->first();
                $opt = '<div class="table-responsive">';
                $opt .= '<table class="table table-borderless mb-3">
                                <tr>
                                    <th width="10" style="padding: .10rem 1rem .7rem 0">Author</th>
                                    <td style="padding: .10rem 1rem .7rem 0">: ' . $name->name . '</td>
                                </tr>
                                <tr>
                                    <th width="10" style="padding: .10rem 1rem .7rem 0">Created</th>
                                    <td style="padding: .10rem 1rem .7rem 0">: ' . date("d/m/Y H:i",strtotime($name->created_at)) . '</td>
                                </tr>
                            </table>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Activities</th>
                                        <td colspan="4">' . $data->activity_name . '</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td colspan="4">' . date('d F Y ', strtotime($data->date)) . '</td>
                                    </tr>
                                    <tr>
                                        <th>Area</th>
                                        <td colspan="4">' . $data->plant . '</td>
                                    </tr>
                                    <tr>
                                        <th>Target Issue</th>
                                        <td colspan="4">' . $data->target_issue . '</td>
                                    </tr>
                                    <tr>
                                        <th>Risk Source</th>
                                        <td colspan="4">' . $data->risk_source_sub . '</td>
                                    </tr>
                                    <tr>
                                        <th>Media</th>
                                        <td>' . $data->media . '</td>
                                    </tr>
                                    <tr>
                                        <th>Regional</th>
                                        <td>' . $data->regional_name . '</td>
                                    </tr>
                                    <tr>
                                        <th>Legalitas</th>
                                        <td>' . $data->legalitas_name . ': '.$data->legalitas_sub1_name.'</td>
                                    </tr>
                                    <tr>
                                        <th>Format</th>
                                        <td>' . $data->format_name . '</td>
                                    </tr>
                                    <tr>
                                        <th>Negative Sentiment</th>
                                        <td colspan="4">' . $data->negative_sentiment . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table class="table table-borderless mb-0 text-center">
                                                <td>
                                                    <table class="table table-bordered mb-0 text-center">
                                                        <tr>
                                                            <th>Risk Level :</th>
                                                            <td>' . $data->risk_level . '</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>
                                                    <table class="table table-bordered mb-0 text-center">
                                                        <tr>
                                                            <th>Impact Level :</th>
                                                            <td>' . $data->impact_level . '</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </table>
                                        </td>
                                    </tr>
                        <tr>
                            <th>Attachment</th>
                            <td colspan="4">
                                <table class="table table-bordered text-center">
                                    <tbody>';

                foreach ($lampiran as $fla) {
                    if (!empty($fla->file_name)) {
                        $opt .= '<tr><th>' . $fla->file_name . '</th>
                <td><a href="' . site_url('uploads/srs_bi/osint/' . $fla->file_name) . '" target="_blank">View</a></td></tr>';
                    }
                }
                $opt .= '
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>URL 1</th>
                    <td colspan="4"><a href="'.$data->url1.'" target="_blank">' . $data->url1 . '</a></td>
                </tr>
                <tr>
                    <th>URL 2</th>
                    <td colspan="4"><a href="'.$data->url2.'" target="_blank">' . $data->url2 . '</a></td>
                </tr>
                    </tbody>
                </table>';
                $opt .= '</div>';

                echo $opt;
            } else {
                echo '<h5>Data tidak ditemukan';
            }
        }
    }

}