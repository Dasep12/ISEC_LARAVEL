<?php

namespace Modules\Crime\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crime\Entities\DashboardModel;


class CrimeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('crime::dashboard/index', [
            'uri'   => \Request::segment(2),
        ]);
    }

    private function crimeSetahun($year, $kota, $kat)
    {

        $grap_trans_area  = DashboardModel::crimeKategoriSetahun($year, $kota, $kat);
        $tar_arr = array();
        foreach ($grap_trans_area as $key => $tar) {
            $tar_arr[] = (int) $tar->total;
        }
        return $tar_arr;
    }

    private function crimeAreaSetahun($kota, $year)
    {
        $grap_trans_area  = DashboardModel::countCrimeAreaSetahun($kota, $year);
        $tar_arr = array();
        foreach ($grap_trans_area as $key => $tar) {
            $tar_arr[] = (int) $tar->total;
        }
        return $tar_arr;
    }

    private function crimeKecamatanSetahun($area, $kota, $year)
    {
        $grap_trans_area  =  DashboardModel::crimePerKecamatanSetahun($area, $kota, $year);
        $tar_arr = array();
        foreach ($grap_trans_area as $key => $tar) {
            $tar_arr[] = (int)$tar->total;
        }
        return $tar_arr;
    }

    public function graphicJakartaSetahun(Request $req)
    {
        $year = $req->input("year");
        $criteria = ['Pencurian', 'Kekerasan', 'Narkoba', 'Perjudian', 'Penggelapan'];
        $res = array();
        for ($i = 0; $i < count($criteria); $i++) {
            $data = array('label' => $criteria[$i], 'data' => self::crimeSetahun($year, "Jakarta Utara", $criteria[$i]));
            $res[] = $data;
        }
        return response()->json($res);
    }

    public function graphicKecamatanJakutSetahun(Request $req)
    {
        $year = $req->input("year");
        $criteria = ['Penjaringan', 'Tanjung Priok', 'Cilincing', 'Kelapa Gading', 'Pademangan', 'Koja'];
        $res = array();
        for ($i = 0; $i < count($criteria); $i++) {
            $data = array('label' => $criteria[$i], 'data' => self::crimeKecamatanSetahun($criteria[$i], "Jakarta Utara", $year));
            $res[] = $data;
        }
        $datas = array(
            array(self::crimeAreaSetahun("Jakarta Utara", $year)),
            $res
        );
        return response()->json($datas);
    }


    public function graphicKarawangSetahun(Request $req)
    {
        $year = $req->input("year");
        $criteria = ['Pencurian', 'Kekerasan', 'Narkoba', 'Perjudian', 'Penggelapan'];

        $res = array();
        for ($i = 0; $i < count($criteria); $i++) {
            $data = array('label' => $criteria[$i], 'data' => self::crimeSetahun($year, "Karawang", $criteria[$i]));
            $res[] = $data;
        }
        // echo json_encode($res);
        return response()->json($res);
    }

    public function graphicKecamatanKarawangSetahun(Request $req)
    {
        $year = $req->input("year");
        $criteria = ['Teluk Jambe Barat', 'Teluk Jambe Timur', 'Klari', 'Ciampel', 'Majalaya', 'Karawang Barat', 'Karawang Timur'];
        $res = array();
        for ($i = 0; $i < count($criteria); $i++) {
            $data = array('label' => $criteria[$i], 'data' => self::crimeKecamatanSetahun($criteria[$i], "Karawang", $year));
            $res[] = $data;
        }
        $datas = array(
            array(self::crimeAreaSetahun("Karawang", $year)),
            $res
        );
        // echo json_encode($datas);
        return response()->json($datas);
    }


    public function mapingKategoriJakut(Request $req)
    {
        $tahun = $req->input("tahun");
        $bulan = $req->input("bulan");
        $data = array(
            array('Pademangan', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "perjudian", $bulan, "Jakarta Utara", $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "pencurian", $bulan, "Jakarta Utara", $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "penggelapan", $bulan, "Jakarta Utara", $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "narkoba", $bulan, "Jakarta Utara", $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("pademangan", "kekerasan", $bulan, "Jakarta Utara", $tahun),
            )), array('Koja', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("koja", "perjudian", $bulan, "Jakarta Utara", $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("koja", "pencurian", $bulan, "Jakarta Utara", $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("koja", "penggelapan", $bulan, "Jakarta Utara", $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("koja", "narkoba", $bulan, "Jakarta Utara", $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("koja", "kekerasan", $bulan, "Jakarta Utara", $tahun),
            )),
            array('Tanjung Priok', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "perjudian", $bulan, "Jakarta Utara", $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "pencurian", $bulan, "Jakarta Utara", $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "penggelapan", $bulan, "Jakarta Utara", $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "narkoba", $bulan, "Jakarta Utara", $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("Tanjung Priok", "kekerasan", $bulan, "Jakarta Utara", $tahun),
            )),
            array('Penjaringan', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "perjudian", $bulan, "Jakarta Utara", $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "pencurian", $bulan, "Jakarta Utara", $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "penggelapan", $bulan, "Jakarta Utara", $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "narkoba", $bulan, "Jakarta Utara", $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("Penjaringan", "kekerasan", $bulan, "Jakarta Utara", $tahun),
            )),
            array('Cilincing', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "perjudian", $bulan, "Jakarta Utara", $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "pencurian", $bulan, "Jakarta Utara", $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "penggelapan", $bulan, "Jakarta Utara", $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "narkoba", $bulan, "Jakarta Utara", $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("Cilincing", "kekerasan", $bulan, "Jakarta Utara", $tahun),
            )),
            array('Kelapa Gading', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "perjudian", $bulan, "Jakarta Utara", $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "pencurian", $bulan, "Jakarta Utara", $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "penggelapan", $bulan, "Jakarta Utara", $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "narkoba", $bulan, "Jakarta Utara", $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("Kelapa Gading", "kekerasan", $bulan, "Jakarta Utara", $tahun),
            ))
        );

        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($data);
        return response()->json($data);
    }


    public function mapingKategoriKarawang(Request $req)
    {
        $tahun = $req->input("tahun");
        $bulan = $req->input("bulan");
        $data = array(
            array('Teluk Jambe Barat', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "perjudian", $bulan, 'karawang', $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "pencurian", $bulan, 'karawang', $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "penggelapan", $bulan, 'karawang', $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "narkoba", $bulan, 'karawang', $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe barat", "kekerasan", $bulan, 'karawang', $tahun),
            )),
            array('Teluk Jambe Timur', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "perjudian", $bulan, 'karawang', $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "pencurian", $bulan, 'karawang', $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "penggelapan", $bulan, 'karawang', $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "narkoba", $bulan, 'karawang', $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("teluk jambe timur", "kekerasan", $bulan, 'karawang', $tahun),
            )),
            array('Klari', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("klari", "perjudian", $bulan, 'karawang', $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("klari", "pencurian", $bulan, 'karawang', $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("klari", "penggelapan", $bulan, 'karawang', $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("klari", "narkoba", $bulan, 'karawang', $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("klari", "kekerasan", $bulan, 'karawang', $tahun),
            )),
            array('Ciampel', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "perjudian", $bulan, 'karawang', $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "pencurian", $bulan, 'karawang', $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "penggelapan", $bulan, 'karawang', $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "narkoba", $bulan, 'karawang', $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("ciampel", "kekerasan", $bulan, 'karawang', $tahun),
            )),
            array('Majalaya', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "perjudian", $bulan, 'karawang', $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "pencurian", $bulan, 'karawang', $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "penggelapan", $bulan, 'karawang', $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "narkoba", $bulan, 'karawang', $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("majalaya", "kekerasan", $bulan, 'karawang', $tahun),
            )),
            array('Karawang Barat', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "perjudian", $bulan, 'karawang', $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "pencurian", $bulan, 'karawang', $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "penggelapan", $bulan, 'karawang', $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "narkoba", $bulan, 'karawang', $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("karawang barat", "kekerasan", $bulan, 'karawang', $tahun),
            )),
            array('Karawang Timur', array(
                'perjudian'     => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "perjudian", $bulan, 'karawang', $tahun),
                'pencurian'     => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "pencurian", $bulan, 'karawang', $tahun),
                'penggelapan'   => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "penggelapan", $bulan, 'karawang', $tahun),
                'narkoba'       => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "narkoba", $bulan, 'karawang', $tahun),
                'kekerasan'     => DashboardModel::modelCrimeKategoriPerbulan("karawang timur", "kekerasan", $bulan, 'karawang', $tahun),
            ))
        );

        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($data);
        return response()->json($data);
    }

    public function mapJakut(Request $req)
    {
        $bulan = $req->input("bulan");
        $tahun = $req->input("tahun");
        $data = array(
            ['name' => 'Pademangan', 'total' => DashboardModel::totalCrimePerKecamatan("Pademangan", $bulan, $tahun)],
            ['name' => 'Cilincing', 'total' => DashboardModel::totalCrimePerKecamatan("Cilincing", $bulan, $tahun)],
            ['name' => 'Penjaringan', 'total' => DashboardModel::totalCrimePerKecamatan("Penjaringan", $bulan, $tahun)],
            ['name' => 'Tanjung Priok', 'total' => DashboardModel::totalCrimePerKecamatan("Tanjung Priok", $bulan, $tahun)],
            ['name' => 'Koja', 'total' => DashboardModel::totalCrimePerKecamatan("Koja", $bulan, $tahun)],
            ['name' => 'Kelapa Gading', 'total' => DashboardModel::totalCrimePerKecamatan("Kelapa Gading", $bulan, $tahun)],
        );
        // echo json_encode($data);
        return response()->json($data);
    }

    public function mapKarawang(Request $req)
    {
        $bulan = $req->post("bulan");
        $tahun = $req->post("tahun");
        $data = array(
            ['name' => 'Teluk Jambe Barat', 'total' => DashboardModel::totalCrimePerKecamatan("teluk jambe barat", $bulan, $tahun)],
            ['name' => 'Teluk Jambe Timur', 'total' => DashboardModel::totalCrimePerKecamatan("Teluk Jambe Timur", $bulan, $tahun)],
            ['name' => 'Klari', 'total' => DashboardModel::totalCrimePerKecamatan("Klari", $bulan, $tahun)],
            ['name' => 'Ciampel', 'total' => DashboardModel::totalCrimePerKecamatan("Ciampel", $bulan, $tahun)],
            ['name' => 'Majalaya', 'total' => DashboardModel::totalCrimePerKecamatan("majalaya", $bulan, $tahun)],
            ['name' => 'Karawang Barat', 'total' => DashboardModel::totalCrimePerKecamatan("karawang barat", $bulan, $tahun)],
            ['name' => 'Karawang Timur', 'total' => DashboardModel::totalCrimePerKecamatan("karawang timur", $bulan, $tahun)],
        );
        // header('Content-Type: application/json; charset=utf-8');
        // echo json_encode($data);
        return response()->json($data);
    }
}
