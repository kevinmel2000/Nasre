<?php

use App\Http\Controllers\KocController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeLookupLocationController;
use App\Http\Controllers\GolfFieldHoleController;
use App\Http\Controllers\CedingBrokerController;
use App\Http\Controllers\FeSlipController;
use App\Http\Controllers\FinancialLineSlipController;
use App\Http\Controllers\HeMotorSlipController;
use App\Http\Controllers\MovePropSlipController;
use App\Http\Controllers\TransactionController;


Route::get('get-ship-list','TransactionController@showShipList');
Route::post('/store-ship-list','TransactionController@storeshiplist')->name('shiplist.store');
Route::delete('/delete-ship-list/{id}','TransactionController@destroyshiplist')->name('shiplist.delete');
Route::group(['prefix'=>'/transaction-data','middleware'=>['auth']], function(){
    

    // SECTION Marine Slip Group Routes
    Route::get('/marine-slip', [TransactionController::class, 'indexmarineslip']);
    Route::get('/marine-slip/{id}', [TransactionController::class, 'showshipdetails'])->name('shipDetails');
    Route::post('/marine-insured', [TransactionController::class, 'storemarineinsured']);
    Route::post('/marine-slip', [TransactionController::class, 'storemarineslip']);

    // SECTION Fire Engineering Slip Group Routes
    Route::get('/fe-slip', [FeSlipController::class, 'indexfeslip']);
    Route::get('/fe-slipindex', [FeSlipController::class, 'index']);
    Route::post('/fe-slipindex', [FeSlipController::class, 'index']);

    Route::delete('/fe-slip/destroy/{fe}', [FeSlipController::class, 'destroy']);


    // SECTION Financial Lines Slip Group Routes
    Route::get('/fl-slip', [FinancialLineSlipController::class, 'indexflslip']);
    Route::get('/fl-slipindex', [FinancialLineSlipController::class, 'index']);
    Route::post('/fl-slipindex', [FinancialLineSlipController::class, 'index']);

    Route::delete('/fl-slip/destroy/{fe}', [FinancialLineSlipController::class, 'destroy']);
    
    // SECTION Moveable Property Slip Group Routes
    Route::get('/mp-slip', [MovePropSlipController::class, 'indexmpslip']);
    Route::get('/mp-slipindex', [MovePropSlipController::class, 'index']);
    Route::post('/mp-slipindex', [MovePropSlipController::class, 'index']);
    
    Route::delete('/mp-slip/destroy/{fe}', [MovePropSlipController::class, 'destroy']);

    // SECTION HE & Motor Slip Group Routes
    Route::get('/hem-slip', [HeMotorSlipController::class, 'indexhemslip']);
    Route::get('/hem-slipindex', [HeMotorSlipController::class, 'index']);
    Route::post('/hem-slipindex', [HeMotorSlipController::class, 'index']);

    Route::delete('/hem-slip/destroy/{fe}', [HeMotorSlipController::class, 'destroy']);

    // SECTION Hole in Ones Slip Group Routes
    Route::get('/hio-slip', [TransactionController::class, 'indexhioslip']);

    // SECTION Personal Accident Slip Group Routes
    Route::get('/pa-slip', [TransactionController::class, 'indexpaslip']);

 


    // Route::get('/country', [MasterController::class, 'indexcountry'])->middleware(['can:view-country']);
    // Route::post('/country/store', [MasterController::class, 'storecountry'])->middleware(['can:create-country']);
    // Route::put('country/{country}', [MasterController::class, 'updatecountry'])->middleware(['can:update-country']);
    // Route::delete('/country/destroy/{country}', [MasterController::class, 'destroycountry'])->middleware(['can:delete-country']);
    
    // Bulk Excel Import Users
    // Route::get('/import', [ ProductController::class, 'import'])->middleware(['can:create-product']);
    // Route::post('/import', [ ProductController::class, 'importStore'])->middleware(['can:create-product']);
    


});
?>