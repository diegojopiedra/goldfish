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
    return "API";
});
Route::resource('users','UserController');
Route::post('login','UserController@login');
Route::post('logout','UserController@logout');
Route::group(['middleware' => 'jwt-auth'], function () {
	Route::resource('loanable','LoanableController');
	Route::post('automatic-loan','LoanController@automaticLoan');
	Route::post('search-by-identification','UserController@searchByIdentification');
	Route::post('loan-by-id', 'LoanController@returnLoanById');
	Route::resource('audiovisual-equipment', 'AudiovisualEquipmentController');
	Route::resource('type','TypeController');
	Route::resource('brand','BrandController');
	Route::resource('model','AudiovisualModelController');
	Route::resource('state','StateController');
	Route::resource('penalty', 'PenaltyController');
	Route::resource('role', 'RoleController');
	Route::resource('key-word', 'KeyWordController');
	Route::resource('editorial', 'EditorialController');
	Route::resource('loan','LoanController');
	Route::resource('bibliographic-material', 'BibliographicMaterialController');
	Route::resource('editorial', 'EditorialController');
	Route::resource('cartographic-material', 'CartographicMaterialController');
	Route::resource('cartographic-format','CartographicFormatsController');
	Route::resource('configuration','ConfigurationController');
	Route::resource('three-dimensional-object','ThreeDimensionalObjectController');
	Route::resource('audiovisual-material','AudiovisualMaterialController');
	Route::resource('audiovisual-format','AudiovisualFormatController');
    Route::resource('audiovisual-type','AudiovisualMaterialTypeController');
    Route::resource('canton','CantonController');
    Route::resource('district', 'DistrictController');
    Route::resource('province','ProvinceController');
    Route::post('search-loanable','LoanableController@search');
});


Route::get('loan-test', 'LoanController@store');
Route::get('get-all-users','UserController@getAllUsers');
Route::resource('audiovisual-format','AudiovisualFormatController');
Route::resource('audiovisual-type','AudiovisualMaterialTypeController');
Route::resource('audiovisual-equipment', 'AudiovisualEquipmentController');
Route::resource('audiovisual-material','AudiovisualMaterialController');
Route::resource('three-dimensional-object','ThreeDimensionalObjectController');
Route::resource('cartographic-material', 'CartographicMaterialController');
Route::resource('book','BookController');
Route::get('search-by-name','UserController@searchByName');
Route::post('return-loan', 'LoanController@returnLoan');
Route::resource('periodic-publication','PeriodicPublicationController');
Route::resource('copy-periodic-publication','CopyPeriodicPublicationController');
Route::get('get-loans-by-date','StatisticsController@getLoansByDate');
Route::get('get-pendings-by-date','StatisticsController@getPendingsByDate');
Route::get('total-pending-loans','LoanController@totalPendingsLoans');
Route::get('pendings-by-day','LoanController@dayPendingsLoans');


