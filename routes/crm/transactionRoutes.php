<?php

use App\Http\Controllers\KocController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeLookupLocationController;
use App\Http\Controllers\GolfFieldHoleController;
use App\Http\Controllers\CedingBrokerController;
use App\Http\Controllers\TransactionController;

Route::group(['prefix'=>'/transaction-data','middleware'=>['auth']], function(){
    
    // SECTION Marine Slip Group Routes
    Route::get('/marine-slip', [TransactionController::class, 'indexmarineslip']);
    Route::post('/marine-insured', [TransactionController::class, 'storemarineinsured']);
    Route::post('/marine-slip', [TransactionController::class, 'storemarineslip']);

    // SECTION Fire Engineering Slip Group Routes
    Route::get('/fe-slip', [TransactionController::class, 'indexfeslip']);

    // SECTION Financial Lines Slip Group Routes
    Route::get('/fl-slip', [TransactionController::class, 'indexflslip']);

    // SECTION Moveable Property Slip Group Routes
    Route::get('/mp-slip', [TransactionController::class, 'indexmpslip']);

    // SECTION Hole in Ones Slip Group Routes
    Route::get('/hio-slip', [TransactionController::class, 'indexhioslip']);

    // SECTION Personal Accident Slip Group Routes
    Route::get('/pa-slip', [TransactionController::class, 'indexpaslip']);

    // SECTION HE & Motor Slip Group Routes
    Route::get('/hem-slip', [TransactionController::class, 'indexhemslip']);


    // Route::get('/country', [MasterController::class, 'indexcountry'])->middleware(['can:view-country']);
    // Route::post('/country/store', [MasterController::class, 'storecountry'])->middleware(['can:create-country']);
    // Route::put('country/{country}', [MasterController::class, 'updatecountry'])->middleware(['can:update-country']);
    // Route::delete('/country/destroy/{country}', [MasterController::class, 'destroycountry'])->middleware(['can:delete-country']);
    
    // Bulk Excel Import Users
    // Route::get('/import', [ ProductController::class, 'import'])->middleware(['can:create-product']);
    // Route::post('/import', [ ProductController::class, 'importStore'])->middleware(['can:create-product']);
    


});
?>