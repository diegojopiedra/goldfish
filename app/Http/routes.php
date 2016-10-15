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
    return view('welcome');
});

Route::resource('loan','LoanController');
Route::resource('users','UserController');
Route::get('login','UserController@login');
Route::get('logout','UserController@logout');
Route::get('loan-test', 'LoanController@store');
Route::post('search-by-identification','UserController@searchByIdentification');
Route::get('search-by-identification','UserController@searchByIdentification');
Route::resource('audiovisual-equipment', 'AudiovisualEquipmentController');
Route::resource('brand','BrandController');
Route::resource('model','AudiovisualModelController');
Route::resource('type','TypeController');
Route::resource('cartographic-material','CartographicMaterialController');
Route::resource('three-dimensional-object','ThreeDimensionalObjectController');
Route::get('loan-by-id','LoanController@returnLoanById');
Route::get('gets', "LoanController@gets");



<<<<<<< HEAD
=======
Route::get('loan-by-id','LoanController@returnLoanById');
Route::get('gets', "LoanController@gets");
>>>>>>> 97893cb6f4823268e1d296b0753980f32ec7cf57
