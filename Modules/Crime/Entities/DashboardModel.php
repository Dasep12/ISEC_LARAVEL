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

    public static function crimeKategoriSetahun($year, $kota, $kat)
    {

        $kec = "";
        if ($kota == "Jakarta Utara") {
            $kec .= "AND CONVERT(VARCHAR,kec) in ('Penjaringan', 'Tanjung Priok', 'Cilincing', 'Kelapa Gading', 'Pademangan', 'Koja') ";
        } else {
            $kec .= "AND CONVERT(VARCHAR,kec) in ('Teluk Jambe Barat', 'Teluk Jambe Timur', 'Klari', 'Ciampel', 'Majalaya', 'Karawang Barat', 'Karawang Timur') ";
        }
        $q = " WITH months(MonthNum) AS
        (
            SELECT 1
            UNION ALL
            SELECT MonthNum+1 
                FROM months
            WHERE MonthNum < 12
        )
        SELECT m.MonthNum month_num, (select count(c.id) from  dbo.admisec_Tcrime c where c.kategori = '" . $kat . "' and CONVERT(VARCHAR,c.kota) ='" . $kota . "' 
        " . $kec . "
        and month(c.tanggal) = m.MonthNum and YEAR(c.tanggal)='" . $year . "' ) as total
        FROM months m
        LEFT OUTER JOIN dbo.admisec_Tcrime AS t ON MONTH(t.tanggal)=m.MonthNum AND 
        YEAR(t.tanggal)='" . $year . "'
        GROUP BY m.MonthNum";
        return DB::connection('crime')->select($q);
    }

    public static function countCrimeAreaSetahun($kota, $year)
    {

        $kat = "";

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

    public static function crimePerKecamatanSetahun($area, $kota, $year)
    {

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
        and CONVERT(VARCHAR,c.kota) ='" . $kota . "' 
        and month(c.tanggal) = m.MonthNum and   YEAR(c.tanggal)='" . $year . "'  ) as total 
            FROM months m
        LEFT OUTER JOIN dbo.admisec_Tcrime AS t ON MONTH(t.tanggal)=m.MonthNum AND 
        YEAR(t.tanggal)='" . $year . "'
        and CONVERT(VARCHAR,kategori) in ('perjudian' ,'narkoba' , 'penggelapan' , 'pencurian' , 'kekerasan' )
        GROUP BY m.MonthNum";
        return DB::connection('crime')->select($q);
    }


    public static function modelCrimeKategoriPerbulan($kec, $kat, $bulan, $kota, $year)
    {
        $month = "";
        if ($bulan != "" || $bulan != null) {
            $month .= "AND MONTH(tanggal) = '$bulan' ";
        }
        $query = DB::connection('crime')->select("SELECT COUNT(kategori) AS total FROM admisec_Tcrime WHERE 
        CONVERT(VARCHAR,kota) = '" . $kota . "' 
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

    public static function totalCrimePerKecamatan($kec, $bulan, $tahun)
    {
        $month = "";
        if (!empty($bulan)) {
            $month .= "AND MONTH(tanggal) = '$bulan' ";
        }
        $query =  DB::connection('crime')->select("SELECT COUNT(kec) as total FROM admisec_Tcrime 
        WHERE kec='$kec'
                $month
                AND YEAR(tanggal) = '$tahun'
                AND CONVERT(VARCHAR,kategori) in ('perjudian','narkoba','penggelapan','pencurian','kekerasan') ");
        return $query[0]->total;
    }
}
