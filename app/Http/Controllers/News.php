<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mod_News;

class News extends Controller
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

    function get_news(){

        $query = DB::connection('mysql2')
                    ->table('data_news as dn')
                    ->select(
                            'news_title',
                            // DB::raw('concat("",ifnull(news_image,"")) as news_image'),
                            DB::raw('concat("https://i.ibb.co/YbVP8MM/background.png") as news_image'),
                            'dn.created_at',
                            'news_content',
                            'news_type'
                            )
                    ->join('master_news_category as mnc', 'dn.news_category_id', '=', 'mnc.category_id')
                    ->join('users as uc','uc.user_id', '=', 'dn.news_author_id')
                    // ->join(['master_news_category as mnc', 'dn.news_category_id', '=', 'mnc.category_id'],['users_cms as uc','uc.user_id', '=', 'dn.news_author_id'])
                    ->get();
        // die(pre(dd(($query))));

        $param = '';
        $rows = count($query);
        $result = $query;
        $msg = 'Succesfully';
        $res_status = True;
        $status_msg = 'Get all data news';

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);

    }

}