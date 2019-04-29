<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pendonor extends Controller
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

    public function get_data_pendonor($Kode){

        $query = DB::connection('mysql')
                    ->table('pendonor as p')
                    ->where([
                                ['um.user_username','=',$Kode],
                            ])
                    ->join('pmi_cendana.users_mobile as um','um.user_username','=','p.Kode')
                    ->first();
        $param = ['Kode' => $Kode];
        $rows = '1';
        $result = $query;
        $msg = 'Succesfully';
        $res_status = True;
        $status_msg = 'Get all data pendonor lama '.$Kode;

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);

    }

    public function get_riwayat_donor($kodePendonor){

        $query = DB::connection()
                    ->table('htransaksi')
                    ->where([
                        ['KodePendonor', '=',$kodePendonor]
                    ])
                    ->get();

        $param = ['Kode' => $kodePendonor];
        $rows = count($query);
        $result = $query;
        $msg = 'Succesfully';
        $res_status = True;
        $status_msg = 'Get riwayat pendonor '.$kodePendonor;

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);

    }

    public function update_profile(Request $request, $kode){

        $post = $request->input();

        $cek_user = DB::connection('mysql')
                    ->table('pendonor as p')
                    ->where('um.user_username', $kode)
                    ->join('pmi_cendana.users_mobile as um','um.user_username','=','p.Kode')
                    ->get();
        


        if(count($cek_user) > 0){

            $query = DB::connection()
                        ->table('pendonor')
                        ->where([
                            ['Kode', '=', $kode]
                        ])
                        ->update($post);
            if($query){

               $query = DB::connection('mysql')
                    ->table('pendonor as p')
                    ->where([
                                ['um.user_username','=',$kode],
                            ])
                    ->join('pmi_cendana.users_mobile as um','um.user_username','=','p.Kode')
                    ->get()[0];

                $msg = 'Succesfully';
                $res_status = True;
                $status_msg = $msg.' Update Profile '. $kode;

            }else{

                $msg = 'Failed';
                $res_status = False;
                $status_msg = 'Gagal Update Profile';

            }

        }else{

            $msg = 'Failed';
            $res_status = False;
            $status_msg = 'USERNAME INVALID';

        }

        $param = $post;
        $rows = '0';
        $result = $query;
        

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);


    }


}