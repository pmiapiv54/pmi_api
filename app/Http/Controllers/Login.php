<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mod_pendonor;
use DateTime;

use App\Mail\Lupapassword as WinningsMail;
use App\Mail\Register;
use Illuminate\Support\Facades\Mail;

class Login extends Controller
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

    public function login(Request $request){

        $post = $request->input();
        $username = $post['user_username'];
        $password = $post['user_password'];

        $cek_db2 = DB::connection('mysql2')
                    ->table('users_mobile')
                    ->where([
                        ['user_username', '=', $username]
                    ])
                    ->get();

        if(count($cek_db2) > 0){

            $join = DB::connection('mysql')
                    ->table('pendonor as p')
                    ->where([
                                ['um.user_username','=',$username],
                                ['um.user_password', '=', get_password($username, $password)],
                            ])
                    ->join('pmi_cendana.users_mobile as um','um.user_username','=','p.Kode')
                    ->get();
                    // die(dd(DB::getQueryLog()));
            if(count($join) > 0){

                $msg = 'Succesfully';
                $res_status = true;
                $status_msg = 'Login tersedia di DB 1 dan DB 2';
                $query = $join[0];

            }else{

                $msg = 'Failed';
                $res_status = false;
                $status_msg = 'Password Salah';
                $query = '';

            }

        }else{

            $cek_db1 = DB::connection('mysql')
                        ->table('pendonor as p')
                        ->where([
                                    ['p.Kode','=', $username],
                                    ['p.TglLhr', '=', $password],
                                ])
                        ->get();

            if(count($cek_db1) > 0 ){

                $data = [
                            'user_username' => $username,
                            'user_password' => get_password($username, $password),
                            'user_kode_pendonor' => $username,
                            'user_status' => 'Y',
                            'created_at' => get_tgl_sekarang(),
                        ];
            
                $insert = DB::connection('mysql2')
                                ->table('users_mobile')
                                ->insert($data);

                if($insert){

                    $status_msg = 'Success insert DB 2';

                    $query = DB::connection('mysql')
                                ->table('pendonor as p')
                                ->where([
                                            ['um.user_username','=',$username],
                                            ['um.user_password', '=', get_password($username, $password)],
                                        ])
                                ->join('pmi_cendana.users_mobile as um','um.user_username','=','p.Kode')
                                ->get();

                    if(count($query) > 0){

                        $msg = 'Succesfully';
                        $res_status = true;
                        $status_msg = 'Login sukses dan '.$status_msg;

                    }else{
                        
                        $msg = 'Failed';
                        $res_status = false;
                        $status_msg = 'Login gagal dan '.$status_msg;

                    }
                    

                }else{

                    $msg = 'Failed';
                    $res_status = false;
                    $status_msg = 'Galat insert into DB 2';
                    $query = '';

                }

            }else{

                $msg = 'Failed';
                $res_status = false;
                $status_msg = 'DATA NOT FOUND';
                $query = '';
            }

        }

        $param = $post;
        $rows = '';
        $result = $query;

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);

    }

    public function register(Request $request){

        $post = $request->input();       
    
        $namaKode = substr(implode('',explode(' ',$post['Nama'])),0,3);
        $kode = '3603M'.strtoupper($namaKode);
        $get_email = DB::connection()
                        ->table('pendonor')
                        ->select('Email')
                        ->where('Email','=', $post['Email'])
                        ->get();

        if(count($get_email) == 0){

            $get_kode_pendonor = DB::connection()
                                ->table('pendonor')
                                ->select('Kode')
                                ->where([
                                    ['Kode','like', "%$kode%"],
                                ])
                                ->orderBy('Kode','desc')
                                ->get();
            // die(dd(DB::getQueryLog()));
            if(count($get_kode_pendonor) > 0){

                
                $get_angka_akhir = substr($get_kode_pendonor[0]->Kode, -6);
                $get_angka_akhir = $get_angka_akhir + 1;

                $arr_angka = [
                                '10' => '00000',
                                '100' => '0000',
                                '1000' => '000',
                                '10000' => '00',
                                '100000' => '0',
                            ];
                foreach($arr_angka as $key_angka => $value_angka){
                    
                    if($get_angka_akhir < $key_angka){
                        
                        $kode = $kode.$value_angka.$get_angka_akhir;
                        break;

                    }

                }
                
            }else{

                $kode = $kode.'000000';

            }
            
            #$date = date('Y-m-d H:i:s',strtotime($post['TglLhr']));
            
            $bday = new DateTime($post['TglLhr']); // Your date of birth
            $today = new Datetime(date('Y-m-d'));
            $umur = $today->diff($bday);
            $umur = $umur->y;
            
            $post['Kode'] = $kode;
            $ins_data1 = $post;
            $ins_data1['Kode'] = $kode;
            $ins_data1['Alamat'] = $post['Alamat'];
            $ins_data1['insert_on'] = get_tgl_sekarang();
            $ins_data1['mu'] = '2';
            $ins_data1['umur'] = $umur;
            $ins_data1['instansi'] = '';
            $ins_data1['tanggal_cetak'] = '0001-01-01';
            $ins_data1['tglkembali_apheresis'] = '0001-01-01';
            $ins_data1['tanggal_entry'] =  get_tgl_sekarang();
            $ins_data1['abs'] = '';      
            $ins_data1['Kode_lama'] = 'NULL';

            $ins_data1['GolDarah'] = 'X';
            $ins_data1['NoKTP'] = '36031';
            $ins_data1['Telp'] = '-';
            $ins_data1['Status'] =  '';
            $ins_data1['Call'] = '0';
            $ins_data1['title'] = 'NULL';
            $ins_data1['jns'] = 'N';
            $ins_data1['sukubangsa'] =  'NULL';
            $ins_data1['ibukandung'] = '';
            $ins_data1['pencatat'] = 'Mobile';
            $ins_data1['up'] = '000';
            $ins_data1['Rhesus'] = '+';
            $ins_data1['ketdarah'] = 'NULL';
            
            $ins_data1['waktu_update'] = get_tgl_sekarang();
            $ins_data1['instansi'] = 'Mobile';

            $ins_data2 = [
                            'user_username' => $kode,
                            'user_password' => get_password($kode, $post['user_password']),
                            'user_kode_pendonor' => $kode,
                            'user_status' => 'Y',
                            'created_at' => get_tgl_sekarang(),
                        ] ;
            
        $query1 = new Mod_pendonor;
        $query1->fill($ins_data1);
        $query1->save();
            // die(dd($query1));
            $query2 = DB::connection('mysql2')
                        ->table('users_mobile')
                        ->insert($ins_data2);
            
            if($query1 == true && $query2 == true){

                $query = DB::connection('mysql')
                ->table('pendonor as p')
                ->where([
                            ['um.user_username','=',$kode],
                            ['um.user_password', '=', get_password($kode, $post['user_password'])],
                        ])
                ->join('pmi_cendana.users_mobile as um','um.user_username','=','p.Kode')
                ->first();

                $this->send_mail_register($query->Email, [
                    'nama' => $query->Nama,
                    'kode' => $query->Kode,
                    'password' => $query->user_password
                ]);

                $msg = 'Succesfully';
                $res_status = True;
                $status_msg = 'Insert Into DB 1 (pendonor) dan 2 Register (users)';


            }else{

                $query = false;
                $msg = 'Failed';
                $res_status = false;
                $status_msg = 'Galat Insert Into DB 1 (pendonor) dan 2 Register (users)';

            }

        }else{

            $query = false;
            $msg = 'Failed';
            $res_status = false;
            $status_msg = 'EMAIL '. $post['Email'].'  is Already Taken';

        }

        $param = $post;
        $rows = '0';
        $result = $query;

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);


    }

    public function send_mail_lupa_password($to_email, $content, $kode, $nama){

        // $to_email = 'aabdul.jabbar1301@gmail.com';
        // $winnings = 'ollo';

        Mail::send(
            new WinningsMail(
                $to_email,                
                $content,
                $kode,
                $nama
            )
        );

    }

    public function send_mail_register($to_email, $data){

        Mail::send(
            new Register(
                $to_email,                
                $data
            )
        );

    }

    public function lupa_password(Request $request){
    
        $post = $request->input();
        $username = $post['username'];
        $email = $post['email'];

        $cek_user = DB::connection()
                        ->table('pendonor')
                        ->where([
                            ['Kode', '=', $username],
                            ['Email', '=', $email]
                        ])
                        ->get();
        
        if(count($cek_user) > 0){

            $get_code = md56(hash_password($username.$email.get_tgl_sekarang()));
            $data = [
                'user_kode_forget_password' => $get_code,
            ];

            $ins_code = DB::connection('mysql2')
                            ->table('users_mobile')
                            ->where([
                                ['user_username', '=', $username],
                            ])
                            ->update($data);
            
            $query = [
                'kode_lupa_pas' => $get_code,
            ];
            $res_status = true;
            $status_msg = 'Get code forget password, and check ';
            $msg = 'Succesfully';

            //tambahi gcm sendder
            $this->send_mail_lupa_password($email, $get_code, $username, $cek_user[0]->Nama);

        }else{

            $query = false;
            $res_status = false;
            $status_msg = 'username / email tidak sesuai';
            $msg = 'Failed';

        }

        $param = [
            'username' => $username,
            'email' => $email
        ];
        $rows = '0';
        $result = $query;

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);
        
    }

    public function konfirmasi_lupassword(Request $request){

        $post = $request->input();
        $username = $post['user_username'];
        $password = $post['user_password'];
        $kode = $post['user_kode_forget_password'];

        $cek_konfirmasi = DB::connection('mysql2')
                            ->table('users_mobile')
                            ->where([
                                ['user_kode_forget_password', '=', $kode]
                            ])
                            ->get();
        
        if(count($cek_konfirmasi) > 0){
            $data = [
                'user_password' => get_password($username, $password)
            ];
            $update = DB::connection('mysql2')
                        ->table('users_mobile')
                        ->where([
                            ['user_username', '=', $username],
                            ['user_kode_forget_password', '=', $kode]
                        ])
                        ->update($data);
            
            if($update){

                //tambah sender email
                $query = true;
                $res_status = true;
                $msg = 'Succesfully';
                $status_msg = 'Sukses verifikasi kode + ganti password';

            }else{

                $query = false;
                $res_status = false;
                $msg = 'Failed';
                $status_msg = 'Sukses verifikasi kode + galat ganti password';

            }


        }else{

            $query = false;
            $res_status = false;
            $msg = 'Failed';
            $status_msg = 'Verifikasi Kode INVALID';

        }
        
        $param = [
            'username' => $username,
            'password' => $password,
            'kode' => $kode,
        ];
        $rows = '0';
        $result = $query;

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);

    }

    public function ganti_password(Request $request){

        $post = $request->input();
        $username = $post['user_username'];
        $password_lama = $post['user_password'];
        $password_baru = $post['password_baru'];

        $cek_user = DB::connection('mysql2')
                        ->table('users_mobile')
                        ->where([
                            ['user_username', '=', $username],
                            ['user_password', '=', get_password($username, $password_lama)]
                        ])
                        ->get();

        if(count($cek_user)){

            $data['user_password'] = get_password($username, $password_baru);

            $query = DB::connection('mysql2')
                        ->table('users_mobile')
                        ->where([
                            ['user_username', '=', $username]
                        ])
                        ->update($data);
            if($query){

                $res_status = true;
                $msg = 'Succesfully';
                $status_msg = 'Sukses ganti password';

            }else{

                $res_status = false;
                $msg = 'Failed';
                $status_msg = 'Galat ganti password';

            }
            

        }else{

            $query = false;
            $res_status = false;
            $msg = 'Failed';
            $status_msg = 'Password lama tidak sesuai';

        }

        $param = $post;
        $rows = '0';
        $result = $query;

        $response = respon($param, $msg, $res_status, $status_msg, $rows, $result);

        return response()->json($response);


    }


}
