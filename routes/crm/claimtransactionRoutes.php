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
use App\Http\Controllers\Claim_controller;


Route::post('/store-claimmanual-list','Claim_controller@storemanualamountlist')->name('claimmanual.store');
Route::post('/store-claimlocation-list','Claim_controller@storelocationamountlist')->name('claimlocation.store');
Route::delete('/delete-claimmanual-list/{id}','Claim_controller@destroyamountmanuallist')->name('claimmanual.delete');


Route::group(['prefix'=>'/claimtransaction-data','middleware'=>['auth']], function(){
 
    // Claim Route
    Route::get('claim',[Claim_controller::class,'index']);    
    Route::get('/claim-index', [Claim_controller::class, 'indexclaim'])->name('claimindex');
    Route::post('/claim/store', [Claim_controller::class, 'storeclaiminsured']);
    Route::post('/claim/destroy/{id}', [Claim_controller::class, 'destroy']);
    Route::delete('/claim/destroy/{id}', [Claim_controller::class, 'destroy']);
    Route::get('/detailslipclaim/{idm}', [Claim_controller::class, 'getdetailSlipClaim']);
    Route::get('/detailslipclaimAmount/{idm}', [Claim_controller::class, 'getdetailAmountSlip']);
    Route::get('/detailslipclaimRiskLocation/{idm}', [Claim_controller::class, 'getRiskLocationSlip']);
    Route::get('/updateclaim/{idm}', [Claim_controller::class, 'updateindex']);
    Route::get('/changeinterimclaim/{idm}', [Claim_controller::class, 'changeSlipClaimInterim']);
    Route::get('/changeplaclaim/{idm}', [Claim_controller::class, 'changeSlipClaimPLA']);
    

});
?>