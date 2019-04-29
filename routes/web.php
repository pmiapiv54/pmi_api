<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/'], function ($app) {

    $app->post('register', 'Login@register');
    $app->post('login', 'Login@login');
    $app->post('lupa_password', 'Login@lupa_password');
    $app->post('konfirmasi_lupa_password', 'Login@konfirmasi_lupassword');
    $app->post('feedback', 'Feedback@feedback');
    $app->post('ganti_password', 'Login@ganti_password');
    $app->post('update_profile/{kode}', 'Pendonor@update_profile');

    $app->get('news', 'News@get_news');
    $app->get('data_pendonor/{Kode}', 'Pendonor@get_data_pendonor');
    $app->get('event', 'Kegiatan@get_kegiatan');
    $app->get('goldar', 'GolonganDarah@get_component_goldar');
    $app->get('riwayat_pendonor/{kodePendonor}', 'Pendonor@get_riwayat_donor');

    

});
