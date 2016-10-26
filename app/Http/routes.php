<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
    return csrf_token();
});
Route::resource('loan','LoanController');
Route::resource('users','UserController');
Route::post('login','UserController@login');
Route::post('logout','UserController@logout');
Route::group(['middleware' => 'jwt-auth'], function () {
	Route::post('automatic-loan','LoanController@automaticLoan');
	Route::post('search-by-identification','UserController@searchByIdentification');
	Route::post('loan-by-id', 'LoanController@returnLoanById');
	Route::resource('audiovisual-equipment', 'AudiovisualEquipmentController');
	Route::resource('type','TypeController');
	Route::resource('brand','BrandController');
	Route::resource('model','AudiovisualModelController');
	Route::resource('state','StateController');
});
Route::get('loan-test', 'LoanController@store');


Route::post('search-by-identification','UserController@searchByIdentification');
Route::get('search-by-identification','UserController@searchByIdentification');
Route::resource('audiovisual-equipment', 'AudiovisualEquipmentController');

Route::resource('cartographic-material','CartographicMaterialController');
Route::resource('three-dimensional-object','ThreeDimensionalObjectController');
Route::resource('book','BookController');
Route::get('store','UserController@store');
Route::get('update/{id}','UserController@update');
Route::get('search-by-name','UserController@searchByName');
Route::post('return-loan', 'LoanController@returnLoan');
Route::resource('periodic-publication','PeriodicPublicationController');
Route::resource('copy-periodic-publication','CopyPeriodicPublicationController');
