<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Modules\Srs\Entities\OsintModel;

use AuthHelper,FormHelper;

class OsintController extends Controller
{
    private static $moduleCode = 'SRSOSI';
    
    public function __construct()
    {
        $this->middleware('is_login_isec');
        $this->middleware('roleauth:SRSOSI');
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
            'vulne' => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 6]),
            'sdm' => OsintModel::levelVurne(7),
            'reput' => OsintModel::levelVurne(8),
            'media' => OsintModel::getCategory(4),
            'hatespeech' => FormHelper::formDropdown('hatespeech', $opt_hatespeech, '','id="hatespeech" class="form-control" required'),
            'regional' => FormHelper::formDropdown('regional', $opt_regional,'','id="regional" class="form-control" required'),
            'legalitas' => FormHelper::formDropdown('legalitas', $opt_legalitas,'','id="legalitas" class="form-control" required'),
            'format' => FormHelper::formDropdown('format', $opt_format,'','id="format" class="form-control" required'),
            'isModuleCode' => self::$moduleCode
        ];

        return view('srs::osintForm', $data);
    }

    public function listTable(Request $req)
    {
        $get_json_data = OsintModel::listTable($req);
         
        echo json_encode($get_json_data);
    }
    
    public function getSubArea(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub1_header_data", ['sub_header_data' => $id]);
        echo json_encode($res);
    }

    public function getSubArea1(Request $req)
    {
        $id = $req->input("id");
        $plant_id = $req->input("plant");
        $res = OsintModel::getDataWhere("admisecosint_sub2_header_data", ['sub1_header_id' => $id, 'plant_id' => $plant_id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getIssue(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub1_header_data", ['sub_header_data' => $id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getSubIssue(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub2_header_data", ['sub1_header_id' => $id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getSubIssue1(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub3_header_data", ['sub2_header_id' => $id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getRiskSource(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub1_header_data", ['sub_header_data' => $id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getRiskSource1(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub2_header_data", ['sub1_header_id' => $id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getIssuMedia(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub1_header_data", ['sub_header_data' => $id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getSubissuMedia(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub2_header_data", ['sub1_header_id' => $id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getSubissuMedia1(Request $req)
    {
        $id = $req->input("id");
        $res = OsintModel::getDataWhere("admisecosint_sub3_header_data", ['sub2_header_id' => $id]);
        if ($res->count() > 0) {
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    public function getCategorySub1(Request $req)
    {
        $res = OsintModel::getCategorySub1($req);

        $opt = '<div class="form-group col-3">
                <label for="legalitasSub1"></label>
                <select id="legalitasSub1" class="form-control" name="legalitas_sub1" required>';
            $opt .= '<option value="">-- Select --</option>';
                foreach ($res as $key => $sub) {
                     // $opt .= '<option value="'.$sub->id.':'.$sub->level_id.':'.$sub->level.'">'.$sub->name.'</option>';
                     $opt .= '<option value="'.$sub->id.'">'.$sub->name.'</option>';
                }
        $opt .=  '</select>
                <span id="load12" style="display: none;" class="font-italic text-white">loading data</span>
            </div>';

        echo $opt;
    }
    
    public function saveData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'event_date' => 'required',
            'activity_name' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/osint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak lengkap');
        }
        else
        {
            $res = OsintModel::saveData($req);

            if ($res == "00") 
            {
                return redirect('srs/osint_source')->with('success', '<i class="icon fas fa-check"></i> Berhasil menyimpan data');
            } else {
                return redirect('srs/osint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menyimpan data');
            }

        }
    }

    public function edit(Request $req)
    {
        $id  = $req->input("id");

        $data_edit = OsintModel::edit($req);

        $hatespeech = OsintModel::getCategory(5);
        $regional = OsintModel::getCategory(10);
        $legalitas = OsintModel::getCategory(11);
        $format = OsintModel::getCategory(12);
        $media = OsintModel::getCategory(4);
        $mediaSub1 = OsintModel::getCategorySub1($req, $data_edit->media_id);
        $legalitasSub1 = OsintModel::getCategorySub1($req, $data_edit->legalitas_id);

        $opt_regional = array('' => '-- Select --');
        foreach ($regional as $key => $reg) {
            $opt_regional[$reg['sub_id']] = ucwords($reg['name']);
        }

        $opt_legalitas = array('' => '-- Select --');
        foreach ($legalitas as $key => $leg) {
            $opt_legalitas[$leg['sub_id']] = ucwords($leg['name']);
        }

        $opt_format = array('' => '-- Select --');
        foreach ($format as $key => $for) {
            $opt_format[$for['sub_id']] = ucwords($for['name']);
        }

        $opt_media = array('' => '-- Select --');
        foreach ($media as $key => $med) {
            // $opt_media[$med['sub_id'].':'.$med['level_id'].':'.$med['level']] = ucwords($med['name']);
            $opt_media[$med['sub_id']] = ucwords($med['name']);
        }

        $opt_mediaSub1 = array('' => '-- Select --');
        foreach ($mediaSub1 as $key => $mes1) {
            $opt_mediaSub1[$mes1->id] = ucwords($mes1->name);
        }

        $opt_legalitasSub1 = array('' => '-- Select --');
        foreach ($legalitasSub1 as $key => $les1) {
            $opt_legalitasSub1[$les1->id] = ucwords($les1->name);
        }

        $opt_hatespeech = array('' => '-- Select --');
        foreach ($hatespeech as $key => $hat) {
            $opt_hatespeech[$hat['sub_id'].':'.$hat['level_id'].':'.$hat['level']] = ucwords($hat['name']);
        }

        $data = [
            'data'  => $data_edit,
            'link' => request()->segments()[1],
            'sub_link' => empty(request()->segments()[2]) ? '' : request()->segments()[2],
            'plant'     => OsintModel::getPlant(),
            'area'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 1, 'status'=>1]),
            'targetIssue'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 2]),
            'riskSource'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 3]),
            'media' => FormHelper::formDropdown('mediaIssue', $opt_media, $data_edit->media_id,'id="mediaIssue" class="form-control" required'),
            // 'media' => FormHelper::formDropdown('mediaIssue', $opt_media, $data_edit->media_id.':'.$data_edit->media_level_id.':'.$data_edit->media_level ,'id="mediaIssue" class="form-control" required'),
            'mediaSub1' => FormHelper::formDropdown('SubmediaIssue', $opt_mediaSub1, $data_edit->sub_media_id,'id="SubmediaIssue" class="form-control" required'),
            'riskTarget'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 5]),
            'vulne'      => OsintModel::getDataWhere("admisecosint_sub_header_data", ['header_data_id' => 6]),
            'sdm'      => OsintModel::levelVurne(7),
            'reput'      => OsintModel::levelVurne(8),
            'file_edit'  => OsintModel::getDataWhere("admisecosint_transaction_file", ['trans_id' => $id, 'status' => 1]),
            'regional' => FormHelper::formDropdown('regional', $opt_regional, $data_edit->regional_id, 'id="regional" class="form-control" required'),
            'legalitas' => FormHelper::formDropdown('legalitas', $opt_legalitas, $data_edit->legalitas_id,'id="legalitas" class="form-control" required'),
            'legalitasSub1' => FormHelper::formDropdown('legalitas_sub1', $opt_legalitasSub1, $data_edit->legalitas_sub1_id, 'id="legalitasSub1" class="form-control" required'),
            'format' => FormHelper::formDropdown('format', $opt_format, $data_edit->format_id,'id="format" class="form-control" required'),
            'hatespeech' => FormHelper::formDropdown('hatespeech', $opt_hatespeech, $data_edit->hatespeech_type_id.':'.$data_edit->risk_level_id.':'.$data_edit->risk_level,'id="hatespeech" class="form-control" required'),
            'isModuleCode' => self::$moduleCode
        ];

        return view('srs::osintFormEdit', $data);
    }

    public function updateData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);
 
        if ($validator->fails())
        {
            return redirect('srs/osint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Data tidak lengkap');
        }
        else
        {
            $res = OsintModel::updateData($req);

            if ($res == "00") 
            {
                return redirect('srs/osint_source')->with('success', '<i class="icon fas fa-check"></i> Berhasil memperbarui data');
            } else {
                return redirect('srs/osint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal memperbarui data');
            }

        }
    }

    public function deleteData(Request $req)
    {
        $res = OsintModel::deleteData($req);

        if ($res == "00") {
            return redirect('srs/osint_source')->with('success', '<i class="icon fas fa-check"></i> Berhasil menghapus data');
        } else {
            return redirect('srs/osint_source')->with('error', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
        }
    }

    public function deleteAttached(Request $req)
    {
        $remove = OsintModel::deleteAttached($req);
        echo $remove;
    }
    
    public function search(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'keyword' => 'required',
        ]);
 
        if ($validator->fails())
        {
            echo 'Form tidak sesuai';
        }
        else
        {
            $res = OsintModel::search($req);

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
                $lampiran = DB::connection('srsbi')->table("admisecosint_transaction_file")->where(['trans_id' => $data->id, 'status' => 1])->get();
                
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
                <td><a href="' . url('uploads/srsbi/osint/' . $fla->file_name) . '" target="_blank">View</a></td></tr>';
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
                <tr>
                    <th>Description</th>
                    <td colspan="4" class="font-weight-bold">'.html_entity_decode($data->description).'</td>
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