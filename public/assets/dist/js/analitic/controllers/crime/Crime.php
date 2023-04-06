<?php
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Crime extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Type $var = null)
    {
        $data['link']   = $this->uri->segment(1);
        $this->template->load("template/analityc/template", "crime/dashboard", $data);
    }
}
