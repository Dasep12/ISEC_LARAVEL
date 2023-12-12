<?php

namespace Modules\Crime\Entities;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use AuthHelper;
use GuzzleHttp\Psr7\Request;

class DashboardModel extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Srs\Database\factories\DashboardModelFactory::new();
    }

    public static function crimeKategoriSetahun($req, $kat)
    {

        // $year = 2023;
        // $type = 'o';
        $kec = "";
        $year = $req->input("year");
        $type = $req->input("tipe");
        $kota = $req->input("kota");
        if ($kota == "Jakarta Utara") {
            $kec .= "AND CONVERT(VARCHAR,kec) in ('Penjaringan', 'Tanjung Priok', 'Cilincing', 'Kelapa Gading', 'Pademangan', 'Koja') ";
        } else {
            $kec .= "AND CONVERT(VARCHAR,kec) in ('Teluk Jambe Barat', 'Teluk Jambe Timur', 'Klari', 'Ciampel', 'Majalaya', 'Karawang Barat', 'Karawang Timur') ";
        }
        $q = "WITH months(MonthNum) AS
        (
            SELECT 1
            UNION ALL
            SELECT MonthNum+1 
                FROM months
            WHERE MonthNum < 12
        )
        SELECT m.MonthNum month_num, (select count(c.id) from  dbo.admisec_Tcrime c where CONVERT(VARCHAR,c.types) = '$type' AND  c.kategori = '" . $kat . "' and CONVERT(VARCHAR,c.kota) ='" . $kota . "' 
        " . $kec . "
        and month(c.tanggal) = m.MonthNum and YEAR(c.tanggal)='" . $year . "'  ) as total
        FROM months m
        LEFT OUTER JOIN dbo.admisec_Tcrime AS t ON MONTH(t.tanggal)=m.MonthNum AND 
        YEAR(t.tanggal)='$year' 
      
        GROUP BY m.MonthNum";
        return DB::connection('crime')->select($q);
        // WHERE 
        // CONVERT(VARCHAR,t.types) = '$type'
    }

    public static function countCrimeAreaSetahun($kota, $year, $type)
    {

        $kat = "";

        // $kota = $req->input("");

        if ($kota == "Jakarta Utara") {
            $kat .= "CONVERT(VARCHAR,kategori) in ( 'perjudian' , 'narkoba' , 'penggelapan','pencurian' ,'kekerasan') AND kec in ('penjaringan' , 'koja' , 'tanjung priok' , 'pademangan', 'cilincing' , 'kelapa gading')";
        } else {
            $kat .= "CONVERT(VARCHAR,kategori) in ( 'perjudian' , 'narkoba' , 'penggelapan','pencurian' ,'kekerasan') AND kec in ('Teluk Jambe Barat', 'Teluk Jambe Timur' , 'Klari' , 'Ciampel' , 'Majalaya' , 'Karawang Barat' , 'Karawang Timur')";
        }
        $res = " WITH months(MonthNum) AS
        (
            SELECT 1
            UNION ALL
            SELECT MonthNum+1 
                FROM months
            WHERE MonthNum < 12
        )
        SELECT m.MonthNum month_num, count(t.kec) total
            FROM months m
        LEFT OUTER JOIN dbo.admisec_Tcrime AS t ON CAST(MONTH(t.tanggal) as int )=m.MonthNum AND 
        YEAR(t.tanggal)='" . $year . "'
        where CONVERt(VARCHAR,t.kota) = '" . $kota . "' 
        and $kat
        GROUP BY m.MonthNum";
        return DB::connection('crime')->select($res);
    }

    public static function crimePerKecamatanSetahun($area, $req)
    {

        $year = $req->input("year");
        $type = $req->input("type");
        $kota = $req->input("kota");
        $q = " WITH months(MonthNum) AS
        (
            SELECT 1
            UNION ALL
            SELECT MonthNum+1 
                FROM months
            WHERE MonthNum < 12
        )
        SELECT m.MonthNum month_num, (select count(c.id) from  dbo.admisec_Tcrime c 
        where 
        CONVERT(VARCHAR,c.kec) = '" . $area . "' 
        and CONVERT(VARCHAR,c.types) = '$type' 
         and kategori in ('perjudian' ,'narkoba' , 'penggelapan' , 'pencurian' , 'kekerasan' )
        and CONVERT(VARCHAR,c.kota) ='" . $kota . "' 
        and month(c.tanggal) = m.MonthNum and   YEAR(c.tanggal)='" . $year . "'  ) as total 
            FROM months m
        LEFT OUTER JOIN dbo.admisec_Tcrime AS t ON MONTH(t.tanggal)=m.MonthNum AND 
        YEAR(t.tanggal)='" . $year . "'
        
        GROUP BY m.MonthNum";
        return DB::connection('crime')->select($q);
    }


    public static function modelCrimeKategoriPerbulan($kec, $kat, $req)
    {
        // $year = 2023;
        $year = $req->tahun;
        // $bulan = "";
        $bulan = $req->bulan;
        $kota = $req->kota;
        $type = $req->type;
        $month = "";
        if ($bulan != "" || $bulan != null) {
            $month .= "AND MONTH(tanggal) = '$bulan' ";
        }
        $query = DB::connection('crime')->select("SELECT COUNT(kategori) AS total FROM admisec_Tcrime WHERE 
        CONVERT(VARCHAR,kota) = '" . $kota . "' 
        AND types='$type'
        AND CONVERT(VARCHAR,kec)='" . $kec . "' 
        AND CONVERT(VARCHAR,kategori) = '" . $kat . "'
        $month
        AND YEAR(tanggal) = '$year' ");
        if (count($query) > 0) {
            // $res = $query->row();
            return $query[0]->total;
        } else {
            return 0;
        }
    }

    public static function totalCrimePerKecamatan($kec, $req)
    {
        $bulan = $req->input("bulan");
        // $tahun = 2023;
        $tahun = $req->input("tahun");
        $type = $req->input("type");
        $month = "";
        if (!empty($bulan)) {
            $month .= "AND MONTH(tanggal) = '$bulan' ";
        }
        $query =  DB::connection('crime')->select("SELECT COUNT(kec) as total FROM admisec_Tcrime  atc
        WHERE kec='$kec'
                $month
                AND YEAR(tanggal) = '$tahun'
                AND atc.types = '$type'
                AND CONVERT(VARCHAR,kategori) in ('perjudian','narkoba','penggelapan','pencurian','kekerasan') ");
        return $query[0]->total;
    }
}
