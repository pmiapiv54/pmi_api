<?php
/*$nama = 'juminten';
$kode = 'kode';
*/
/*$data= [
    'nama' => 'Juminten Of The world',
    'kode' => 'kode_user',
    'password' => '1234',
];*/

$password = substr( $data['password'] ,0 ,3 ).'*********';

?>
<table bgcolor="#EFF2F4" style="background-color: #EFF2F4!important;border-collapse: collapse;border-spacing: 0;width: 100%;font-family: Arial,sans-serif;color: #576574!important;font-size: 24px;line-height: 28px;text-align: center;margin: 0;padding: 0;">
    <tbody>
        <tr>
            <td style="border-collapse: collapse;
            font-size: 14px;
            line-height: 24px;
            border-spacing: 0;
            font-family: Arial,sans-serif;
            background: url('https://i.ibb.co/YbVP8MM/background.png') no-repeat top center/100% 240px;
            margin: 0;
            padding: 0 0 64px;">
                <div style="padding-top:160px;"></div>
                <table style="border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                margin: 0;
                padding: 0;">
                    <tbody>
                        <tr>
                            <td style="min-width: 16px; margin: 0; padding: 0;"></td>
                            
                            <td style="background-color: #ffffff!important;width: 540px;
                            max-width: 600px;border-radius: 6px;margin: 0;padding: 24px;text-align: center;">
                                <table style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h1 style="color:#222F3E;text-align: center;margin-bottom: 10px;font-weight: 400">Registrasi <b style="color:green">Success</b></h1>
                                                <table style="margin-top:36px;text-align:left;padding-top:20px">
                                                    <tbody>
                                                        <tr>
                                                            <td style="color:#576574;line-height: 24px;">
                                                                Hi <b>{{ $data['nama'] }}</b>, Anda telah berhasil Registrasi sebagai Pendonor di PMI Tangerang


                                                                    <table width="300px" style="
                                                                            text-align: left;
                                                                            color:#576574;
                                                                        ">
                                                                        <tr>
                                                                            <td><b>note</b></td>
                                                                            <td colspan="2"><b>:</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Username</td>
                                                                            <td>:</td>
                                                                            <td><b>{{ $data['kode'] }}</b></td>
                                                                        </tr>
                                                                        <tr style="vertical-align: top;">
                                                                            <td>Password</td>
                                                                            <td>:</td>
                                                                            <td><b>{{ $password }}</b></td>
                                                                        </tr>
                                                                    </table>                                                              


                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="margin-top:32px;width: 100%;border-color: #EFF2F4!important;">
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </td>

                            <td style="min-width: 16px; margin: 0; padding: 0;"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>