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

Route::get('/', function () {
    return view('login' , 'PageController@login');
});

//coming soon
//Route::get('/campaignes' , 'PageController@campaignes');

//coming soon
//Route::get('/campaignesDiagrams' , 'PageController@Datarep_campaignes');

Route::get('/login' , 'PageController@login');

Route::get('/servicesSummary' , 'ServiceController@service_summary' );

Route::get('/services' , 'ServiceController@services' );

Route::get('/servicesDiagrams' , 'serviceDiagramsController@Fill' );

Route::get('/dashboard' , 'dashboardController@counter');

