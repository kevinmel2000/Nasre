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

Route::get('get-state-list','FeLookupLocationController@getStateList');
Route::get('get-city-list','FeLookupLocationController@getCityList');


Route::group(['prefix'=>'/master-data','middleware'=>['auth']], function(){

    // SECTION Country Group Routes
    Route::get('/country', [MasterController::class, 'indexcountry'])->middleware(['can:view-country']);
    Route::post('/country/store', [MasterController::class, 'storecountry'])->middleware(['can:create-country']);
    Route::put('country/{country}', [MasterController::class, 'updatecountry'])->middleware(['can:update-country']);
    Route::delete('/country/destroy/{country}', [MasterController::class, 'destroycountry'])->middleware(['can:delete-country']);

    
    // SECTION COB Group Routes
    Route::get('/cob', [MasterController::class, 'indexcob'])->middleware(['can:view-cob']);
    Route::post('/cob/store', [MasterController::class, 'storecob'])->middleware(['can:create-cob']);
    Route::put('cob/{cob}', [MasterController::class, 'updatecob'])->middleware(['can:update-cob']);
    Route::delete('/cob/destroy/{cob}', [MasterController::class, 'destroycob'])->middleware(['can:delete-cob']);


    // SECTION Occupation Routes
    Route::get('/occupation', [MasterController::class, 'indexoccupation'])->middleware(['can:view-occupation']);
    Route::post('/occupation/store', [MasterController::class, 'storeoccupation'])->middleware(['can:create-occupation']);
    Route::put('occupation/{ocp}', [MasterController::class, 'updateoccupation'])->middleware(['can:update-occupation']);
    Route::delete('/occupation/destroy/{ocp}', [MasterController::class, 'destroyoccupation'])->middleware(['can:delete-occupation']);


    // SECTION currency Routes
    Route::get('/currency', [MasterController::class, 'indexcurrency'])->middleware(['can:view-currency']);
    Route::post('/currency/store', [MasterController::class, 'storecurrency'])->middleware(['can:create-currency']);
    Route::put('currency/{crc}', [MasterController::class, 'updatecurrency'])->middleware(['can:update-currency']);
    Route::delete('/currency/destroy/{crc}', [MasterController::class, 'destroycurrency'])->middleware(['can:delete-currency']);


    // SECTION currency Exchange Routes
    Route::get('/exchange', [MasterController::class, 'indexexchange'])->middleware(['can:view-exchange']);
    Route::post('/exchange/store', [MasterController::class, 'storeexchange'])->middleware(['can:create-exchange']);
    Route::put('exchange/{exc}', [MasterController::class, 'updateexchange'])->middleware(['can:update-exchange']);
    Route::delete('/exchange/destroy/{exc}', [MasterController::class, 'destroyexchange'])->middleware(['can:delete-exchange']);


    // SECTION FE Lookup Routes
    Route::get('/felookuplocation', [FeLookupLocationController::class, 'index'])->middleware(['can:view-felookup']);
    Route::post('/felookuplocation', [FeLookupLocationController::class, 'index'])->middleware(['can:view-felookup']);
    Route::post('/felookuplocation/store', [FeLookupLocationController::class, 'store'])->middleware(['can:create-felookup']);
    Route::put('/felookuplocation/update/{fl}', [FeLookupLocationController::class, 'update'])->middleware(['can:update-felookup']);
    Route::delete('/felookuplocation/destroy/{fl}', [FeLookupLocationController::class, 'destroy'])->middleware(['can:delete-felookup']);


    // SECTION KOC Routes
    Route::get('/koc', [KocController::class, 'index'])->middleware(['can:view-koc']);
    Route::post('/koc/store', [KocController::class, 'store'])->middleware(['can:create-koc']);
    Route::put('/koc/update/{exc}', [KocController::class, 'update'])->middleware(['can:update-koc']);
    Route::delete('/koc/destroy/{exc}', [KocController::class, 'destroy'])->middleware(['can:delete-koc']);


    // SECTION City Routes
    Route::get('/city',  [CityController::class, 'index'])->middleware(['can:view-city']);
    Route::post('/city',  [CityController::class, 'index'])->middleware(['can:view-city']);
    Route::post('/city/store', [CityController::class, 'store'])->middleware(['can:create-city']);
    Route::put('/city/update/{city}', [CityController::class, 'update'])->middleware(['can:update-city']);
    Route::delete('/city/destroy/{city}', [CityController::class, 'destroy'])->middleware(['can:delete-city']);

    // SECTION State Routes
    Route::get('/state',  [StateController::class, 'index'])->middleware(['can:view-state']);
    Route::post('/state',  [StateController::class, 'index'])->middleware(['can:view-state']);
    Route::post('/state/store', [StateController::class, 'store'])->middleware(['can:create-state']);
    Route::put('/state/update/{state}', [StateController::class, 'update'])->middleware(['can:update-state']);
    Route::delete('/state/destroy/{state}', [StateController::class, 'destroy'])->middleware(['can:delete-state']);

    // SECTION Golf Hole Routes
    Route::get('/golffieldhole', [GolfFieldHoleController::class, 'index'])->middleware(['can:view-gfh']);
    Route::post('/golffieldhole/store', [GolfFieldHoleController::class, 'store'])->middleware(['can:create-gfh']);
    Route::put('/golffieldhole/update/{gfh}', [GolfFieldHoleontroller::class, 'update'])->middleware(['can:update-gfh']);
    Route::delete('/golffieldhole/destroy/{gfh}', [GolfFieldHoleController::class, 'destroy'])->middleware(['can:delete-gfh']);

    // SECTION Ceding Broker Routes
    Route::get('/cedingbroker', [CedingBrokerController::class, 'index'])->middleware(['can:view-cedingbroker']);
    Route::post('/cedingbroker', [CedingBrokerController::class, 'index'])->middleware(['can:view-cedingbroker']);
    Route::post('/cedingbroker/store', [CedingBrokerController::class, 'store'])->middleware(['can:create-cedingbroker']);
    Route::put('/cedingbroker/update/{cb}', [CedingBrokerController::class, 'update'])->middleware(['can:update-cedingbroker']);
    Route::delete('/cedingbroker/destroy/{cb}', [CedingBrokerController::class, 'destroy'])->middleware(['can:delete-cedingbroker']);

    // SECTION Earthquake Zone Routes
    Route::get('/earthquakezone', [EarthQuakeZoneController::class, 'index'])->middleware(['can:view-eqz']);
    Route::post('/earthquakezone', [EarthQuakeZoneController::class, 'index'])->middleware(['can:view-eqz']);
    Route::post('/earthquakezone/store',  [EarthQuakeZoneController::class, 'store'])->middleware(['can:create-eqz']);
    Route::put('/earthquakezone/update/{eq}', [EarthQuakeZoneController::class, 'update'])->middleware(['can:update-eqz']);
    Route::delete('/earthquakezone/destroy/{eq}',  [EarthQuakeZoneController::class, 'destroy'])->middleware(['can:delete-eqz']);

    // SECTION Flood Zone Routes
    Route::get('/floodzone', [FloodZoneController::class, 'index'])->middleware(['can:view-fz']);
    Route::post('/floodzone', [FloodZoneController::class, 'index'])->middleware(['can:view-fz']);
    Route::post('/floodzone/store',  [FloodZoneController::class, 'store'])->middleware(['can:create-fz']);
    Route::put('/floodzone/update/{flood}', [FloodZoneController::class, 'update'])->middleware(['can:update-fz']);
    Route::delete('/floodzone/destroy/{flood}',  [FloodZoneController::class, 'destroy'])->middleware(['can:delete-fz']);
    

    // SECTION Ship Type Routes
    Route::get('/shiptype', [MasterController::class, 'indexshiptype'])->middleware(['can:view-shiptype']);
    Route::post('/shiptype/store', [MasterController::class, 'storeshiptype'])->middleware(['can:create-shiptype']);
    Route::put('shiptype/{st}', [MasterController::class, 'updateshiptype'])->middleware(['can:update-shiptype']);
    Route::delete('/shiptype/destroy/{st}', [MasterController::class, 'destroyshiptype'])->middleware(['can:delete-shiptype']);

    // SECTION Classification Routes
    Route::get('/classification', [MasterController::class, 'indexclassification'])->middleware(['can:view-classification']);
    Route::post('/classification/store', [MasterController::class, 'storeclassification'])->middleware(['can:create-classification']);
    Route::put('classification/{cs}', [MasterController::class, 'updateclassification'])->middleware(['can:update-classification']);
    Route::delete('/classification/destroy/{cs}', [MasterController::class, 'destroyclassification'])->middleware(['can:delete-classification']);

    // SECTION Construction Routes
    Route::get('/construction', [MasterController::class, 'indexconstruction'])->middleware(['can:view-construction']);
    Route::post('/construction/store', [MasterController::class, 'storeconstruction'])->middleware(['can:create-construction']);
    Route::put('construction/{cr}', [MasterController::class, 'updateconstruction'])->middleware(['can:update-construction']);
    Route::delete('/construction/destroy/{cr}', [MasterController::class, 'destroyconstruction'])->middleware(['can:delete-construction']);

    // SECTION Marine Lookup Routes
    Route::get('/marine-lookup', [MasterController::class, 'indexmarinelookup'])->middleware(['can:view-marinelookup']);
    Route::post('/marine-lookup/store', [MasterController::class, 'storemarinelookup'])->middleware(['can:create-marinelookup']);
    Route::put('marine-lookup/{mlu}', [MasterController::class, 'updatemarinelookup'])->middleware(['can:update-marinelookup']);
    Route::delete('/marine-lookup/destroy/{mlu}', [MasterController::class, 'destroymarinelookup'])->middleware(['can:delete-marinelookup']);
   
    // SECTION property Type Routes
    Route::get('/propertytype', [MasterController::class, 'indexpropertytype'])->middleware(['can:view-property_type']);
    Route::post('/propertytype/store', [MasterController::class, 'storepropertytype'])->middleware(['can:create-property_type']);
    Route::put('propertytype/{pt}', [MasterController::class, 'updatepropertytype'])->middleware(['can:update-property_type']);
    Route::delete('/propertytype/destroy/{pt}', [MasterController::class, 'destroypropertytype'])->middleware(['can:delete-property_type']);

    // SECTION property Type Routes
    Route::get('/conditionneeded', [MasterController::class, 'indexconditionneeded'])->middleware(['can:view-condition_needed']);
    Route::post('/conditionneeded/store', [MasterController::class, 'storeconditionneeded'])->middleware(['can:create-condition_needed']);
    Route::put('conditionneeded/{cdn}', [MasterController::class, 'updateconditionneeded'])->middleware(['can:update-condition_needed']);
    Route::delete('/conditionneeded/destroy/{cdn}', [MasterController::class, 'destroyconditionneeded'])->middleware(['can:delete-condition_needed']);

    // Bulk Excel Import Users
    // Route::get('/import', [ ProductController::class, 'import'])->middleware(['can:create-product']);
    // Route::post('/import', [ ProductController::class, 'importStore'])->middleware(['can:create-product']);
    


});
?>