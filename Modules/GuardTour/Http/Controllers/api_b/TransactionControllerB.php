<?php

namespace Modules\GuardTour\Http\Controllers\api_b;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\GuardTour\Entities\api_b\TransactionModel;

class TransactionControllerB extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function checkpoint(Request $request)
    {
        $result  = TransactionModel::checkpointInsert($request);

        // dd($result);

        if($result == '00')
        {
            $response = array(
                'status' => true,
                'code' => '000',
                'msg' => 'success'
            );
        }
        elseif($result == '01') 
        {
            $response = array(
                'status' => false,
                'code' => '211',
                'msg' => 'already exists'
            );
        }
        else
        {
            $response = array(
                'status' => false,
                'code' => '212',
                'msg' => 'Failed'
            );
        }

        return response()->json($response);
    }

    public function normal(Request $request)
    {
        $result  = TransactionModel::insertNormal($request);

        if($result == '00')
        {
            $response = array(
                'status' => true,
                'code' => '000',
                'msg' => 'success'
            );
        }
        elseif($result == '02') 
        {
            $response = array(
                'status' => false,
                'code' => '211',
                'msg' => 'already exists'
            );
        }
        else
        {
            $response = array(
                'status' => false,
                'code' => '212',
                'msg' => 'Failed'
            );
        }

        return response()->json($response);
    }

    public function abnormal(Request $request)
    {
        $result  = TransactionModel::insertAbnormal($request);

        if($result == '00')
        {
            $response = array(
                'status' => true,
                'code' => '000',
                'msg' => 'success'
            );
        }
        elseif($result == '02') 
        {
            $response = array(
                'status' => false,
                'code' => '211',
                'msg' => 'already exists'
            );
        }
        else
        {
            $response = array(
                'status' => false,
                'code' => '212',
                'msg' => 'Failed'
            );
        }
        
        return response()->json($response);
    }

    public function finishCheckpoint(Request $request)
    {
        $result  = TransactionModel::insertFinishCheckpoint($request);

        if($result == '00')
        {
            $response = array(
                'status' => true,
                'code' => '000',
                'msg' => 'success'
            );
        }
        elseif($result == '01') 
        {
            $response = array(
                'status' => false,
                'code' => '211',
                'msg' => 'already exists'
            );
        }
        else
        {
            $response = array(
                'status' => false,
                'code' => '212',
                'msg' => 'Failed'
            );
        }
        
        return response()->json($response);
    }

    public function sendAbnormal(Request $request)
    {
        $plant_id = $request->plant_id;
        $result  = TransactionModel::sendEmailAbnormal($request);
        $resEmail  = TransactionModel::userGa($plant_id);

        if($result !== '01' && $resEmail !== '01')
        {
            $config = json_decode($result[0]->nilai_setting, true);
            $emails = array(
                array(
                'email' => 'ridho.sistem.adm@gmail.com',
                ),
                array( 
                'email' => 'rife.develop@gmail.com',
                )
            );
            $to = array();
            $to_cc = array();
            foreach ($resEmail as $key => $ie) {
                if($ie->type == 1)
                {
                    $to[] = $ie->email;
                }

                if($ie->type == 0)
                {
                    $to_cc[] = $ie->email;
                }
            }
            $to = implode(", ", $to);
            $to_cc = implode(", ", $to_cc);

            $resEmail = self::sendEmail($config, $to, $to_cc, $result);

            $response = array(
                'status' => true,
                'code' => '000',
                'msg' => 'success'
            );
        }
        elseif($result == '01') 
        {
            $response = array(
                'status' => true,
                'code' => '211',
                'msg' => 'tidak ada temuan'
            );
        }
        else
        {
            $response = array(
                'status' => false,
                'code' => '212',
                'msg' => 'Failed'
            );
        }

        return response()->json($response);
    }

    public static function sendEmail($config, $to, $data)
    {
        Mail::to("ridho.sistem.adm@gmail.com")->send(new MalasngodingEmail());

            dd($config);
        $this->load->library('email', $config);

        $this->email->from('dataanalytic.adm@gmail.com', 'GUARD TOUR SYSTEM');
        $this->email->to($to);
        $this->email->subject('Laporan Temuan');
        $message = $this->load->view('api_adm_b/template/email_lapor_pic_2_v', $data, true);
        $this->email->message($message);

        if ($this->email->send()) 
        {
            $result = array(
                'code' => '00',
                'msg' => 'Email terkirim',
            );
        } 
        else 
        {
            $result = array(
                'code' => '01',
                'msg' => show_error($this->email->print_debugger()),
            );
        }

        // var_dump($result); die();
        // echo json_encode($result);
        
        return $result;
    }
}
