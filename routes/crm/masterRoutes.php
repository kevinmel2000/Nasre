<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\CedingBrokerController;
use App\Http\Controllers\KocController;
use App\Http\Controllers\GolfFieldHoleController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\FeLookupLocationController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\EarthQuakeZoneController;
use App\Http\Controllers\FloodZoneController;
Route::group(['prefix'=>'/master-data','middleware'=>['auth']], function(){

    // SECTION Country Group Routes
    Route::get('/country', [MasterController::class, 'indexcountry']);
    Route::post('/country/store', [MasterController::class, 'storecountry']);
    Route::put('country/{country}', [MasterController::class, 'updatecountry']);
    Route::delete('/country/destroy/{country}', [MasterController::class, 'destroycountry']);
    
    // SECTION COB Group Routes
    Route::get('/cob', [MasterController::class, 'indexcob']);
    Route::post('/cob/store', [MasterController::class, 'storecob']);
    Route::put('cob/{cob}', [MasterController::class, 'updatecob']);
    Route::delete('/cob/destroy/{cob}', [MasterController::class, 'destroycob']);

    // SECTION Occupation Routes
    Route::get('/occupation', [MasterController::class, 'indexoccupation']);
    Route::post('/occupation/store', [MasterController::class, 'storeoccupation']);
    Route::put('occupation/{ocp}', [MasterController::class, 'updateoccupation']);
    Route::delete('/occupation/destroy/{ocp}', [MasterController::class, 'destroyoccupation']);

    // SECTION currency Routes
    Route::get('/currency', [MasterController::class, 'indexcurrency']);
    Route::post('/currency/store', [MasterController::class, 'storecurrency']);
    Route::put('currency/{crc}', [MasterController::class, 'updatecurrency']);
    Route::delete('/currency/destroy/{crc}', [MasterController::class, 'destroycurrency']);

    // SECTION currency Exchange Routes
    Route::get('/exchange', [MasterController::class, 'indexexchange']);
    Route::post('/exchange/store', [MasterController::class, 'storeexchange']);
    Route::put('exchange/{exc}', [MasterController::class, 'updateexchange']);
    Route::delete('/exchange/destroy/{exc}', [MasterController::class, 'destroyexchange']);

    
    Route::get('/felookuplocation', [FeLookupLocationController::class, 'index']);
    Route::post('/felookuplocation/store', [FeLookupLocationController::class, 'store']);
    Route::delete('/felookuplocation/destroy/{felookuplocation}', [FeLookupLocationController::class, 'destroy']);

    Route::get('/koc',  [KocController::class, 'index']);
    Route::post('/koc/store', [KocController::class, 'store']);
    Route::delete('/koc/destroy/{koc}', [KocController::class, 'destroy']);

    Route::get('/city',  [CityController::class, 'index']);
    Route::post('/city/store', [CityController::class, 'store']);
    Route::delete('/city/destroy/{city}', [CityController::class, 'destroy']);

    Route::get('/state',  [StateController::class, 'index']);
    Route::post('/state/store', [StateController::class, 'store']);
    Route::delete('/state/destroy/{city}', [StateController::class, 'destroy']);

    Route::get('/golffieldhole', [GolfFieldHoleController::class, 'index']);
    Route::post('/golffieldhole/store', [GolfFieldHoleController::class, 'store']);
    Route::delete('/golffieldhole/destroy/{golf}', [GolfFieldHoleController::class, 'destroy']);

    Route::get('/cedingbroker', [CedingBrokerController::class, 'index']);
    Route::post('/cedingbroker/store',  [CedingBrokerController::class, 'store']);
    Route::delete('/cedingbroker/destroy/{ceding}',  [CedingBrokerController::class, 'destroy']);

    Route::get('/earthquakezone', [EarthQuakeZoneController::class, 'index']);
    Route::post('/earthquakezone/store',  [EarthQuakeZoneController::class, 'store']);
    Route::delete('/earthquakezone/destroy/{ceding}',  [EarthQuakeZoneController::class, 'destroy']);

    Route::get('/floodzone', [FloodZoneController::class, 'index']);
    Route::post('/floodzone/store',  [FloodZoneController::class, 'store']);
    Route::delete('/floodzone/destroy/{ceding}',  [FloodZoneController::class, 'destroy']);
    
    // Bulk Excel Import Users
    // Route::get('/import', [ ProductController::class, 'import'])->middleware(['can:create-product']);
    // Route::post('/import', [ ProductController::class, 'importStore'])->middleware(['can:create-product']);
    


});
?>