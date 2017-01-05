<?php
use Illuminate\Http\Request; 
use App\Http\Controllers\LoanableController; 
use App\Http\Controllers\TypeController; 
use App\Http\Controllers\BrandController; 
use App\Http\Controllers\AudiovisualModelController; 
use App\Http\Controllers\StateController; 
use App\Http\Controllers\LoanController; 
use App\Http\Controllers\PenaltyController; 

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
    Route::post('loanable-panel-resource', function(){
    	return loanablePanelResource($request);
    });
    Route::get('loanable-panel-resource', function(Request $request){
    	return loanablePanelResource($request);
    });
    
    Route::get('dashboard-panel-resource', function(Request $request){
    	return dashboardPanleResource($request);
    });
    
    Route::post('dashboard-panel-resource', function(Request $request){
    	return dashboardPanleResource($request);
    });
});

	function dashboardPanleResource(Request $request){
		$respone = array();
		$penaltyController = new PenaltyController();
		$response['penalties'] = json_decode($penaltyController->index()->toJson());
		return $response;
	}

 function loanablePanelResource (Request $request){
	$response = [];
	$loanableController = new LoanableController();
	$response['loanable'] = $loanableController->show($request->loanable);
	$typeController = new TypeController();
	$response['types'] = $typeController->index();
	$brandController = new BrandController();
	$response['brands'] = $brandController->index();
	$modelController = new AudiovisualModelController();
	$response['models'] = $modelController->index();
	$stateController = new StateController();
	$response['states'] = $stateController->index();
	
	$loansController = new LoanController();
	$response['loans'] = $loansController->getActiveHistoryById($request->loanable);
	
	return $response; 
}

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


