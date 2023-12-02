<?php

namespace Modules\Crime\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Crime\Entities\DashboardModel;


class CrimeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('crime::dashboard/dashboard', [
            'uri'   => \Request::segment(2),
        ]);
    }

    public function index_v2()
    {
        return view('crime::dashboard/index', [
            'uri'   => \Request::segment(2),
        ]);
    }

    // kategori crime Jakarta Karawang
    private function crimeSetahun($req, $kat)
    {
        $grap_trans_area  = DashboardModel::crimeKategoriSetahun($req, $kat);
        $tar_arr = array();
        foreach ($grap_trans_area as $key => $tar) {
            $tar_arr[] = (int) $tar->total;
        }
        return $tar_arr;
    }

    // graphic 1 &  2
    public function graphicSetahunKategori(Request $req)
    {
        $criteria = ['Pencurian', 'Kekerasan', 'Narkoba', 'Perjudian', 'Penggelapan'];
        $res = array();
        for ($i = 0; $i < count($criteria); $i++) {
            $data = array('label' => $criteria[$i], 'data' => self::crimeSetahun($req, $criteria[$i]));
            $res[] = $data;
        }
        return response()->json($res);
    }

    // Graphic 3 & 4 
    public function graphicCrimeKecamatanSetahun(Request $req)
    {
        $year = $req->input("year");
        $type = $req->input("type");
        $kota = $req->input("kota");
        if ($kota == "Jakarta Utara") {
            $criteria = ['Penjaringan', 'Tanjung Priok', 'Cilincing', 'Kelapa Gading', 'Pademangan', 'Koja'];
        } else {
            $criteria = ['Teluk Jambe Barat', 'Teluk Jambe Timur', 'Klari', 'Ciampel', 'Majalaya', 'Karawang Barat', 'Karawang Timur'];
        }
        $res = array();
        for ($i = 0; $i < count($criteria); $i++) {
            $data = array('label' => $criteria[$i], 'data' => self::crimeKecamatanSetahun($criteria[$i],  $req));
            $res[] = $data;
        }
        $datas = array(
            // array(self::crimeAreaSetahun($kota, $year, $type)),
            [],
            $res
        );
        return response()->json($datas);
    }

    // public function graphicKarawangSetahun(Request $req)
    // {
    //     $year = $req->input("year");
    //     $criteria = ['Pencurian', 'Kekerasan', 'Narkoba', 'Perjudian', 'Penggelapan'];

    //     $res = array();
    //     for ($i = 0; $i < count($criteria); $i++) {
    //         $data = array('label' => $criteria[$i], 'data' => self::crimeSetahun($year, "Karawang", $criteria[$i]));
    //         $res[] = $data;
    //     }
    //     // echo json_encode($res);
    //     return response()->json($res);
    // }
    // 

    private function crimeAreaSetahun($kota, $year, $type)
    {
        $grap_trans_area  = DashboardModel::countCrimeAreaSetahun($kota, $year, $type);
        $tar_arr = array();
        foreach ($grap_trans_area as $key => $tar) {
            $tar_arr[] = (int) $tar->total;
        }
        return $tar_arr;
    }

    private function crimeKecamatanSetahun($area, $req)
    {
        $grap_trans_area  =  DashboardModel::crimePerKecamatanSetahun($area, $req);
        $tar_arr = array();
        foreach ($grap_trans_area as $key => $tar) {
            $tar_arr[] = (int)$tar->total;
        }
        return $tar_arr;
    }

    // public function graphicKecamatanKarawangSetahun(Request $req)
    // {
    //     $year = $req->input("year");
    //     $type = $req->input("type");
    //     $criteria = ['Teluk Jambe Barat', 'Teluk Jambe Timur', 'Klari', 'Ciampel', 'Majalaya', 'Karawang Barat', 'Karawang Timur'];
    //     $res = array();
    //     for ($i = 0; $i < count($criteria); $i++) {
    //         $data = array('label' => $criteria[$i], 'data' => self::crimeKecamatanSetahun($criteria[$i], "Karawang", $year));
    //         $res[] = $data;
    //     }
    //     $datas = array(
    //         array(self::crimeAreaSetahun("Karawang", $year, $type)),
    //         $res
    //     );
    //     // echo json_encode($datas);
    //     return response()->json($datas);
    // }

    public function mapingKategoriJakut(Request $req)
    {

        $data = array(
            array('Pademangan', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "kekerasan", $req),
            )), array('Koja', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("koja", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("koja", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("koja", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("koja", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("koja", "kekerasan", $req),
            )),
            array('Tanjung Priok', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "kekerasan", $req),
            )),
            array('Penjaringan', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "kekerasan", $req),
            )),
            array('Cilincing', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "kekerasan", $req),
            )),
            array('Kelapa Gading', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "kekerasan", $req),
            ))
        );

        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($data);
        return response()->json($data);
    }


    public function mapingKategoriKarawang(Request $req)
    {

        $data = array(
            array('Teluk Jambe Barat', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "kekerasan", $req),
            )),
            array('Teluk Jambe Timur', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "kekerasan", $req),
            )),
            array('Klari', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("klari", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("klari", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("klari", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("klari", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("klari", "kekerasan", $req),
            )),
            array('Ciampel', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "kekerasan", $req),
            )),
            array('Majalaya', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "kekerasan", $req),
            )),
            array('Karawang Barat', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "kekerasan", $req),
            )),
            array('Karawang Timur', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "perjudian", $req),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "pencurian", $req),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "penggelapan", $req),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "narkoba", $req),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "kekerasan", $req),
            ))
        );

        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($data);
        return response()->json($data);
    }


    public function mapJakut(Request $req)
    {
        $bulan = $req->input("bulan");
        // $tahun = 2023;
        $tahun = $req->input("tahun");
        $type = $req->input("type");
        $criteria = ['Cilincing', 'Kelapa Gading', 'Koja', 'Pademangan', 'Penjaringan', 'Tanjung Priok',];
        $res = array();
        for ($i = 0; $i < count($criteria); $i++) {
            $data = array('label' => $criteria[$i], 'data' => DashboardModel::totalCrimePerKecamatan($criteria[$i], $req));
            $res[] = $data;
        }
        return response()->json($res);
    }


    public function mapKarawang(Request $req)
    {
        $bulan = $req->input("bulan");
        // $tahun = 2023;
        $tahun = $req->input("tahun");
        $criteria = ['Karawang Barat', 'Karawang Timur', 'Teluk Jambe Barat', 'Teluk Jambe Timur', 'Ciampel', 'Klari', 'Majalaya'];
        $res = array();
        for ($i = 0; $i < count($criteria); $i++) {
            $data = array('label' => $criteria[$i], 'data' => DashboardModel::totalCrimePerKecamatan($criteria[$i], $req));
            $res[] = $data;
        }
        return response()->json($res);
    }


    public function tester(Request $req)
    {
        $year = $req->input("year");
        $year = 2023;
        $kota = "Karawang";
        $area = "Ciampel";


        $res = DashboardModel::crimePerKecamatanSetahun($area, $kota, $year);


        return response()->json($res);
    }
}
