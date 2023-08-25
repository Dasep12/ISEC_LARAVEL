<?php

namespace Modules\Srs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use AuthHelper;
use Modules\Srs\Entities\InternalsourceModel;

class InternalsourceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // $post_data = InternalsourceModel::select('*')->where('disable', '=', 0)
        // // ->orWhere('event_name', 'LIKE',"%{$search_text}%")
        // // ->offset($start_val)
        // ->limit(3)
        // // ->orderBy($order,$dir_val)
        // ->get();

        // dd($post_data);die();

        $data_area = InternalsourceModel::area();
        $no = InternalsourceModel::no_urut();
        $data_subarea = InternalsourceModel::sub_area();
        $data_ass = InternalsourceModel::assest();
        $data_rso = InternalsourceModel::risk_source();
        $data_ris = InternalsourceModel::risk();
        $data_rle = InternalsourceModel::risk_level();
        $data_vle = InternalsourceModel::vurnability_level();

        $opt_are = array();
        foreach ($data_area as $key => $are) {
            $opt_are[$are->id] = $are->title;
        }

        $opt_are_fil = array('' => '-- All --');
        foreach ($data_area as $key => $are) {
            $opt_are_fil[$are->id] = $are->title;
        }

        $opt_subarea = array();
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

        // dd($opt_subarea);

        $data = [
            'link' => 'internal_source',
            'sub_link' => '',
            'no_urut' => $no[0]->no_urut,
            'no_ref' => $no[0]->no_urut,
            'select_area' => $opt_are,
            'select_area_filter' => $opt_are_fil,
            'select_subarea1' => $opt_subarea,
            'select_ass' => $opt_ass,
            'select_rso' => $opt_rso,
            'select_ris' => $opt_ris,
            'select_rle' => $opt_rle,
            'select_fin' => $opt_fin,
            'select_sdm' => $opt_sdm,
            'select_ope' => $opt_ope,
            'select_rep' => $opt_rep,
        ];

        return view('srs::formIso', $data);
    }

    public function listTable(Request $request)
    {
        $get_json_data = InternalsourceModel::listTable($request);
         
        echo json_encode($get_json_data);
    }

    public function listTables(Request $request)
    {
        $role = AuthHelper::user_role();
        $npk = AuthHelper::user_npk();
        
        // if ($request->ajax())
        // {
            // $dataIso = InternalsourceModel::listTable();

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

            dd($columnIndex_arr);die();

            $columnSortOrder = $order_arr[0]['dir']; // asc or desc

            // Total records
            $totalRecords = InternalsourceModel::select('count(*) as allcount')->count();
            $totalRecordswithFilter = InternalsourceModel::select('count(*) as allcount')->where('srs_bi.dbo.admiseciso_transaction.event_name', 'like', '%' .$searchValue . '%')->count();

            // Fetch records
            $records = InternalsourceModel::orderBy($columnName,$columnSortOrder)
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
                    // "id" => $id,
                    "event_name" => $record->event_name,
                    "event_date" => date('d F Y H:i', strtotime($record->event_date)),
                    // "area" => 1,
                    // "assets" => 2,
                    // "risk_source" => 3,
                    // "risk" => 4,
                    // "impact_level" => 5,
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

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function save()
    {
        echo 'save';die();
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
