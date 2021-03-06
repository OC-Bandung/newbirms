<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('contracts/all', 'ApiBIRMS@contractsAll');
Route::get('contracts/year/{year}', 'ApiBIRMS@contractsPerYear');

Route::get('packages/year/{year}', 'ApiBIRMS@packagesPerYear');

Route::get('contract/{ocid}', 'ApiBIRMS_Contract@get_contract');
Route::get('newcontract/{ocid}', 'ApiBIRMS_Contract@getNewContract');
Route::get('package/{ocid}', 'ApiBIRMS_Contract@getPackage');

Route::get('pns/{kewenangan}/{year}', 'ApiBIRMS@get_pns');

Route::get('contract/all','ApiBIRMS@contractAll');

/* Searching */
Route::get('search','ApiBIRMS@search');

/* Map Packet By Kecamatan */
Route::get('kecamatan/count/{year}','ApiBIRMS@get_kecamatan_count');
Route::get('kecamatan/value/{year}','ApiBIRMS@get_kecamatan_value');

/* Data Statistic */
Route::get('graph/1','ApiBIRMS@graph1');
Route::get('graph/2/{year}','ApiBIRMS@graph2');
Route::get('graph/3/{year}','ApiBIRMS@graph3');
Route::get('graph/4','ApiBIRMS@graph4');

Route::get('graph/csv/1','ApiBIRMS@graph_csv1');
Route::get('graph/csv/2/{year}','ApiBIRMS@graph_csv2');
Route::get('graph/csv/3/{year}','ApiBIRMS@graph_csv3');
Route::get('graph/csv/4','ApiBIRMS@graph_csv4');

Route::get('recent/perencanaan','ApiBIRMS@get_recent_perencanaan');
Route::get('recent/pengadaan','ApiBIRMS@get_recent_pemilihan');
Route::get('recent/pemenang','ApiBIRMS@get_recent_pemenang');
Route::get('recent/kontrak','ApiBIRMS@get_recent_kontrak');

/* Request Diskominfo */
Route::get('skpd/{year}', 'ApiBIRMS@get_skpd');
Route::get('rencana/{year}/{organization}', 'ApiBIRMS@get_rencana');
Route::get('progres/{year}/{organization}', 'ApiBIRMS@get_progres');