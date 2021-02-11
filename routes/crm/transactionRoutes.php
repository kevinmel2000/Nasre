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
Route::put('ship-list/{slt}', 'TransactionController@updateshiplist');
Route::delete('/delete-ship-list/{id}','TransactionController@destroyshiplist')->name('shiplist.delete');

Route::post('/store-fe-sliplocation-list','FeSlipController@storelocationlist')->name('locationlist.store');
Route::delete('/delete-sliplocation-list/{id}','FeSlipController@destroysliplocationlist')->name('sliplistlocation.delete');

Route::post('/store-interest-list','TransactionController@storeinterestlist')->name('interestlist.store');
Route::delete('/delete-interest-list/{id}','TransactionController@destroyinterestlist')->name('interestlist.delete');

Route::post('/store-installment-list','TransactionController@storeinstallmentlist')->name('installment.store');
Route::delete('/delete-installment-list/{id}','TransactionController@destroyinstallmentlist')->name('installment.delete');

Route::post('/store-extendcoverage-list','TransactionController@storeextendcoveragelist')->name('extendcoverage.store');
Route::delete('/delete-extendcoverage-list/{id}','TransactionController@destroyextendcoveragelist')->name('extendcoverage.delete');

Route::post('/store-conditionneeded-list','TransactionController@storeconditionneededlist')->name('conditionneeded.store');
Route::delete('/delete-conditionneeded-list/{id}','TransactionController@destroyconditionneededlist')->name('conditionneeded.delete');

Route::post('/store-deductible-list','TransactionController@storedeductiblelist')->name('deductible.store');
Route::delete('/delete-deductible-list/{id}','TransactionController@destroydeductiblelist')->name('deductible.delete');

Route::post('/store-retrocession-list','TransactionController@storeretrocessionlist')->name('retrocession.store');
Route::delete('/delete-retrocession-list/{id}','TransactionController@destroyretrocessionlist')->name('retrocession.delete');

Route::post('/store-propertytype-list','TransactionController@storepropertytypelist')->name('propertytype.store');
Route::delete('/delete-propertytype-list/{id}','TransactionController@destroypropertytypelist')->name('propertytype.delete');
Route::post('store-multi-file-ajax', [FeSlipController::class, 'storeMultiFile']);
    

Route::group(['prefix'=>'/transaction-data','middleware'=>['auth']], function(){
    

    // SECTION Marine Slip Group Routes
    Route::get('/marine-slip', [TransactionController::class, 'indexmarineslip']);
    Route::get('/marine-index', [TransactionController::class, 'indexmarine']);
    Route::get('/marine-slip/{id}', [TransactionController::class, 'showslipdetails']);
    Route::get('/marine-slip/edit/{id}', [TransactionController::class, 'editslipdetails']);
    Route::get('/marine-insured/{id}', [TransactionController::class, 'showinsureddetails']);
    Route::get('/marine-insured/edit/{id}', [TransactionController::class, 'editinsureddetails']);
    Route::post('/marine-insured/store', [TransactionController::class, 'storemarineinsured']);
    Route::post('/marine-slip/store', [TransactionController::class, 'storemarineslip']);
    Route::delete('/marine-insured/destroyinsured/{id}', [TransactionController::class, 'destroymarineinsured']);
    Route::delete('/marine-slip/destroyslip/{id}', [TransactionController::class, 'destroyemarineslip']);


    // SECTION Fire Engineering Slip Group Routes
    Route::get('/fe-slip', [FeSlipController::class, 'indexfeslip']);
    Route::get('/fe-slipindex', [FeSlipController::class, 'index']);
    Route::post('/fe-slipindex', [FeSlipController::class, 'index']);
    Route::post('/fe-insured/store', [FeSlipController::class, 'storefeinsured']);
    Route::post('/fe-insured', [TransactionController::class, 'storefeinsured']);
    Route::post('/fe-slip/store', [FeSlipController::class, 'storefeslip']);
    Route::get('/fe-slip/updatefeslip/{fe}', [FeSlipController::class, 'updatefeslip']);
    Route::get('/updatefeslip/{fe}', [FeSlipController::class, 'updatefeslip']);
    Route::get('/fe-slip/detailfeslip/{fe}', [FeSlipController::class, 'detailfeslip']);
    Route::get('/detailfeslip/{fe}', [FeSlipController::class, 'detailfeslip']);
    Route::delete('/fe-slip/destroy/{fe}', [FeSlipController::class, 'destroy']);
    Route::post('/fe-slip/getCostumers/','FeSlipController@getCostumers')->name('customer.getCostumers');

    
    // SECTION Financial Lines Slip Group Routes
    Route::get('/fl-slip', [FinancialLineSlipController::class, 'indexflslip']);
    Route::get('/fl-slipindex', [FinancialLineSlipController::class, 'index']);
    Route::post('/fl-slipindex', [FinancialLineSlipController::class, 'index']);
    Route::post('/fl-insured/store', [FinancialLineSlipController::class, 'storeflinsured']);
    Route::post('/fl-slip/store', [FinancialLineSlipController::class, 'storeflslip']);
    Route::get('/fl-slip/updateflslip/{fe}', [FinancialLineSlipController::class, 'updateflslip']);
    Route::get('/updateflslip/{fe}', [FinancialLineSlipController::class, 'updateflslip']);
    Route::get('/fl-slip/detailflslip/{fe}', [FinancialLineSlipController::class, 'detailflslip']);
    Route::get('/detailflslip/{fe}', [FinancialLineSlipController::class, 'detailflslip']);
    Route::delete('/fl-slip/destroy/{fe}', [FinancialLineSlipController::class, 'destroy']);
    
    // SECTION Moveable Property Slip Group Routes
    Route::get('/mp-slip', [MovePropSlipController::class, 'indexmpslip']);
    Route::get('/mp-slipindex', [MovePropSlipController::class, 'index']);
    Route::post('/mp-slipindex', [MovePropSlipController::class, 'index']);
    Route::post('/mp-insured/store', [MovePropSlipController::class, 'storempinsured']);
    Route::post('/mp-slip/store', [MovePropSlipController::class, 'storempslip']);
    Route::get('/mp-slip/updatempslip/{fe}', [MovePropSlipController::class, 'updatempslip']);
    Route::get('/updatempslip/{fe}', [MovePropSlipController::class, 'updatempslip']);
    Route::get('/mp-slip/detailmpslip/{fe}', [MovePropSlipController::class, 'detailmpslip']);
    Route::get('/detailmpslip/{fe}', [MovePropSlipController::class, 'detailmpslip']);
    Route::delete('/mp-slip/destroy/{fe}', [MovePropSlipController::class, 'destroy']);
    

    // SECTION HE & Motor Slip Group 
    Route::get('/hem-slip', [HeMotorSlipController::class, 'indexhemslip']);
    Route::get('/hem-slipindex', [HeMotorSlipController::class, 'index']);
    Route::post('/hem-slipindex', [HeMotorSlipController::class, 'index']);
    Route::post('/hem-insured/store', [HeMotorSlipController::class, 'storeheminsured']);
    Route::post('/hem-slip/store', [HeMotorSlipController::class, 'storehemslip']);
    Route::get('/hem-slip/updatehemslip/{fe}', [MovePropSlipController::class, 'updatehemslip']);
    Route::get('/updatehemslip/{fe}', [MovePropSlipController::class, 'updatehemslip']);
    Route::get('/hem-slip/detailhemslip/{fe}', [MovePropSlipController::class, 'detailhemslip']);
    Route::get('/detailhemslip/{fe}', [MovePropSlipController::class, 'detailhemslip']);
    Route::delete('/hem-slip/destroy/{fe}', [HeMotorSlipController::class, 'destroy']);
    

    // SECTION Hole in Ones Slip Group Routes
    Route::get('/hio-slip', [TransactionController::class, 'indexhioslip']);
    Route::get('/hio-index', [TransactionController::class, 'indexhio']);
    Route::get('/hio-slip/{id}', [TransactionController::class, 'showlocationdetails'])->name('locDetails');
    Route::post('/hio-insured', [TransactionController::class, 'storehioinsured']);
    Route::post('/hio-slip', [TransactionController::class, 'storehioslip']);


    // SECTION Personal Accident Slip Group Routes
    Route::get('/pa-slip', [TransactionController::class, 'indexpaslip']);
    Route::get('/pa-index', [TransactionController::class, 'indexpa']);
    Route::get('/pa-slip/{id}', [TransactionController::class, 'showlocationdetails'])->name('locDetails');
    Route::post('/pa-insured', [TransactionController::class, 'storepainsured']);
    Route::post('/pa-slip', [TransactionController::class, 'storepaslip']);
 


    // Route::get('/country', [MasterController::class, 'indexcountry'])->middleware(['can:view-country']);
    // Route::post('/country/store', [MasterController::class, 'storecountry'])->middleware(['can:create-country']);
    // Route::put('country/{country}', [MasterController::class, 'updatecountry'])->middleware(['can:update-country']);
    // Route::delete('/country/destroy/{country}', [MasterController::class, 'destroycountry'])->middleware(['can:delete-country']);
    
    // Bulk Excel Import Users
    // Route::get('/import', [ ProductController::class, 'import'])->middleware(['can:create-product']);
    // Route::post('/import', [ ProductController::class, 'importStore'])->middleware(['can:create-product']);
    


});
?>