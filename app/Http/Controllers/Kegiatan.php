<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Kegiatan extends Controller
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

    public function get_kegiatan(){

        $query = DB::connection('mysql2')
                    ->table('VIEW_DATA_KEGIATAN')
                    ->get();

                    // DB::connection('mysql')
                    // ->table('kegiatan as k')
                    // ->select(
                    //     'k.NoTrans as kegiatan_id',
                    //     'di.nama as title',
                    //     DB::raw('concat("") as gambar'),
                    //     'di.alamat as location',
                    //     'lat',
                    //     'lng as `long`',
                    //     DB::raw('
                    //     case
                    //         when k.TglPelaksanaan != NULL then DATE_FORMAT(k.TglPelaksanaan, "%Y-%m-%d")
                    //         else DATE_FORMAT(k.TglPenjadwalan, "%Y-%m-%d")
                    //     end as date_start
                    //     ',
                    //     'ifnull(jammulai, "00:00:00") as time_start',
                    //     'DATE_FORMAT(k.TglPenjadwalan, "%Y-%m-%d") as date_end',
                    //     'ifnull(jamselesai, "00:00:00") as time_end')

                    // )
                    // // ->whereBetween ('k.TglPenjadwalan',[get_tgl_sekarang(), get_tgl_plus_week()])
                    // ->join('detailinstansi as di','k.kodeinstansi','=','di.KodeDetail')
                    // ->get();

        $param = '';
        $rows = count($query);
        $result = $query;
        $msg = 'Succesfully';
        $res_status = True;
        $status_msg = 'Get data kegiatan  interval 1 minggu dari hari ini';

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);

    }

}