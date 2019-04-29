<?php

use Illuminate\Support\Facades\DB;

function pre($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function respon($param, $msg, $status, $status_msg, $rows, $result){

    $response['response'] = array(
        'status' => $status,
        'message' => $msg
    );
    $response['status_msg'] = $status_msg;
    $response['param'] = $param;
    $response['rows'] = $rows;
    $response['result'] = $result;

    return $response;

}

function get_password($username, $password){

    $concat = $username.$password;
    $password = hash_password($concat);

    return $password;

}

function hash_password($concat){
    
    $key = $_ENV['APP_KEY'];
    $password = md5($key.$concat);
    
    return $password;

}

function md56($param,$tipe = null,$jml = null){
    if(empty($tipe)){
        return substr(md5($param),0, ( empty($jml) ? 6 : $jml  ) );

        substr(md5($param),0, 6 );
    }else{
        return 'SUBSTRING(md5('.$param.'),true,6)';
    }
}

function get_tgl_sekarang(){
     $query = DB::connection()
                ->select('select now() as today');
    
    return $query[0]->today;
}

function get_tgl_plus_week(){

    $query = DB::connection()
                ->select('select now() + interval 1 week as today');
    return $query[0]->today;

}


?>