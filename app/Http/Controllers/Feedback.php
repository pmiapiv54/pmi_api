<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Feedback extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        DB::enableQueryLog();
    }

    public function feedback(Request $request){

        $post = $request->input();
        $query = 'false';

        $username = $post['feedback_kode_user'];

        $cek = DB::connection()
                ->table('pendonor')
                ->where([
                    ['Kode', '=', $username]
                ])->get();
        
        if(count($cek) > 0 ){

            $query = DB::connection('mysql2')
                    ->table("feedback")
                    ->insert($post);

            if($query){

                $msg = 'Succesfully';
                $res_status = True;
                $status_msg = 'Berhasil insert ke tabel Feedback';

            }else{

                $msg = 'Failed';
                $res_status = False;
                $status_msg = 'Galat insert ke tabel Feedback';

            }

        }else{

            $msg = 'Failed';
            $res_status = False;
            $status_msg = 'username '.$username.' INVALID';

        }
        

        $param = $post;
        $rows = 0;
        $result = $query;

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);

    }

}
