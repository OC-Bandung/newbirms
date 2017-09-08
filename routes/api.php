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
Route::get('pns/{kewenangan}/{year}', 'ApiBIRMS@get_pns');

Route::get('contract/all','ApiBIRMS@contractAll');


/*

	
*/