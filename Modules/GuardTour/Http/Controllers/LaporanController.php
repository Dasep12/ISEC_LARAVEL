<?php

namespace Modules\GuardTour\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GuardTour\Entities\LaporanPatroli;
use Modules\GuardTour\Entities\Plants;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function master()
    {

        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        $plant =  Session('role') == 'SUPERADMIN' ? Plants::where('status', 1)->get() : Plants::where([
            ['admisecsgp_mstsite_site_id', '=', Session('site_id')],
            ['status', '=', 1],
        ])->get();
        return view('guardtour::laporan_patroli/form_laporan', [
            'uri'        => $uri,
            'plant'      => $plant
        ]);
    }

    public function list_patroli(Request $req)
    {
        $plantId = $req->plantId;
        $start = $req->start;
        $end = $req->end;
        $type = $req->type;

        $data = [];
        if ($plantId != '') {
            $data = LaporanPatroli::getDataPatroli($plantId, $start, $end, $type);
        }


        return response()->json($data);
    }


    public function detail(Request $req)
    {
        $idJadwal = $req->get('idJadwal');
        $npk = $req->get('npk');
        $type = $req->get('type');


        $detail  = LaporanPatroli::getDataDetailPatroli($idJadwal, $npk, $type);
        $timeline = LaporanPatroli::timelineDetail($idJadwal, $npk, $type);
        $uri =  \Request::segment(2) . '/' . \Request::segment(3);
        return view('guardtour::laporan_patroli/laporan_detail_patroli', [
            'uri'        => $uri,
            'detail'    => $detail,
            'timeline' => $timeline,
        ]);
    }

    public function downloadLaporanPatroli()
    {

        // $plantId = $this->input->get('plantId');
        // $start = $this->input->get('start');
        // $end = $this->input->get('end');
        // $type = $this->input->get('type');


        // $start_at = date("dmY", strtotime($start));
        // $end_at = date("dmY", strtotime($end));

        // $dataPatroli = LaporanPatroli::getDataPatroli($plantId, $start, $end, $type);

        // header('Content-Type:application/vnd-ms-excel');
        // header('Content-Disposition: attachment;filename="laporan_patroli_' . $start_at . '__' . $end_at . '.xlsx"');

        // $excol = new ExCol();
        // $excol->reset(); // reset mapping before using
        // $spreadsheet = new Spreadsheet();
        // $styleHeader = [
        //     'font' => [
        //         'bold' => true,
        //     ],
        //     'alignment' => [
        //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        //     ],
        //     'borders' => [
        //         'allBorders' => [
        //             'borderStyle' => Border::BORDER_THIN,
        //         ],
        //     ],
        // ];

        // $sheet = $spreadsheet->getActiveSheet();
        // if ($type == 1) {
        //     $sheet->mergeCells('A1:D1')->setCellValue('A1', 'LAPORAN PATROLI DILUAR JADWAL');
        // } else {
        //     $sheet->mergeCells('A1:D1')->setCellValue('A1', 'LAPORAN PATROLI ');
        // }
        // $sheet->setTitle('Data Patroli');

        // $sheet->getStyle('A1:D1')
        //     ->getFont()
        //     ->setSize(20)
        //     ->setBold(true);
        // $sheet->setCellValue('A3', 'Tanggal Patroli');
        // $sheet->setCellValue('B3', $start_at . ' s/d ' . $end_at);
        // $sheet->setCellValue('A4', 'Plant');
        // $sheet->setCellValue('B4', $plantId);
        // $xrow = 5;
        // // Header
        // $sheet->setCellValue($excol->get('tanggal_patroli', $xrow), 'Tanggal Patroli');
        // $sheet->setCellValue($excol->get('shift', $xrow), 'Shift');
        // $sheet->setCellValue($excol->get('nama', $xrow), 'PELAKSANA');
        // $sheet->setCellValue($excol->get('npk', $xrow), 'NPK');
        // $sheet->setCellValue($excol->get('mulai', $xrow), 'Waktu Mulai');
        // $sheet->setCellValue($excol->get('selesai', $xrow), 'Waktu Selesai');
        // $sheet->setCellValue($excol->get('duration', $xrow), 'Durasi');
        // $sheet->setCellValue($excol->get('total_checkpoint', $xrow), 'Total Checkpoint');
        // $sheet->setCellValue($excol->get('total_object', $xrow), 'Total Objek Patroli');
        // $sheet->setCellValue($excol->get('total_temuan', $xrow), 'Total Temuan');
        // $sheet->setCellValue($excol->get('completion', $xrow), 'Completion');
        // $sheet->getStyle($excol->get('tanggal_patroli', $xrow) . ':' . $excol->get('completion', $xrow))->applyFromArray($styleHeader);

        // // Rows
        // foreach ($dataPatroli as $row) {
        //     $xrow++;
        //     $start = new DateTime($row->start_at);
        //     $end = new DateTime($row->end_at);
        //     $interval = $start->diff($end)->format('%i');
        //     $percentage = 0;
        //     if ($row->total_ckp != 0) {
        //         $percentage = ($row->chekpoint_patroli / $row->total_ckp) * 100;
        //     }
        //     $sheet->setCellValue($excol->get('tanggal_patroli', $xrow), $row->date_patroli);
        //     $sheet->setCellValue($excol->get('shift', $xrow), $row->nama_shift);
        //     $sheet->setCellValue($excol->get('nama', $xrow), $row->name);
        //     $sheet->setCellValue($excol->get('npk', $xrow), $row->npk);
        //     $sheet->setCellValue($excol->get('mulai', $xrow), $row->start_at);
        //     $sheet->setCellValue($excol->get('selesai', $xrow), $row->end_at);
        //     $sheet->setCellValue($excol->get('duration', $xrow), $interval);
        //     $sheet->setCellValue($excol->get('total_checkpoint', $xrow), $row->total_ckp);
        //     $sheet->setCellValue($excol->get('total_object', $xrow), $row->target_object);
        //     $sheet->setCellValue($excol->get('total_temuan', $xrow), $row->total_object_temuan);
        //     $sheet->setCellValue($excol->get('completion', $xrow), $percentage . '%');
        //     // set header style
        //     $sheet->getStyle($excol->get('tanggal_patroli', $xrow) . ':' . $excol->get('completion', $xrow))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        //     //sheet detail
        //     if ($percentage > 0) {

        //         $timeline = $this->M_LaporanPatroli->timelineDetail($row->id_jadwal_patroli, $row->npk, $type);

        //         $excolDetail = new ExCol();

        //         $sheetDetail = $spreadsheet->createSheet();
        //         $sheetDetail->setTitle('Timeline' . $row->date_patroli . ' Shift ' . $row->nama_shift);
        //         if ($type == 1) {
        //             $sheetDetail->mergeCells('A1:E1')->setCellValue('A1', 'DETAIL PATROLI DILUAR JADWAL');
        //         } else {
        //             $sheetDetail->mergeCells('A1:E1')->setCellValue('A1', 'DETAIL PATROLI ');
        //         }
        //         $sheetDetail->getStyle('A1:B1')
        //             ->getFont()
        //             ->setSize(20)
        //             ->setBold(true);
        //         $sheetDetail->setCellValue('A3', 'Tanggal Patroli');
        //         $sheetDetail->setCellValue('B3', $row->date_patroli);
        //         $sheetDetail->setCellValue('A4', 'Shift');
        //         $sheetDetail->setCellValue('B4', $row->nama_shift);
        //         $sheetDetail->setCellValue('A5', 'Pelaksana');
        //         $sheetDetail->setCellValue('B5', $row->name);
        //         $sheetDetail->setCellValue('A6', 'NPK');
        //         $sheetDetail->setCellValue('B6', $row->npk);
        //         $sheetDetail->setCellValue('C3', 'Target Checkpoint');
        //         $sheetDetail->setCellValue('D3', $row->total_ckp);
        //         $sheetDetail->setCellValue('C4', 'Target Object');
        //         $sheetDetail->setCellValue('D4', $row->target_object);
        //         $sheetDetail->setCellValue('C5', 'Total Object Normal');
        //         $sheetDetail->setCellValue('D5', $row->total_object_normal);
        //         $sheetDetail->setCellValue('C6', 'Total Object Temuan');
        //         $sheetDetail->setCellValue('D6', $row->total_object_temuan);
        //         $sheetDetail->setCellValue('C7', 'Persentase');
        //         $sheetDetail->setCellValue('D7', $row->target_object);
        //         $sheetDetail->getStyle('A3:D7')->applyFromArray($styleHeader);

        //         $dxrow = 9;
        //         // Sheet Detail Header
        //         $sheetDetail->setCellValue($excolDetail->get('detail_start_at', $dxrow), 'Waktu Mulai');
        //         $sheetDetail->setCellValue($excolDetail->get('detail_end_at', $dxrow), 'Waktu Selesai');
        //         $sheetDetail->setCellValue($excolDetail->get('detail_check_name', $dxrow), 'Nama Checkpoint');
        //         $sheetDetail->setCellValue($excolDetail->get('detail_duration', $dxrow), 'Durasi (menit)');
        //         $sheetDetail->setCellValue($excolDetail->get('detail_total_temuan', $dxrow), 'Total Temuan');

        //         //set detail header style
        //         $sheetDetail->getStyle($excolDetail->get('detail_start_at', $dxrow) . ':' . $excolDetail->get('detail_total_temuan', $dxrow))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        //         foreach ($timeline as $item) {
        //             $dxrow++;
        //             $sheetDetail->setCellValue($excolDetail->get('detail_start_at', $dxrow), $item->start_at);
        //             $sheetDetail->setCellValue($excolDetail->get('detail_end_at', $dxrow), $item->end_at);
        //             $sheetDetail->setCellValue($excolDetail->get('detail_check_name', $dxrow), $item->check_name);
        //             $sheetDetail->setCellValue($excolDetail->get('detail_duration', $dxrow), $item->durasi);
        //             $sheetDetail->setCellValue($excolDetail->get('detail_total_temuan', $dxrow), $item->total_temuan);

        //             //apply style
        //             $sheetDetail->getStyle($excolDetail->get('detail_start_at', $dxrow) . ':' . $excolDetail->get('detail_total_temuan', $dxrow))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        //         }
        //     }
        // }

        // foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
        //     $spreadsheet->setActiveSheetIndex($spreadsheet->getIndex($worksheet));
        //     $sheet = $spreadsheet->getActiveSheet();
        //     $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        //     $cellIterator->setIterateOnlyExistingCells(true);
        //     foreach ($cellIterator as $cell) {
        //         $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        //     }
        // }
        // $writer = new Xlsx($spreadsheet);
        // $writer->save("php://output");
    }
}
