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

//Route::get('/login' , 'loginController@login');

// route to show the login form
Route::get('login', array('uses' => 'LoginController@showLogin'));

// route to process the form
Route::post('login', array('uses' => 'LoginController@doLogin'));

Route::get('/servicesSummary' , 'ServiceController@service_summary' );

Route::get('/services' , 'ServiceController@services' );

Route::get('/servicesDiagrams' , 'serviceDiagramsController@Fill' );

Route::get('/servicesDiagrams2' , 'serviceDiagramsController@Diagrams' );

Route::get('/dashboard' , 'dashboardController@counter');

Route :: get('/serviceSummary2' , 'ServiceController@updateUsersRecord');

Route:: get('/services2' , 'ServiceController@AllUsersRecord');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//route for updating user records in serviceSummary and services pages
