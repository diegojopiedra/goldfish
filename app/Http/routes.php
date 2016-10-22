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
/*Route::get('test-store-carto','CartographicMaterialController@testStore');
Route::get('test-update-carto/{id}','CartographicMaterialController@testUpdate');
Route::get('test-destroy-carto/{id}','CartographicMaterialController@testDestroy');*/



Route::resource('three-dimensional-object','ThreeDimensionalObjectController');
/*Route::get('test-store-3d','ThreeDimensionalObjectController@testStore');
Route::get('test-update-3d/{id}','ThreeDimensionalObjectController@testUpdate');
Route::get('test-destroy-3d/{id}','ThreeDimensionalObjectController@testDestroy');*/

Route::get('loan-by-id','LoanController@returnLoanById');
Route::get('gets', "LoanController@gets");
Route::resource('book','BookController');




Route::post('return-loan', 'LoanController@returnLoan');

/*Route::get('periodic-publication','PeriodicPublicationController@testStore');
Route::get('test-destroy-publication/{id}','PeriodicPublicationController@testDestroy');

Route::get('copy-periodic-publication','CopyPeriodicPublicationController@testStore');
Route::get('copy-test-update/{id}','CopyPeriodicPublicationController@testUpdate');
Route::get('test-destroy/{id}','CopyPeriodicPublicationController@testDestroy');*/
