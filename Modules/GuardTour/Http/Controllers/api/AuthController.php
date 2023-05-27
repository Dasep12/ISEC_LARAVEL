<?php

namespace Modules\GuardTour\Http\Controllers\api;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GuardTour\Entities\api\AuthModels;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function login(Request $req)
    {
        // Get the post data
        $npk = $req->npk;
        $password = $req->password;

        if (!empty($npk) && !empty($password)) {

            // Check if any user exists with the given credentials
            $con['npk'] =  $npk;
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'npk' => $npk,
                'password' => md5($password),
                'status' => 1
            );

            $res = AuthModels::getRows($con);
            if ($res) {

                $key  = $this->_regenerate_key($res->npk);
                return response()->json([
                    'status'        => TRUE,
                    'message'       => 'User login successful.',
                    'data'          => $res,
                    'key'           => $key
                ]);
            }
        }
    }


    private function _generate_key()
    {
        do {
            // Generate a random salt   
            $salt =  $this->attributes['uuid'] = Uuid::uuid4()->toString();

            $new_key = $salt;
        } while ($this->_key_exists($new_key));

        return $new_key;
    }



    private function _regenerate_key($user_id)
    {
        $this->_delete_key_user($user_id);
        $key =  $this->_generate_key();
        $this->_insert_key($key, ['level' => 1, 'user_id' => $user_id]);
        return $key;
    }

    private function _delete_key_user($user_id)
    {

        DB::table('admisecsgp_apikeys')
            ->where('user_id', $user_id)
            ->delete();
    }

    private function _insert_key($key, $data)
    {
        $data['key'] = $key;
        $data['date_created'] = date("Y-m-d H:i:s");

        return DB::table('admisecsgp_apikeys')
            ->insert($data);
    }

    private function _key_exists($key)
    {
        // return $this->rest->db
        //     ->where(config_item('rest_key_column'), $key)
        //     ->count_all_results(config_item('rest_keys_table')) > 0;
        return DB::table('admisecsgp_apikeys')
            ->where('key', $key)
            ->select('user_id')
            ->count() > 0;
    }
}
