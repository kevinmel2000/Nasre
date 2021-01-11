<?php

use App\Http\Controllers\KocController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeLookupLocationController;
use App\Http\Controllers\GolfFieldHoleController;
use App\Http\Controllers\CedingBrokerController;
use App\Http\Controllers\MasterController;

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

    // SECTION KOC Exchange Routes
    Route::get('/koc', [KocController::class, 'index'])->middleware(['can:view-koc']);
    Route::post('/koc/store', [KocController::class, 'store'])->middleware(['can:create-koc']);
    Route::put('koc/{exc}', [KocController::class, 'update'])->middleware(['can:update-koc']);
    Route::delete('/koc/destroy/{exc}', [KocController::class, 'destroy'])->middleware(['can:delete-koc']);

    // SECTION GolfFIeld Exchange Routes
    Route::get('/golfhole', [GolfFieldHoleController::class, 'index'])->middleware(['can:view-gfh']);
    Route::post('/golfhole/store', [GolfFieldHoleController::class, 'store'])->middleware(['can:create-gfh']);
    Route::put('golfhole/{gfh}', [GolfFieldHoleontroller::class, 'update'])->middleware(['can:update-gfh']);
    Route::delete('/golfhole/destroy/{gfh}', [GolfFieldHoleController::class, 'destroy'])->middleware(['can:delete-gfh']);

    // SECTION cedingbroker Exchange Routes
    Route::get('/cedingbroker', [CedingBrokerController::class, 'index'])->middleware(['can:view-cedingbroker']);
    Route::post('/cedingbroker/store', [CedingBrokerController::class, 'store'])->middleware(['can:create-cedingbroker']);
    Route::put('cedingbroker/{cb}', [CedingBrokerController::class, 'update'])->middleware(['can:update-cedingbroker']);
    Route::delete('/cedingbroker/destroy/{cb}', [CedingBrokerController::class, 'destroy'])->middleware(['can:delete-cedingbroker']);

    // SECTION cedingbroker Exchange Routes
    Route::get('/felookuplocation', [FeLookupLocationController::class, 'index'])->middleware(['can:view-felookup']);
    Route::post('/felookuplocation/store', [FeLookupLocationController::class, 'store'])->middleware(['can:create-felookup']);
    Route::put('felookuplocation/{fl}', [FeLookupLocationController::class, 'update'])->middleware(['can:update-felookup']);
    Route::delete('/felookuplocation/destroy/{fl}', [FeLookupLocationController::class, 'destroy'])->middleware(['can:delete-felookup']);
    
    // Bulk Excel Import Users
    // Route::get('/import', [ ProductController::class, 'import'])->middleware(['can:create-product']);
    // Route::post('/import', [ ProductController::class, 'importStore'])->middleware(['can:create-product']);
    


});
?>