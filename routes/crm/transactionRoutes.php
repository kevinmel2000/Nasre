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

Route::post('/store-fe-sliplocation-list','FeSlipController@storelocationlist')->name('locationlist.store');
Route::delete('/delete-sliplocation-list/{id}','FeSlipController@destroysliplocationlist')->name('sliplistlocation.delete');

Route::post('/store-interest-list','TransactionController@storeinterestlist')->name('interestlist.store');
Route::delete('/delete-interest-list/{id}','TransactionController@destroyinterestlist')->name('interestlist.delete');

Route::post('/store-installment-list','TransactionController@storeinstallmentlist')->name('installment.store');
Route::delete('/delete-installment-list/{id}','TransactionController@destroyinstallmentlist')->name('installment.delete');

Route::post('/store-extendcoverage-list','TransactionController@storeextendcoveragelist')->name('extendcoverage.store');
Route::delete('/delete-extendcoverage-list/{id}','TransactionController@destroyextendcoveragelist')->name('extendcoverage.delete');

Route::post('/store-deductible-list','TransactionController@storedeductiblelist')->name('deductible.store');
Route::delete('/delete-deductible-list/{id}','TransactionController@destroydeductiblelist')->name('deductible.delete');

Route::post('/store-retrocession-list','TransactionController@storeretrocessionlist')->name('retrocession.store');
Route::delete('/delete-retrocession-list/{id}','TransactionController@destroyretrocessionlist')->name('retrocession.delete');


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


    Route::post('/fe-insured/store', [FeSlipController::class, 'storefeinsured']);
    Route::post('/fe-insured', [TransactionController::class, 'storefeinsured']);
    Route::post('/fe-slip/store/{fe}', [FeSlipController::class, 'storefeslip']);
    Route::delete('/fe-slip/destroy/{fe}', [FeSlipController::class, 'destroy']);
    Route::post('/fe-slip/getCostumers/','FeSlipController@getCostumers')->name('customer.getCostumers');


    // SECTION Financial Lines Slip Group Routes
    Route::get('/fl-slip', [FinancialLineSlipController::class, 'indexflslip']);
    Route::get('/fl-slipindex', [FinancialLineSlipController::class, 'index']);
    Route::post('/fl-slipindex', [FinancialLineSlipController::class, 'index']);

    
  
    Route::post('/fl-insured/store', [FinancialLineSlipController::class, 'storeflinsured']);
    Route::post('/fl-slip/store/{fe}', [FinancialLineSlipController::class, 'storeflslip']);
    Route::delete('/fl-slip/destroy/{fe}', [FinancialLineSlipController::class, 'destroy']);
    
    // SECTION Moveable Property Slip Group Routes
    Route::get('/mp-slip', [MovePropSlipController::class, 'indexmpslip']);
    Route::get('/mp-slipindex', [MovePropSlipController::class, 'index']);
    Route::post('/mp-slipindex', [MovePropSlipController::class, 'index']);
    
    Route::post('/mp-insured/store', [MovePropSlipController::class, 'storempinsured']);
    Route::post('/mp-slip/store/{fe}', [MovePropSlipController::class, 'storempslip']);
    Route::delete('/mp-slip/destroy/{fe}', [MovePropSlipController::class, 'destroy']);
    

    // SECTION HE & Motor Slip Group Routes
    Route::get('/hem-slip', [HeMotorSlipController::class, 'indexhemslip']);
    Route::get('/hem-slipindex', [HeMotorSlipController::class, 'index']);
    Route::post('/hem-slipindex', [HeMotorSlipController::class, 'index']);

    Route::post('/hem-insured/store', [HeMotorSlipController::class, 'storeheminsured']);
    Route::post('/hem-slip/store/{fe}', [HeMotorSlipController::class, 'storehemslip']);
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