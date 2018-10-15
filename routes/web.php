<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('frontend.home');
});*/

Route::get('/', 'HomeController@index');
Route::get('/post/{id}', 'HomeController@post');
Route::get('/search', 'HomeController@search');
Route::get('/contract', 'HomeController@contract');
Route::get('/watched', 'HomeController@watched');
Route::get('/abouttender', 'HomeController@abouttender');
Route::get('/documentation', 'HomeController@documentation');
Route::get('/download', 'HomeController@download');

/*Route::group(['prefix' => 'id', 'namespace' => 'id', 'middleware' => 'locale:id'], function() {
    Route::get('/', 'HomeController@index')->name('idHome');
});

Route::group(['prefix' => 'en', 'namespace' => 'en', 'middleware' => 'locale:en'], function() {
    Route::get('/', 'HomeController@index')->name('enHome');
});

Route::get('/', function() {
    return redirect()->route('idHome');
});*/

Route::get('/{locale}', function ($locale) {
    App::setLocale($locale);
});