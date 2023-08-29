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
    public function __construct()
    {
        $this->middleware('is_login_isec');
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