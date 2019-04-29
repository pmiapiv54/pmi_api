<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GolonganDarah extends Controller
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

    public function get_component_goldar(){

        $last_update = DB::connection('mysql2')
                        ->table('data_stock')
                        ->select(DB::raw('DATE_FORMAT(max(updated_at), "%Y-%m-%d") as last_update'))
                        ->first();
        $query['tanggal_terakhir'] = $last_update->last_update;

        $query['data'] = DB::connection('mysql2')
                    ->table('data_stock')
                    ->get();
        
        // die(pre($query));
        $param = '';
        $rows = count($query);
        $result = $query;
        $msg = 'Succesfully';
        $res_status = True;
        $status_msg = 'Get data all Golongan Darah';

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);

    }


}