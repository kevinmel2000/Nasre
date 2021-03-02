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

Route::get('get-state-lookup','FeSlipController@getStateLookup');
Route::get('get-city-lookup','FeSlipController@getCityLookup');
Route::get('get-address-lookup','FeSlipController@getAddressLookup');

Route::get('get-ship-list','TransactionController@showShipList');
Route::post('/store-ship-list','TransactionController@storeshiplist')->name('shiplist.store');
Route::post('update-ship-list/{id}', 'TransactionController@updateshiplist')->name('shiplist.update');
Route::delete('/delete-ship-list/{id}','TransactionController@destroyshiplist')->name('shiplist.delete');

Route::post('/store-fe-sliplocation-list','FeSlipController@storelocationlist')->name('locationlist.store');
Route::delete('/delete-sliplocation-list/{id}','FeSlipController@destroysliplocationlist')->name('sliplistlocation.delete');

Route::get('get-interest-list','TransactionController@showinterestinsuredList');
Route::post('/store-interest-list','TransactionController@storeinterestlist')->name('interestlist.store');
Route::post('update-interest-list/{id}', 'TransactionController@updateinterestlist')->name('interestlist.update');
Route::delete('/delete-interest-list/{id}','TransactionController@destroyinterestlist')->name('interestlist.delete');

Route::get('get-installment-list','TransactionController@showinstallmentList');
Route::post('/store-installment-list','TransactionController@storeinstallmentlist')->name('installment.store');
Route::post('update-installment-list/{id}', 'TransactionController@updateinstallmentlist')->name('installmentlist.update');
Route::delete('/delete-installment-list/{id}','TransactionController@destroyinstallmentlist')->name('installment.delete');

Route::get('get-extendcoverage-list','TransactionController@showextendcoverageList');
Route::post('/store-extendcoverage-list','TransactionController@storeextendcoveragelist')->name('extendcoverage.store');
Route::post('update-extendcoverage-list/{id}', 'TransactionController@updateextendcoveragelist')->name('extendcoverage.update');
Route::delete('/delete-extendcoverage-list/{id}','TransactionController@destroyextendcoveragelist')->name('extendcoverage.delete');

Route::get('get-conditionneeded-list','TransactionController@showconditionneededList');
Route::post('/store-conditionneeded-list','TransactionController@storeconditionneededlist')->name('conditionneeded.store');
Route::post('update-conditionneeded-list/{id}', 'TransactionController@updateconditionneededlist')->name('conditionneeded.update');
Route::delete('/delete-conditionneeded-list/{id}','TransactionController@destroyconditionneededlist')->name('conditionneeded.delete');

Route::get('get-deductible-list','TransactionController@showdeductibleList');
Route::post('/store-deductible-list','TransactionController@storedeductiblelist')->name('deductible.store');
Route::post('update-deductible-list/{id}', 'TransactionController@updatedeductiblelist')->name('deductible.update');
Route::delete('/delete-deductible-list/{id}','TransactionController@destroydeductiblelist')->name('deductible.delete');

Route::get('get-retrocession-list','TransactionController@showretrocessionList');
Route::post('/store-retrocession-list','TransactionController@storeretrocessionlist')->name('retrocession.store');
Route::post('update-retrocession-list/{id}', 'TransactionController@updateretrocessionlist')->name('retrocession.update');
Route::delete('/delete-retrocession-list/{id}','TransactionController@destroyretrocessionlist')->name('retrocession.delete');

Route::get('get-holedetail-list','TransactionController@showholedetailList');
Route::post('/store-holedetail-list','TransactionController@storeholedetaillist')->name('holedetail.store');
Route::post('update-holedetail-list/{id}', 'TransactionController@updateholedetaillist')->name('holedetail.update');
Route::delete('/delete-holedetail-list/{id}','TransactionController@destroyholedetaillist')->name('holedetail.delete');

Route::post('/store-propertytype-list','TransactionController@storepropertytypelist')->name('propertytype.store');
Route::delete('/delete-propertytype-list/{id}','TransactionController@destroypropertytypelist')->name('propertytype.delete');
Route::post('store-multi-file-ajax', [FeSlipController::class, 'storeMultiFile']);
Route::get('/detailslip/{idm}', [FeSlipController::class, 'getdetailSlip']);

Route::get('/detailendorsementslip/{idm}', [FeSlipController::class, 'getdetailEndorsementSlip']);



Route::group(['prefix'=>'/transaction-data','middleware'=>['auth']], function(){
    

    // SECTION Marine Slip Group Routes
    Route::get('/marine-slip', [TransactionController::class, 'indexmarineslip']);
    Route::get('/marine-index', [TransactionController::class, 'indexmarine']);
    Route::get('/marine-endorsement/{id}', [TransactionController::class, 'indexmarineendorsement']);
    Route::get('/marine-slip/{id}', [TransactionController::class, 'showslipdetails']);
    Route::get('/marine-slip/edit/{id}', [TransactionController::class, 'editmarineslip']);
    Route::get('/marine-insured/{id}', [TransactionController::class, 'showinsureddetails']);
    Route::get('/marine-insured/edit/{id}', [TransactionController::class, 'editmarineinsured']);
    Route::post('marine-insured/update/{id}', [TransactionController::class, 'updatemarineinsured']);
    Route::post('/marine-slip/update/{id}', [TransactionController::class, 'updatemarineslip']);
    Route::post('/marine-insured/store', [TransactionController::class, 'storemarineinsured']);
    Route::post('/marine-slip/store', [TransactionController::class, 'storemarineslip']);
    Route::post('/marine-endorsement', [TransactionController::class, 'storemarineendorsement']);
    Route::delete('/marine-insured/destroyinsured/{id}', [TransactionController::class, 'destroymarineinsured']);
    Route::delete('/marine-slip/destroyslip/{id}', [TransactionController::class, 'destroymarineslip']);


    // SECTION Fire Engineering Slip Group Routes
    Route::get('/fe-slip', [FeSlipController::class, 'indexfeslip']);
    Route::get('/fe-slipindex', [FeSlipController::class, 'index']);
    Route::post('/fe-slipindex', [FeSlipController::class, 'index']);
    Route::post('/fe-insured/store', [FeSlipController::class, 'storefeinsured']);
    Route::post('/fe-insured', [TransactionController::class, 'storefeinsured']);
    Route::post('/fe-slip/store', [FeSlipController::class, 'storefeslip']);
    Route::post('/fe-slip/endorsementstore', [FeSlipController::class, 'storeendorsementfeslip']);
    Route::get('/fe-slip/updatefeslip/{fe}', [FeSlipController::class, 'updatefeslip']);
    Route::get('/updatefeslip/{fe}', [FeSlipController::class, 'updatefeslip']);
    Route::get('/detailslip/{idm}', [FeSlipController::class, 'getdetailSlip']);
    Route::get('/detailendorsementslip/{idm}', [FeSlipController::class, 'getdetailEndorsementSlip']);
    Route::get('/endorsementfeslip/{ms}/{sl}', [FeSlipController::class, 'endorsementfeslip']);
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
    Route::post('/fl-slip/endorsementstore', [FinancialLineSlipController::class, 'storeendorsementflslip']);
    Route::get('/fl-slip/updateflslip/{fe}', [FinancialLineSlipController::class, 'updateflslip']);
    Route::get('/updateflslip/{fe}', [FinancialLineSlipController::class, 'updateflslip']);
    Route::get('/endorsementflslip/{ms}/{sl}', [FinancialLineSlipController::class, 'endorsementflslip']);
    Route::get('/fl-slip/detailflslip/{fe}', [FinancialLineSlipController::class, 'detailflslip']);
    Route::get('/detailflslip/{fe}', [FinancialLineSlipController::class, 'detailflslip']);
    Route::delete('/fl-slip/destroy/{fe}', [FinancialLineSlipController::class, 'destroy']);
    
    // SECTION Moveable Property Slip Group Routes
    Route::get('/mp-slip', [MovePropSlipController::class, 'indexmpslip']);
    Route::get('/mp-slipindex', [MovePropSlipController::class, 'index']);
    Route::post('/mp-slipindex', [MovePropSlipController::class, 'index']);
    Route::post('/mp-insured/store', [MovePropSlipController::class, 'storempinsured']);
    Route::post('/mp-slip/store', [MovePropSlipController::class, 'storempslip']);
    Route::post('/mp-slip/endorsementstore', [MovePropSlipController::class, 'storeendorsementmpslip']);
    Route::get('/mp-slip/updatempslip/{fe}', [MovePropSlipController::class, 'updatempslip']);
    Route::get('/updatempslip/{fe}', [MovePropSlipController::class, 'updatempslip']);
    Route::get('/endorsementmpslip/{ms}/{sl}', [MovePropSlipController::class, 'endorsementmpslip']);
    Route::get('/mp-slip/detailmpslip/{fe}', [MovePropSlipController::class, 'detailmpslip']);
    Route::get('/detailmpslip/{fe}', [MovePropSlipController::class, 'detailmpslip']);
    Route::delete('/mp-slip/destroy/{fe}', [MovePropSlipController::class, 'destroy']);
    

    // SECTION HE & Motor Slip Group 
    Route::get('/hem-slip', [HeMotorSlipController::class, 'indexhemslip']);
    Route::get('/hem-slipindex', [HeMotorSlipController::class, 'index']);
    Route::post('/hem-slipindex', [HeMotorSlipController::class, 'index']);
    Route::post('/hem-insured/store', [HeMotorSlipController::class, 'storeheminsured']);
    Route::post('/hem-slip/store', [HeMotorSlipController::class, 'storehemslip']);
    Route::post('/hem-slip/endorsementstore', [HeMotorSlipController::class, 'storeendorsementhemslip']);
    Route::get('/hem-slip/updatehemslip/{fe}', [HeMotorSlipController::class, 'updatehemslip']);
    Route::get('/updatehemslip/{fe}', [HeMotorSlipController::class, 'updatehemslip']);
    Route::get('/endorsementhemslip/{ms}/{sl}', [HeMotorSlipController::class, 'endorsementhemslip']);
    Route::get('/hem-slip/detailhemslip/{fe}', [HeMotorSlipController::class, 'detailhemslip']);
    Route::get('/detailhemslip/{fe}', [HeMotorSlipController::class, 'detailhemslip']);
    Route::delete('/hem-slip/destroy/{fe}', [HeMotorSlipController::class, 'destroy']);
    

    // SECTION Hole in Ones Slip Group Routes
    Route::get('/hio-slip', [TransactionController::class, 'indexhioslip']);
    Route::get('/hio-index', [TransactionController::class, 'indexhio']);
    Route::get('/hio-slip/{id}', [TransactionController::class, 'showlocationdetails'])->name('locDetails');
    Route::post('/hio-insured', [TransactionController::class, 'storehioinsured']);
    Route::post('/hio-slip/store', [TransactionController::class, 'storehioslip']);
    Route::delete('/hio-insured/destroyinsured/{id}', [TransactionController::class, 'destroyhioinsured']);
    Route::delete('/hio-slip/destroyslip/{id}', [TransactionController::class, 'destroyhioslip']);
    Route::get('/hio-endorsement/{id}', [TransactionController::class, 'indexmarineendorsement']);
    Route::get('/hio-slip/{id}', [TransactionController::class, 'showslipdetails']);
    Route::get('/hio-slip/edit/{id}', [TransactionController::class, 'editmarineslip']);
    Route::get('/hio-insured/{id}', [TransactionController::class, 'showinsureddetails']);
    Route::get('/hio-insured/edit/{id}', [TransactionController::class, 'editmarineinsured']);
    Route::post('hio-insured/update/{id}', [TransactionController::class, 'updatemarineinsured']);
    Route::post('/hio-slip/update/{id}', [TransactionController::class, 'updatemarineslip']);
    Route::post('/hio-endorsement', [TransactionController::class, 'storemarineendorsement']);


    // SECTION Personal Accident Slip Group Routes
    Route::get('/pa-slip', [TransactionController::class, 'indexpaslip']);
    Route::get('/pa-index', [TransactionController::class, 'indexpa']);
    Route::get('/pa-slip/{id}', [TransactionController::class, 'showlocationdetails'])->name('locDetails');
    Route::post('/pa-insured', [TransactionController::class, 'storepainsured']);
    Route::post('/pa-slip', [TransactionController::class, 'storepaslip']);
    Route::delete('/pa-insured/destroyinsured/{id}', [TransactionController::class, 'destroypainsured']);
    Route::delete('/pa-slip/destroyslip/{id}', [TransactionController::class, 'destroypaslip']);
 


    // Route::get('/country', [MasterController::class, 'indexcountry'])->middleware(['can:view-country']);
    // Route::post('/country/store', [MasterController::class, 'storecountry'])->middleware(['can:create-country']);
    // Route::put('country/{country}', [MasterController::class, 'updatecountry'])->middleware(['can:update-country']);
    // Route::delete('/country/destroy/{country}', [MasterController::class, 'destroycountry'])->middleware(['can:delete-country']);
    
    // Bulk Excel Import Users
    // Route::get('/import', [ ProductController::class, 'import'])->middleware(['can:create-product']);
    // Route::post('/import', [ ProductController::class, 'importStore'])->middleware(['can:create-product']);
    


});
?>