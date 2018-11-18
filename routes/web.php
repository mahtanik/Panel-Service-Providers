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
    return view('welcome');
});

Route::get('/dashboard' , 'PageController@dashboard');

Route::get('/campaignes' , 'PageController@campaignes');

Route::get('/servicesSummary' , 'PageController@tables_summary');

Route::get('/services' , 'PageController@tables_services');

Route::get('/servicesDiagram' , 'PageController@Datarep_services');

Route::get('/campaignesDiagram' , 'PageController@Datarep_campaignes');

Route::get('/login' , 'PageController@login');

Route::get('/', function() {
    return response()->json([
        'stuff' => phpinfo()
    ]);
});

Route::get('/read' , function (){
    $results = DB::select( ' select * from tb_users where id = ?' , [1] );
     return $results;
});

//Router::resource( 'dashboard' , 'PageController' );
